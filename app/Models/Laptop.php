<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $table = 'san_pham';
    
    // THÊM DÒNG NÀY ĐỂ TẮT TIMESTAMP
    public $timestamps = false;

    protected $fillable = ['title', 'cpu', 'ram', 'luu_tru', 'khoi_luong', 'gia', 'image', 'status'];
}