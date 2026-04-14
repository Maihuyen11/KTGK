<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController3 extends Controller
{
    // 1. Hiển thị danh sách (Phân trang 10 sản phẩm)
    public function index() {
        // Thay get() bằng paginate(10) để chia mỗi trang đúng 10 máy
        $laptops = Laptop::where('status', 1)->paginate(10);
        
        return view('laptop.admin', compact('laptops'));
    }

    // 2. Xem chi tiết (Trỏ đến file detail.blade.php)
    public function show($id) {
        // Tìm máy có ID tương ứng và status phải bằng 1
        $laptop = Laptop::where('status', 1)->findOrFail($id);
        
        // Trả về view detail của bạn mình vừa làm
        return view('laptop.detail', compact('laptop'));
    }

    // 3. Xóa mềm (Cập nhật status = 0)
    public function destroy($id) {
        $laptop = Laptop::findOrFail($id);
        
        // Cập nhật cột status về 0 thay vì xóa bản ghi khỏi DB
        $laptop->update(['status' => 0]);

        return redirect()->route('laptops.index')
            ->with('success', 'Đã xóa laptop thành công!');
    }
}