<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // عرض نموذج تسجيل الدخول
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // معالجة بيانات تسجيل الدخول
    public function login(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // محاولة تسجيل الدخول مع تذكر المستخدم إذا تم تحديد الخيار
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // تجديد الجلسة لتفادي هجمات Session Fixation
            $request->session()->regenerate();

            // إعادة التوجيه إلى الصفحة الرئيسية أو الصفحة المطلوبة
            return redirect()->intended('/');
        }

        // في حال فشل تسجيل الدخول، إعادة المستخدم مع رسالة خطأ
        return back()->withErrors([
            'email' => 'بيانات الاعتماد المقدمة غير صحيحة.',
        ])->onlyInput('email');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
