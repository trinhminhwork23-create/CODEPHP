-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 07, 2026 lúc 02:16 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sapajadehill_db`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_check_room_availability` (IN `p_room_id` INT, IN `p_check_in` DATE, IN `p_check_out` DATE, OUT `p_is_available` TINYINT)   BEGIN
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
            END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_search_available_rooms` (IN `p_check_in` DATE, IN `p_check_out` DATE, IN `p_guests` INT)   BEGIN
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
        END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `adults` tinyint(4) NOT NULL,
  `children` tinyint(4) NOT NULL DEFAULT 0,
  `total_money` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `cancel_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `room_id`, `check_in`, `check_out`, `adults`, `children`, `total_money`, `status`, `cancel_reason`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2026-06-10', '2026-06-12', 2, 1, 6400000.00, 2, NULL, '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(2, 5, 2, '2026-06-15', '2026-06-16', 2, 0, 3200000.00, 3, 'test thôi', '2026-06-06 15:52:36', '2026-06-06 16:23:28'),
(3, 6, 3, '2026-06-20', '2026-06-23', 4, 2, 9600000.00, 1, NULL, '2026-06-06 15:52:36', '2026-06-06 15:58:14'),
(4, 7, 1, '2026-06-01', '2026-06-03', 2, 0, 6400000.00, 3, NULL, '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(5, 8, 4, '2026-07-01', '2026-07-05', 1, 0, 12800000.00, 2, NULL, '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(6, 9, 2, '2026-07-10', '2026-07-12', 2, 1, 6400000.00, 3, NULL, '2026-06-06 15:52:36', '2026-06-06 16:27:47'),
(7, 10, 3, '2026-07-15', '2026-07-18', 3, 0, 9600000.00, 1, NULL, '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(8, 11, 1, '2026-08-01', '2026-08-02', 2, 0, 3200000.00, 2, NULL, '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(9, 8, 1, '2026-06-07', '2026-06-09', 1, 0, 6400000.00, 0, NULL, '2026-06-06 16:27:47', '2026-06-06 16:27:47');

--
-- Bẫy `bookings`
--
DELIMITER $$
CREATE TRIGGER `tg_calculate_total_money_insert` BEFORE INSERT ON `bookings` FOR EACH ROW BEGIN
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
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_calculate_total_money_update` BEFORE UPDATE ON `bookings` FOR EACH ROW BEGIN
                DECLARE room_price DECIMAL(10,2);
                DECLARE num_days INT;
                
                SELECT price INTO room_price FROM rooms WHERE id = NEW.room_id;
                
                SET num_days = DATEDIFF(NEW.check_out, NEW.check_in);
                IF num_days <= 0 THEN
                    SET num_days = 1;
                END IF;
                
                SET NEW.total_money = num_days * room_price;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_prevent_double_booking` BEFORE INSERT ON `bookings` FOR EACH ROW BEGIN
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `capacity` int(11) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `price`, `capacity`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Villa (Biệt thự biệt lập)', 'Không gian biệt thự sang trọng, thích hợp cho gia đình hoặc nhóm bạn muốn tận hưởng sự riêng tư trọn vẹn giữa mây ngàn Sapa.', 0.00, 1, NULL, 1, '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(2, 'Bungalow (Nhà tre/gỗ mộc mạc)', 'Thiết kế mái cọ, vách gỗ mang đậm hơi thở bản địa Tây Bắc nhưng vẫn đầy đủ tiện nghi cao cấp, view nhìn thẳng ra thung lũng Mường Hoa.', 0.00, 1, NULL, 1, '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(3, 'Deluxe Room (Phòng hạng sang)', 'Phòng tiêu chuẩn khách sạn 5 sao với ban công rộng, không gian ấm cúng, đón trọn ánh nắng ban mai và sương mù Sapa.', 0.00, 1, NULL, 1, '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(4, 'Studio Room (Phòng căn hộ tiện ích)', 'Không gian tích hợp thông minh giữa phòng ngủ và khu vực bếp nhỏ tiện lợi, cực kỳ lý tưởng cho các cặp đôi đi nghỉ dưỡng dài ngày.', 0.00, 1, NULL, 1, '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(5, 'Khu Biệt Thự Triền Núi (Nest Villa)', 'Khu biệt thự cao cấp nằm lọt thỏm giữa triền núi, mang lại không gian tĩnh lặng và riêng tư tuyệt đối.', 0.00, 1, NULL, 1, '2026-06-06 15:52:35', '2026-06-06 15:52:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_06_01_000001_create_users_table', 1),
(2, '2026_06_01_000002_create_categories_table', 1),
(3, '2026_06_01_000003_create_rooms_table', 1),
(4, '2026_06_01_000004_create_bookings_table', 1),
(5, '2026_06_01_000005_create_payments_table', 1),
(6, '2026_06_01_000006_create_reviews_table', 1),
(7, '2026_06_02_000000_create_triggers_and_procedures_and_views', 1),
(8, '2026_06_02_000001_add_phone_to_users_table', 1),
(9, '2026_06_06_034012_update_categories_table', 1),
(10, '2026_06_06_232206_add_cancel_reason_to_bookings_table', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `vnp_txn_ref` varchar(100) NOT NULL,
  `vnp_transaction_no` varchar(100) NOT NULL,
  `vnp_amount` decimal(12,2) NOT NULL,
  `vnp_bank_code` varchar(50) NOT NULL,
  `vnp_response_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `vnp_txn_ref`, `vnp_transaction_no`, `vnp_amount`, `vnp_bank_code`, `vnp_response_code`, `created_at`) VALUES
(1, 1, 'VNP_20260601_001', '13526547', 500000000.00, 'NCB', '00', '2026-06-06 15:52:36'),
(2, 5, 'VNP_20260701_002', '13526588', 600000000.00, 'VIETCOMBANK', '00', '2026-06-06 15:52:36'),
(3, 8, 'VNP_20260801_003', '13526599', 250000000.00, 'VNPAYQR', '00', '2026-06-06 15:52:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `room_id`, `rating`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 5, 'Phòng Panorama cực đẹp, bồn tắm ngâm chân lá dao đỏ rất thư giãn.', 1, '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(2, 4, 2, 4, 'View thung lũng sương mù rất đẹp, tuy nhiên phòng hơi xa nhà hàng.', 1, '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(3, 5, 3, 1, 'Mạng wifi quá yếu, không làm việc được!!', 0, '2026-06-06 15:52:36', '2026-06-06 15:52:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_code` varchar(50) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `capacity` tinyint(4) NOT NULL,
  `bed_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `room_code`, `category_id`, `name`, `location`, `price`, `image`, `size`, `capacity`, `bed_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SJD-101', 1, 'Bungalow Panorama P1', 'Khu Rừng Thông', 3200000.00, 'panorama_101.jpg', 40, 2, '1 King Bed', 'Phòng có ban công lớn, bồn tắm ngâm thảo dao đỏ.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(2, 'SJD-102', 1, 'Bungalow Panorama P2', 'Khu Rừng Thông', 3200000.00, 'panorama_102.jpg', 40, 2, '2 Single Beds', 'Phòng có ban công lớn, bồn tắm ngâm thảo dao đỏ.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(3, 'SJD-103', 1, 'Bungalow Panorama P3', 'Khu Rừng Thông', 3200000.00, 'panorama_103.jpg', 40, 2, '1 King Bed', 'Gần lối đi nội khu, view trọn vẹn thung lũng.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(4, 'SJD-104', 1, 'Bungalow Panorama P4', 'Khu Rừng Thông', 3200000.00, 'panorama_104.jpg', 40, 2, '1 King Bed', 'Nội thất gỗ mộc mạc, lò sưởi giả.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(5, 'SJD-201', 2, 'Bungalow Mountain M1', 'Khu Sườn Núi', 2800000.00, 'mountain_201.jpg', 40, 2, '1 King Bed', 'Tầm nhìn ra rừng thông và đỉnh Fansipan mờ ảo.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(6, 'SJD-202', 2, 'Bungalow Mountain M2', 'Khu Sườn Núi', 2800000.00, 'mountain_202.jpg', 40, 2, '2 Single Beds', 'Hướng núi, trang bị quạt sưởi, bàn làm việc.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(7, 'SJD-203', 2, 'Bungalow Mountain M3', 'Khu Sườn Núi', 2800000.00, 'mountain_203.jpg', 40, 2, '1 King Bed', 'Tầm nhìn ra rừng thông, gần khu vui chơi trẻ em.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(8, 'SJD-204', 2, 'Bungalow Mountain M4', 'Khu Sườn Núi', 2800000.00, 'mountain_204.jpg', 40, 2, '1 King Bed', 'Góc view sống ảo cực đẹp, riêng tư tuyệt đối.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(9, 'SJD-304', 3, 'Deluxe Bungalow D4', 'Khu Nest Castle', 2500000.00, 'deluxe_304.jpg', 40, 2, '1 King Bed', 'Không gian mở, ánh sáng tự nhiên ngập tràn.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(10, 'SJD-401', 4, 'Deluxe Valley View V1', 'Khu Tòa Nhà Trung Tâm', 1800000.00, 'valley_401.jpg', 30, 2, '1 King Bed', 'Nằm trong tòa nhà chính, phù hợp du khách ngại di chuyển xa.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(11, 'SJD-402', 4, 'Deluxe Valley View V2', 'Khu Tòa Nhà Trung Tâm', 1800000.00, 'valley_402.jpg', 30, 2, '2 Single Beds', 'Phòng có ban công nhỏ, view nhìn ra thung lũng.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(12, 'SJD-403', 4, 'Deluxe Valley View V3', 'Khu Tòa Nhà Trung Tâm', 1800000.00, 'valley_403.jpg', 30, 2, '1 King Bed', 'Nội thất hiện đại, phòng tắm kính sang trọng.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(13, 'SJD-404', 4, 'Deluxe Valley View V4', 'Khu Tòa Nhà Trung Tâm', 1800000.00, 'valley_404.jpg', 30, 2, '1 King Bed', 'Phòng yên tĩnh, thích hợp cho nghỉ dưỡng.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(14, 'SJD-501', 5, 'Nest Villa N1 - Biệt Thự Tổ Chim', 'Khu Biệt Thự Triền Núi', 6500000.00, 'nest_501.jpg', 90, 5, '1 King Bed & 2 Single Beds', 'Biệt thự 3 phòng ngủ, phòng khách rộng rãi, bếp đầy đủ tiện nghi.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(15, 'SJD-502', 5, 'Nest Villa N2 - Biệt Thự Tổ Chim', 'Khu Biệt Thự Triền Núi', 6500000.00, 'nest_502.jpg', 90, 5, '2 Double Beds', 'Không gian sinh hoạt chung lớn, BBQ ngoài trời tự túc.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(16, 'SJD-503', 5, 'Nest Villa N3 - Biệt Thự Tổ Chim', 'Khu Biệt Thự Triền Núi', 6500000.00, 'nest_503.jpg', 90, 5, '1 Double Bed & 2 Single Beds', 'Ban công rộng, 2 phòng tắm riêng biệt, dịch vụ quản gia.', '2026-06-06 15:52:35', '2026-06-06 15:52:35'),
(17, 'SJD-504', 5, 'Nest Villa N4 - Biệt Thự Tổ Chim', 'Khu Biệt Thự Triền Núi', 6500000.00, 'nest_504.jpg', 90, 5, '2 Double Beds', 'View đỉnh Fansipan hùng vĩ, không gian yên tĩnh.', '2026-06-06 15:52:35', '2026-06-06 15:52:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Quản trị viên', 'admin@sapajadehill.com', NULL, '$2y$12$QtsigP67G9YM6uMVSN44UO/ayLhdiz/BP77HnIGBIurJNv9DTo.bC', 'admin', 1, 'RvRic4EpigqVeVkttc5L4EzsHfwwEITXDlT2PFx55zGmQmuWRKyKTZAgCVVQ', '2026-06-06 15:52:36', '2026-06-06 15:57:27'),
(2, 'Lễ tân Thu Hà', 'thuha.staff@sapajadehill.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, 'gOIb4XlAli', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(3, 'CSKH Minh Tuấn', 'minhtuan.staff@sapajadehill.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '5ZJRlntfiE', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(4, 'Nguyễn Văn An', 'nguyenvanan@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'b1SAGZR8fY', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(5, 'Trần Thị Bích', 'bichtran9x@gmail.com', NULL, '$2y$12$mUPZNnBeefEXTD7FhhANN.skLbapJNrMS5lDAkdhSqEmiULYub6pe', 'customer', 1, 'OAlrdZ6YvUytc2wqBRsqQb3W4XwyOBGWoFKQhDBcE2mw1lHh0zkOB5twKqsN', '2026-06-06 15:52:36', '2026-06-06 17:27:40'),
(6, 'Lê Hoàng Long', 'longle.hoang@yahoo.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'OHKHgekTH3', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(7, 'Phạm Quang Khải', 'quangkhai.pham@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'BPWk5jM5bb', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(8, 'Đặng Thu Thảo', 'thuthaodang@hotmail.com', NULL, '$2y$12$RS0RWBCAAPQSUboc.oEw/euj0PH49r7En0JFVBGv7Wrzaya7dYBTi', 'customer', 1, 'mbCzXTGNzZv6yTKkg97fM4iZlu1P9L6merWv7HBlJXdnFhlkuyf603TV7XeD', '2026-06-06 15:52:36', '2026-06-06 16:26:03'),
(9, 'Bùi Hữu Trí', 'huutri.bui@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'zNopvVaFVE', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(10, 'Võ Ngọc Mai', 'ngocmai.vo@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, '86JT69jUoc', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(11, 'Đỗ Quỳnh Anh', 'quynhanh.do2000@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'j5VVqQwjkF', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(12, 'Lý Tiểu Long', 'lytieulong@bruce.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'fY5jMBunxj', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(13, 'Hồ Gia Hân', 'giahan.ho@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'qvwKv60jNJ', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(14, 'Vũ Văn Thanh', 'vanthanh.vu@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'Kr1vjE5L0H', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(15, 'Ngô Phương Lan', 'phuonglan.ngo@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'O587jia9Mr', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(16, 'Trịnh Đình Quang', 'dinhquang.trinh@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'w99VYR8ND6', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(17, 'Châu Tinh Trì', 'tinhtri.chau@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'woATBrLpol', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(18, 'Mai Phương Thúy', 'phuongthuy.mai@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'kJqfTIYwdc', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(19, 'Hoàng Thùy Linh', 'thuylinh.hoang@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 1, 'vlWEybijcv', '2026-06-06 15:52:36', '2026-06-06 15:52:36'),
(20, 'Spammer Bị Khóa', 'spam.hacker@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 0, 'HIfySoBRSw', '2026-06-06 15:52:36', '2026-06-06 15:52:36');

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `v_room_availability`
-- (See below for the actual view)
--
CREATE TABLE `v_room_availability` (
`room_id` bigint(20) unsigned
,`room_name` varchar(255)
,`price` decimal(10,2)
,`capacity` tinyint(4)
,`bed_type` varchar(100)
,`description` text
,`availability_status` varchar(9)
);

-- --------------------------------------------------------

--
-- Cấu trúc cho view `v_room_availability`
--
DROP TABLE IF EXISTS `v_room_availability`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_room_availability`  AS SELECT `r`.`id` AS `room_id`, `r`.`name` AS `room_name`, `r`.`price` AS `price`, `r`.`capacity` AS `capacity`, `r`.`bed_type` AS `bed_type`, `r`.`description` AS `description`, CASE WHEN exists(select 1 from `bookings` `b` where `b`.`room_id` = `r`.`id` AND `b`.`status` in (1,2) AND (curdate() >= `b`.`check_in` AND curdate() < `b`.`check_out` OR curdate() > `b`.`check_in` AND curdate() <= `b`.`check_out` OR curdate() <= `b`.`check_in` AND curdate() >= `b`.`check_out`) limit 1) THEN 'Đã đặt' ELSE 'Còn trống' END AS `availability_status` FROM `rooms` AS `r` ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_room_id_foreign` (`room_id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_code_unique` (`room_code`),
  ADD KEY `rooms_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
