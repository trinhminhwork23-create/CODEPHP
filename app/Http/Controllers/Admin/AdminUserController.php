<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(Request $request, User $user)
    {
        $request->validate([
            'lock_reason' => 'required|string|min:10|max:1000',
        ], [
            'lock_reason.required' => 'Vui lòng nhập lý do khóa/mở khóa tài khoản!',
            'lock_reason.min' => 'Lý do phải có ít nhất 10 ký tự.',
            'lock_reason.max' => 'Lý do không được vượt quá 1000 ký tự.',
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể tự khóa tài khoản của chính mình!');
        }

        $user->is_locked = !$user->is_locked;
        $user->lock_reason = $request->input('lock_reason');
        $user->save();

        $action = $user->is_locked ? 'khóa' : 'mở khóa';
        return back()->with('success', 'Đã ' . $action . ' tài khoản thành công!');
    }
}
