<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CrudTrait
{
    /** ردّ JSON موحّد للعمليات الناجحة */
    protected function ok(string $message = 'تم الحفظ بنجاح', int $code = 200)
    {
        return response()->json(['status' => true, 'message' => $message], $code);
    }

    /** التحقق من طلب Ajax + عودة رد خطأ عند الفشل */
    protected function ensureAjax(Request $request)
    {
        abort_unless($request->ajax(), 400, 'Bad Request');
    }
}
