<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaptopController1 extends Controller
{
    // Câu 2: Hiển thị danh sách laptop
    public function index(Request $request)
    {
        $query = DB::table('san_pham'); // Không dùng where status vì bảng bạn không có cột này

        // Lọc theo Danh mục (Thương hiệu)
        if ($request->has('id_danh_muc')) {
            $query->where('id_danh_muc', $request->id_danh_muc);
        }

        // Sắp xếp giá
        if ($request->has('sort_price')) {
            $direction = $request->sort_price == 'asc' ? 'asc' : 'desc';
            $query->orderBy('gia', $direction);
        }

        $laptops = $query->paginate(20); 

        $thuongHieu = DB::table('danh_muc_laptop')->get();

        return view('laptop.index', compact('laptops', 'thuongHieu'));
    }

    

    // Câu 3: Trang chi tiết sản phẩm
    public function show($id)
    {
        // Lấy trực tiếp thông tin sản phẩm theo ID
        $laptop = DB::table('san_pham')->where('id', $id)->first();

        if (!$laptop) {
            abort(404);
        }

        return view('laptop.detail', compact('laptop'));
    }
    public function addToCart(Request $request) 
{
    $id = $request->id;
    // Lấy chính xác số lượng từ ô input, nếu ô trống thì mới lấy 1
    $quantity = (int)$request->input('quantity', 1); 
    
    $product = DB::table('san_pham')->where('id', $id)->first();

    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        // Nếu đã có trong giỏ, cộng thêm số lượng mới chọn vào số lượng cũ
        $cart[$id]['quantity'] += $quantity; 
    } else {
        // Nếu chưa có (đang là 0), thì gán bằng đúng số lượng vừa chọn
        $cart[$id] = [
            "name" => $product->tieu_de,
            "quantity" => $quantity, 
            "price" => $product->gia,
            "image" => $product->hinh_anh
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
}
}