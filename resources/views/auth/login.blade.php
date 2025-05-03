<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            direction: rtl;
        }
        .card {
            text-align: right; /* لضبط النصوص داخل البطاقة باتجاه اليمين */
        }
        .custom-control-label::before {
            order: -1;             /* يجعل المؤشر يظهر قبل النص */
            margin-right: 0.5rem;    /* مسافة صغيرة بين المؤشر والنص في اتجاه RTL */
            margin-left: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/lock.png') }}" alt="قفل" class="img-fluid" style="height: 80px;">
                        <h3 class="mt-2">تسجيل الدخول</h3>
                    </div>

                    <!-- عرض رسائل الأخطاء -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- نموذج تسجيل الدخول -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- حقل البريد الإلكتروني مع أيقونة -->
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" id="email" name="email" class="form-control" placeholder="أدخل بريدك الإلكتروني" value="{{ old('email') }}" required autofocus oninvalid="this.setCustomValidity('يرجى إدخال البريد الإلكتروني')" oninput="this.setCustomValidity('')">
                            </div>
                        </div>
                        <!-- حقل كلمة المرور مع أيقونة -->
                        <div class="form-group">
                            <label for="password">كلمة المرور</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" id="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required oninvalid="this.setCustomValidity('يرجى إدخال كلمة المرور')" oninput="this.setCustomValidity('')">
                            </div>
                        </div>
                        <!-- خيار "تذكرني" -->
                        <!-- خيار "تذكرني" -->
                        <div class="text-right mb-3">
                            <input type="checkbox"  id="remember_me" name="remember">
                            <label  for="remember_me">تذكرني</label>
                        </div>

                        <!-- رابط "نسيت كلمة المرور" -->





                        <!-- زر تسجيل الدخول -->
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ملفات الجافا سكريبت الخاصة بـ Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
