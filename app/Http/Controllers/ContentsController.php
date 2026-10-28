<?php

namespace App\Http\Controllers;

use App\Models\game;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\gameRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ContentsController extends Controller
{
    public function index()
    {
        $games = game::all();


        $tags = $games
            ->pluck('tags')
            ->flatMap(function ($tag) {
                return explode(',', $tag);
            })
             ->map(function ($tag) {
                return trim($tag);
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();
         
        return view('game.index', compact('games','tags'));
    }

    public function showLogin()
    {
        return View('game.login');
    }

    public function checkLogin(Request $request)
    {
        // 1. ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม (เปลี่ยนจาก email เป็น username)
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. ทำการตรวจสอบสิทธิ์ด้วย username และ password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $request->session()->put('welcome', 'Welcome Admin');

            return redirect()->intended('/'); // เปลี่ยนเส้นทางหลังล็อกอินสำเร็จ
        }

        // 3. ถ้าล็อกอินไม่สำเร็จ ให้เด้งกลับพร้อมแสดง Error
        return back()->withErrors([
            'username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    public function edit($id)
    {
        $game = Game::findOrFail($id);
        // ดึงรายชื่อ Tag ทั้งหมดมาแสดงในหน้าแก้ไข (ถ้ามีระบบจัดการ Tag)
        $tags = ['Action', 'RPG', 'Adventure', 'Indie', 'Strategy']; // หรือดึงมาจากฐานข้อมูลของคุณ
        
        return view('game.edit', compact('game', 'tags'));
    }

    // 2. บันทึกข้อมูลที่แก้ไขลงฐานข้อมูล
    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        // ตรวจสอบและอัปเดตข้อมูล
        $game->topics = $request->input('topics');
        $game->descriptions = $request->input('descriptions');
        $game->price = $request->input('price');
        $game->tags = $request->input('tags');
        $game->staem = $request->has('staem') ? 1 : 0;
        $game->Epic_Games = $request->has('Epic_Games') ? 1 : 0;
        
        // จัดการอัปโหลดรูปภาพใหม่ (ถ้ามี)
        // ...

        $game->save();

        return redirect('/')->with('welcome', 'แก้ไขข้อมูลเกมเรียบร้อยแล้วครับ');
    }
}
