<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccess;

class LaptopController2 extends Controller
{
    /**
     * Hàm dùng chung để lấy dữ liệu cho Layout.
     * Đảm bảo luôn có $categories và $title để layout của thầy không bị lỗi Undefined.
     */
    private function getLayoutData($customTitle = 'Cửa hàng Laptop') {
        return [
            'categories' => DB::table('danh_muc_laptop')->get(),
            'title' => $customTitle // Gán trực tiếp giá trị vào biến title ở đây
        ];
    }

    // CÂU 5: Tìm kiếm laptop [cite: 5, 15]
    public function search(Request $request)
    {
        $layoutData = $this->getLayoutData('Kết quả tìm kiếm');
        $keyword = $request->input('keyword');

        $laptops = DB::table('san_pham')
            ->where('status', 1) // Chỉ lấy sản phẩm chưa bị xóa mềm (Câu 7) [cite: 23]
            ->where('tieu_de', 'LIKE', "%$keyword%")
            ->paginate(20); 

        // Gộp dữ liệu sản phẩm với dữ liệu layout
        $data = array_merge($layoutData, [
            'laptops' => $laptops,
            'keyword' => $keyword
        ]);

        return view('search_results', $data);
    }

    // CÂU 4: Hiển thị giỏ hàng 
    public function viewCart()
    {
        $layoutData = $this->getLayoutData('Giỏ hàng của bạn');
        $cart = session()->get('cart', []);

        $data = array_merge($layoutData, [
            'cart' => $cart
        ]);

        return view('cart', $data);
    }

    // CÂU 4: Xử lý đặt hàng & Gửi mail [cite: 14]
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        // 1. Lưu đơn hàng vào database [cite: 14]
        $donHangId = DB::table('don_hang')->insertGetId([
            'user_id' => auth()->id() ?? 0,            
            'ngay_dat' => now(),
            'tong_tien' => array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)),
            'hinh_thuc_thanh_toan' => $request->payment_method ?? 'Tiền mặt',
            'status' => 0 // 0 = Chờ xử lý, 1 = Đang giao, 2 = Hoàn thành, 3 = Hủy (Câu 7 bổ sung) [cite: 23]    

        ]);

        // 2. Lưu chi tiết đơn hàng [cite: 14]
        foreach ($cart as $id => $details) {
            DB::table('chi_tiet_don_hang')->insert([
                'ma_don_hang' => $donHangId,
                'laptop_id' => $id,
                'so_luong' => $details['quantity'],
                'don_gia' => $details['price']
            ]);
        }

        // 3. Gửi mail thật sau khi đặt hàng thành công (Câu 4 bổ sung)
        if (auth()->check()) {
            $donHang = DB::table('don_hang')->where('id', $donHangId)->first();
            Mail::to(auth()->user()->email)->send(new OrderSuccess($donHang));
        }

        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Đặt hàng thành công!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }
}