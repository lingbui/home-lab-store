<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Jobs\SendPromotionEmail;
use App\Mail\SendEmail;
use App\Support\Esms;

class PromotionController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name')->get(['id', 'name', 'email', 'phone_number']);
        return view('admin.promotion', ['customers' => $customers]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:150',
            'content' => 'required|max:2000',
            'channels' => 'required|array|min:1',
            'channels.*' => 'in:email,sms',
            'customer_ids' => 'required_unless:test,1|array',
            'customer_ids.*' => 'integer',
        ], [
            'channels.required' => 'Chọn ít nhất một kênh gửi (email hoặc SMS).',
            'customer_ids.required_unless' => 'Chọn ít nhất một khách hàng.',
        ]);

        $subject = $request->input('subject');
        $content = $request->input('content');
        $channels = $request->input('channels', []);
        $home = url('/');
        $logo = asset('images/icons/logo-store.png');

        // Gửi thử: chỉ gửi email cho chính quản trị viên đang đăng nhập
        if ($request->boolean('test')) {
            $admin = Auth::guard('admin')->user();
            Mail::to($admin->email)->send(new SendEmail([
                'home' => $home, 'subject' => '[Thử] ' . $subject, 'logo' => $logo,
                'name' => 'Xin chào ' . $admin->name . '! ' . $content, 'link' => $home, 'image' => '',
            ]));
            return back()->with('success', 'Đã gửi email thử tới ' . $admin->email);
        }

        $customers = Customer::whereIn('id', $request->input('customer_ids', []))->get();
        $messages = [];

        if (in_array('email', $channels)) {
            $sent = 0;
            foreach ($customers as $customer) {
                if (empty($customer->email)) {
                    continue;
                }
                SendPromotionEmail::dispatch([
                    'email' => $customer->email,
                    'home' => $home,
                    'subject' => $subject,
                    'logo' => $logo,
                    'name' => 'Xin chào ' . $customer->name . '! ' . $content,
                    'link' => $home,
                    'image' => '',
                ]);
                $sent++;
            }
            $messages[] = "Email: đã đưa $sent thư vào hàng đợi gửi.";
        }

        if (in_array('sms', $channels)) {
            $phones = $customers->pluck('phone_number')->filter()->all();
            $smsText = $subject . ': ' . $content;
            $result = (new Esms())->sendAdvertising($phones, $smsText);
            $messages[] = 'SMS: ' . $result['message'];
        }

        return back()->with('success', implode(' ', $messages));
    }
}
