<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController
{
    // ─────────────────────────────────────────────────────────────────────────
    // UC13 - Xem danh sách loại phòng - Luồng chính
    // ─────────────────────────────────────────────────────────────────────────
    public function index()
    {
        try {
            $categories = Category::orderBy('created_at', 'desc')->get();
            return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể tải danh sách loại phòng. Vui lòng thử lại.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC14 - Thêm loại phòng mới - Luồng chính
    // Luồng phụ 1: Tên trùng lặp
    // Luồng phụ 2: Dữ liệu không hợp lệ
    // ─────────────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0.01',
            'capacity'    => 'required|integer|min:1',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status'      => 'boolean',
        ], [
            'name.required'    => 'Vui lòng nhập tên loại phòng.',
            'name.unique'      => 'Tên loại phòng này đã tồn tại.',
            'price.required'   => 'Vui lòng nhập giá phòng.',
            'price.numeric'    => 'Giá phòng phải là số.',
            'price.min'        => 'Giá phòng phải lớn hơn 0.',
            'capacity.required'=> 'Vui lòng nhập sức chứa.',
            'capacity.integer' => 'Sức chứa phải là số nguyên.',
            'capacity.min'     => 'Sức chứa phải ít nhất là 1.',
            'image.required'   => 'Vui lòng chọn ảnh đại diện.',
            'image.image'      => 'File tải lên phải là ảnh.',
            'image.mimes'      => 'Ảnh phải có định dạng jpeg, png hoặc jpg.',
            'image.max'        => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        try {
            $imagePath = $request->file('image')->store('categories', 'public');

            Category::create([
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
                'capacity'    => $request->capacity,
                'image'       => $imagePath,
                'status'      => $request->input('status', 1),
            ]);

            return back()->with('success', 'Thêm loại phòng mới thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi thêm loại phòng. Vui lòng thử lại.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC15 - Cập nhật loại phòng - Luồng chính
    // Luồng phụ 1: Tên trùng với loại phòng khác
    // Luồng phụ 2: Có ảnh mới => xóa ảnh cũ
    // ─────────────────────────────────────────────────────────────────────────
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0.01',
            'capacity'    => 'required|integer|min:1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'      => 'boolean',
        ], [
            'name.required'    => 'Vui lòng nhập tên loại phòng.',
            'name.unique'      => 'Tên loại phòng này đã tồn tại.',
            'price.required'   => 'Vui lòng nhập giá phòng.',
            'price.numeric'    => 'Giá phòng phải là số.',
            'price.min'        => 'Giá phòng phải lớn hơn 0.',
            'capacity.required'=> 'Vui lòng nhập sức chứa.',
            'capacity.integer' => 'Sức chứa phải là số nguyên.',
            'capacity.min'     => 'Sức chứa phải ít nhất là 1.',
            'image.image'      => 'File tải lên phải là ảnh.',
            'image.mimes'      => 'Ảnh phải có định dạng jpeg, png hoặc jpg.',
            'image.max'        => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        try {
            $data = [
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
                'capacity'    => $request->capacity,
                'status'      => $request->input('status', $category->status),
            ];

            if ($request->hasFile('image')) {
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }
                $data['image'] = $request->file('image')->store('categories', 'public');
            }

            $category->update($data);

            return back()->with('success', 'Cập nhật loại phòng thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật loại phòng. Vui lòng thử lại.');
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UC16 - Xóa loại phòng - Luồng chính
    // Luồng phụ: Loại phòng đang có phòng liên kết => chặn xóa
    // ─────────────────────────────────────────────────────────────────────────
    public function destroy(Category $category)
    {
        try {
            $imagePath = $category->image;
            $category->delete();

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()->with('success', 'Xóa loại phòng thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Không cho phép xóa loại phòng đang được sử dụng.');
        }
    }
}
