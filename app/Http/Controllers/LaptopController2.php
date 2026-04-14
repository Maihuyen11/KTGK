<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderSuccess;

class LaptopController2 extends Controller
{
    private function getItemName(array $item): string
    {
        return $item['name'] ?? $item['tieu_de'] ?? 'San pham';
    }

    private function getItemQuantity(array $item): int
    {
        return (int) ($item['quantity'] ?? $item['so_luong'] ?? 1);
    }

    private function getItemPrice(array $item): float
    {
        return (float) ($item['price'] ?? $item['gia'] ?? $item['don_gia'] ?? 0);
    }

    private function normalizeCart(array $cart): array
    {
        $normalized = [];

        foreach ($cart as $id => $item) {
            if (!is_array($item)) {
                continue;
            }

            $normalized[$id] = [
                'name' => $this->getItemName($item),
                'quantity' => $this->getItemQuantity($item),
                'price' => $this->getItemPrice($item),
            ];
        }

        return $normalized;
    }

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
        $keyword = trim((string) $request->input('keyword', ''));

        $query = DB::table('san_pham');

        if (Schema::hasColumn('san_pham', 'status')) {
            $query->where('status', 1);
        }

        if ($keyword !== '') {
            $query->where(function ($subQuery) use ($keyword) {
                if (Schema::hasColumn('san_pham', 'tieu_de')) {
                    $subQuery->orWhere('tieu_de', 'LIKE', "%{$keyword}%");
                }

                if (Schema::hasColumn('san_pham', 'ten_san_pham')) {
                    $subQuery->orWhere('ten_san_pham', 'LIKE', "%{$keyword}%");
                }

                if (Schema::hasColumn('san_pham', 'mo_ta')) {
                    $subQuery->orWhere('mo_ta', 'LIKE', "%{$keyword}%");
                }
            });
        }

        $laptops = $query->paginate(20);

        // Gộp dữ liệu sản phẩm với dữ liệu layout
        $data = array_merge($layoutData, [
            'laptops' => $laptops,
            'keyword' => $keyword
        ]);

        return view('laptop.search_results', $data);
    }

    // CÂU 4: Hiển thị giỏ hàng 
    public function viewCart()
    {
        $layoutData = $this->getLayoutData('Giỏ hàng của bạn');
        $cart = session()->get('cart', []);
        $normalizedCart = $this->normalizeCart($cart);

        $data = array_merge($layoutData, [
            'cart' => $normalizedCart
        ]);

        return view('laptop.cart', $data);
    }

    // CÂU 4: Xử lý đặt hàng & Gửi mail [cite: 14]
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $normalizedCart = $this->normalizeCart($cart);
        
        if (empty($normalizedCart)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        $tongTien = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $normalizedCart));

        if (Schema::hasTable('don_hang') && Schema::hasTable('chi_tiet_don_hang')) {
            $donHangId = DB::table('don_hang')->insertGetId([
                'user_id' => auth()->id() ?? 0,
                'ngay_dat' => now(),
                'tong_tien' => $tongTien,
                'hinh_thuc_thanh_toan' => $request->payment_method ?? 'Tien mat',
                'status' => 0,
            ]);

            foreach ($normalizedCart as $id => $details) {
                DB::table('chi_tiet_don_hang')->insert([
                    'ma_don_hang' => $donHangId,
                    'laptop_id' => $id,
                    'so_luong' => $details['quantity'],
                    'don_gia' => $details['price']
                ]);
            }

            if (auth()->check()) {
                try {
                    $donHang = DB::table('don_hang')->where('id', $donHangId)->first();

                    if ($donHang) {
                        Mail::to(auth()->user()->email)->send(new OrderSuccess($donHang));
                    }
                } catch (\Throwable $e) {
                    Log::warning('Khong gui duoc mail xac nhan don hang', ['message' => $e->getMessage()]);
                }
            }
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