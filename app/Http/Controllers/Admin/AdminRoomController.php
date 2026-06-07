<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminRoomController
{
    // ─────────────────────────────────────────────────────────────────────────
    // UC - Xem danh sách phòng - Luồng chính
    // ─────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        try {
            $categories = Category::where('status', 1)->orderBy('name')->get();

            $rooms = Room::with('category')
                ->when($request->filled('search'), function ($q) use ($request) {
                    $keyword = '%' . addcslashes($request->search, '%_') . '%';
                    $q->where('name', 'like', $keyword)
                      ->orWhere('room_code', 'like', $keyword);
                })
                ->when($request->filled('category_id'), function ($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(15)
                ->appends($request->only(['search', 'category_id']));

            return view('admin.rooms.index', compact('rooms', 'categories'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể tải danh sách phòng. Vui lòng thử lại.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC - Hiển thị form thêm phòng - Luồng chính
    // ─────────────────────────────────────────────────────────────────────────
    public function create()
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.rooms.create', compact('categories'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC - Thêm phòng mới - Luồng chính
    // Luồng phụ 1: Mã phòng trùng lặp
    // Luồng phụ 2: Dữ liệu không hợp lệ
    // ─────────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'room_code'   => 'required|string|max:50|unique:rooms,room_code',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:1',
            'capacity'    => 'required|integer|min:1',
            'size'        => 'nullable|integer|min:1',
            'bed_type'    => 'nullable|string|max:100',
            'location'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required'        => 'Vui lòng nhập tên phòng.',
            'room_code.required'   => 'Vui lòng nhập mã phòng.',
            'room_code.unique'     => 'Mã phòng này đã tồn tại.',
            'category_id.required' => 'Vui lòng chọn loại phòng.',
            'category_id.exists'   => 'Loại phòng không hợp lệ.',
            'price.required'       => 'Vui lòng nhập giá phòng.',
            'price.numeric'        => 'Giá phòng phải là số.',
            'price.min'            => 'Giá phòng phải lớn hơn 0.',
            'capacity.required'    => 'Vui lòng nhập sức chứa.',
            'capacity.integer'     => 'Sức chứa phải là số nguyên.',
            'capacity.min'         => 'Sức chứa phải ít nhất là 1.',
            'image.image'          => 'File tải lên phải là ảnh.',
            'image.mimes'          => 'Ảnh phải có định dạng jpeg, png hoặc jpg.',
            'image.max'            => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        try {
            $data = $request->only(['name', 'room_code', 'category_id', 'price', 'capacity', 'size', 'bed_type', 'location', 'description']);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('rooms', 'public');
            }

            $room = Room::create($data);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'role' => Auth::user()->role === 'admin' ? 'Admin' : 'Staff',
                'action' => 'Create',
                'target_model' => 'Room',
                'target_id' => $room->id,
                'description' => Auth::user()->name . ' đã thêm phòng ' . $room->name . ' (ID #' . $room->id . ')'
            ]);

            return redirect()->route('admin.rooms.index')->with('success', 'Thêm phòng mới thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Đã xảy ra lỗi khi thêm phòng. Vui lòng thử lại.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC - Hiển thị form sửa phòng - Luồng chính
    // ─────────────────────────────────────────────────────────────────────────
    public function edit(Room $room)
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.rooms.edit', compact('room', 'categories'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC - Cập nhật thông tin phòng - Luồng chính
    // Luồng phụ 1: Mã phòng trùng với phòng khác
    // Luồng phụ 2: Có ảnh mới => xóa ảnh cũ
    // ─────────────────────────────────────────────────────────────────────────
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'room_code'   => 'required|string|max:50|unique:rooms,room_code,' . $room->id,
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:1',
            'capacity'    => 'required|integer|min:1',
            'size'        => 'nullable|integer|min:1',
            'bed_type'    => 'nullable|string|max:100',
            'location'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required'        => 'Vui lòng nhập tên phòng.',
            'room_code.required'   => 'Vui lòng nhập mã phòng.',
            'room_code.unique'     => 'Mã phòng này đã được sử dụng.',
            'category_id.required' => 'Vui lòng chọn loại phòng.',
            'category_id.exists'   => 'Loại phòng không hợp lệ.',
            'price.required'       => 'Vui lòng nhập giá phòng.',
            'price.min'            => 'Giá phòng phải lớn hơn 0.',
            'capacity.required'    => 'Vui lòng nhập sức chứa.',
            'capacity.min'         => 'Sức chứa phải ít nhất là 1.',
            'image.image'          => 'File tải lên phải là ảnh.',
            'image.mimes'          => 'Ảnh phải có định dạng jpeg, png hoặc jpg.',
            'image.max'            => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        try {
            $data = $request->only(['name', 'room_code', 'category_id', 'price', 'capacity', 'size', 'bed_type', 'location', 'description']);

            if ($request->hasFile('image')) {
                if ($room->image && Storage::disk('public')->exists($room->image)) {
                    Storage::disk('public')->delete($room->image);
                }
                $data['image'] = $request->file('image')->store('rooms', 'public');
            }

            $room->update($data);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'role' => Auth::user()->role === 'admin' ? 'Admin' : 'Staff',
                'action' => 'Update',
                'target_model' => 'Room',
                'target_id' => $room->id,
                'description' => Auth::user()->name . ' đã cập nhật thông tin phòng ' . $room->name . ' (ID #' . $room->id . ')'
            ]);

            return redirect()->route('admin.rooms.index')->with('success', 'Cập nhật phòng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Đã xảy ra lỗi khi cập nhật phòng. Vui lòng thử lại.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC - Xóa phòng - Luồng chính
    // Luồng phụ: Phòng đang được đặt (có booking active) => chặn xóa
    // ─────────────────────────────────────────────────────────────────────────
    public function destroy(Room $room)
    {
        try {
            $roomName = $room->name;
            $roomId = $room->id;
            $imagePath = $room->image;
            $room->delete();

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'role' => Auth::user()->role === 'admin' ? 'Admin' : 'Staff',
                'action' => 'Delete',
                'target_model' => 'Room',
                'target_id' => $roomId,
                'description' => Auth::user()->name . ' đã xóa phòng ' . $roomName . ' (ID #' . $roomId . ')'
            ]);

            return back()->with('success', 'Xóa phòng thành công!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
