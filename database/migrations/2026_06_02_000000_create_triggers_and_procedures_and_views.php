<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. TRIGGER: Tự động tính tổng tiền TRƯỚC KHI INSERT đơn đặt phòng mới
        DB::unprepared("
            CREATE TRIGGER tg_calculate_total_money_insert
            BEFORE INSERT ON bookings
            FOR EACH ROW
            BEGIN
                DECLARE room_price DECIMAL(10,2);
                DECLARE num_days INT;
                
                -- Lấy giá phòng dựa trên room_id mới
                SELECT price INTO room_price FROM rooms WHERE id = NEW.room_id;
                
                -- Tính số ngày ở (Nếu cùng ngày thì tính là 1 ngày)
                SET num_days = DATEDIFF(NEW.check_out, NEW.check_in);
                IF num_days <= 0 THEN
                    SET num_days = 1;
                END IF;
                
                -- Cập nhật tổng tiền vào bản ghi chuẩn bị lưu
                SET NEW.total_money = num_days * room_price;
            END
        ");

        // 2. TRIGGER: Tự động tính lại tổng tiền TRƯỚC KHI UPDATE (khi khách đổi ngày hoặc đổi phòng)
        DB::unprepared("
            CREATE TRIGGER tg_calculate_total_money_update
            BEFORE UPDATE ON bookings
            FOR EACH ROW
            BEGIN
                DECLARE room_price DECIMAL(10,2);
                DECLARE num_days INT;
                
                SELECT price INTO room_price FROM rooms WHERE id = NEW.room_id;
                
                SET num_days = DATEDIFF(NEW.check_out, NEW.check_in);
                IF num_days <= 0 THEN
                    SET num_days = 1;
                END IF;
                
                SET NEW.total_money = num_days * room_price;
            END
        ");

        // 3. TRIGGER: Ngăn chặn việc tạo đơn đặt phòng mới nếu có lịch trùng với đơn đã duyệt hoặc đã thanh toán
        DB::unprepared("
        CREATE TRIGGER tg_prevent_double_booking
        BEFORE INSERT ON bookings
        FOR EACH ROW
        BEGIN
            DECLARE booking_conflict_count INT;
    
            -- Kiểm tra phòng định đặt có lịch trùng và ở trạng thái đã duyệt (1) hoặc đã thanh toán (2) hay không
            SELECT COUNT(*) INTO booking_conflict_count
            FROM bookings
            WHERE room_id = NEW.room_id
                AND status IN (1, 2) 
                AND NOT (NEW.check_out <= check_in OR NEW.check_in >= check_out);
      
            IF booking_conflict_count > 0 THEN
                SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Xin lỗi, căn phòng này đã có người đặt và thanh toán trong khoảng thời gian bạn chọn.';
        END IF;
        END
");

        DB::unprepared("DROP PROCEDURE IF EXISTS sp_check_room_availability");
        // 4. STORED PROCEDURE: Kiểm tra xem một phòng cụ thể có bị trùng lịch trong khoảng ngày chọn hay không
        // Kết quả trả về biến p_is_available (1: Còn trống, 0: Đã bị đặt)
        DB::unprepared("
            CREATE PROCEDURE sp_check_room_availability(
                IN p_room_id INT,
                IN p_check_in DATE,
                IN p_check_out DATE,
                OUT p_is_available TINYINT
            )
            BEGIN
                DECLARE booking_count INT;
                
                -- Đếm các đơn đặt phòng có trạng thái đã duyệt(1) hoặc đã thanh toán(2) bị chồng lấn ngày
                SELECT COUNT(*) INTO booking_count
                FROM bookings
                WHERE room_id = p_room_id
                  AND status IN (1, 2)
                  AND (
                      (p_check_in >= check_in AND p_check_in < check_out) OR
                      (p_check_out > check_in AND p_check_out <= check_out) OR
                      (p_check_in <= check_in AND p_check_out >= check_out)
                  );
                  
                -- Nếu có đơn trùng, gán bằng 0 (Không trống), ngược lại gán bằng 1 (Trống)
                IF booking_count > 0 THEN
                    SET p_is_available = 0;
                ELSE
                    SET p_is_available = 1;
                END IF;
            END
        ");

        DB::unprepared("DROP PROCEDURE IF EXISTS sp_search_available_rooms");
        // 5. STORED PROCEDURE: Tìm kiếm các phòng còn trống trong khoảng ngày và đủ sức chứa cho số khách
        DB::unprepared("
        CREATE PROCEDURE sp_search_available_rooms(
            IN p_check_in DATE,
            IN p_check_out DATE,
            IN p_guests INT
        )
        BEGIN
            SELECT r.*, c.name AS category_name
            FROM rooms r
            JOIN categories c ON r.category_id = c.id
            WHERE r.capacity >= p_guests -- Lọc theo sức chứa tối đa người lớn
            AND r.id NOT IN (
                -- Loại bỏ các phòng đã được đặt trùng lịch (status đã duyệt hoặc đã thanh toán)
                SELECT room_id
                FROM bookings
                WHERE status IN (1, 2)
                    AND NOT (p_check_out <= check_in OR p_check_in >= check_out)
            )
            ORDER BY r.price ASC;
        END
        ");

        DB::unprepared("DROP VIEW IF EXISTS v_room_availability");
        // 6. VIEW: Hiển thị danh sách phòng kèm trạng thái còn trống hay đã đặt dựa trên ngày hiện tại
        DB::unprepared("
            CREATE VIEW v_room_availability AS
            SELECT 
                r.id AS room_id,
                r.name AS room_name,
                r.price,
                r.capacity,
                r.bed_type,
                r.description,
                CASE 
                    WHEN EXISTS (
                        SELECT 1 
                        FROM bookings b 
                        WHERE b.room_id = r.id 
                          AND b.status IN (1, 2) 
                          AND (
                              (CURDATE() >= b.check_in AND CURDATE() < b.check_out) OR
                              (CURDATE() > b.check_in AND CURDATE() <= b.check_out) OR
                              (CURDATE() <= b.check_in AND CURDATE() >= b.check_out)
                          )
                    ) THEN 'Đã đặt'
                    ELSE 'Còn trống'
                END AS availability_status
            FROM rooms r
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa trigger và procedure khi thực hiện lệnh rollback/fresh
        DB::unprepared("DROP TRIGGER IF EXISTS tg_calculate_total_money_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS tg_calculate_total_money_update");
        DB::unprepared("DROP TRIGGER IF EXISTS tg_prevent_double_booking");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_check_room_availability");
        DB::unprepared("DROP VIEW IF EXISTS v_room_availability");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_search_available_rooms");
    }
};