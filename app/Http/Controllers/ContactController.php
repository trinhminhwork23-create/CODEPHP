<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Vui lòng nhập họ và tên.',
            'email.required'   => 'Vui lòng nhập địa chỉ email.',
            'email.email'      => 'Email không hợp lệ.',
            'message.required' => 'Vui lòng nhập lời nhắn.',
        ]);

        Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
            'status'  => Contact::STATUS_NEW,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }
}
