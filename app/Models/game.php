<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class game extends Model
{
    use HasFactory;

    protected $table = 'game'; // ระบุชื่อตารางในฐานข้อมูลให้ตรงกับ phpMyAdmin
}
