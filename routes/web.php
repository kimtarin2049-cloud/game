<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/',[ContentsController::class, 'index']);
Route::get('/login',[ContentsController::class,'showLogin'])->name('login');
Route::post('/L', [ContentsController::class, 'checkLogin']);
Route::post('/logout', function (Request $request) {
    Auth::logout();

    // ล้าง session และสร้าง Session ID ใหม่เพื่อความปลอดภัย
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // เด้งกลับมาที่หน้าแรก (หน้าสโตร์เกม) พร้อมข้อความแจ้งเตือน
    return redirect('/')->with('welcome', 'ออกจากระบบเรียบร้อยแล้วครับ');
})->name('logout');
Route::get('/games/{id}/edit', [ContentsController::class, 'edit'])->name('games.edit');

// บันทึกการแก้ไขข้อมูลเกม
Route::put('/games/{id}', [ContentsController::class, 'update'])->name('games.update');