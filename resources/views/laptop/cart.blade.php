<x-laptop-layout>
    <x-slot name="title">Giỏ hàng của bạn</x-slot>

    <div class="container mt-4 mb-5">
        <h4 class="text-center text-primary fw-bold mb-4">DANH SÁCH SẢN PHẨM</h4>
        
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="text-center">
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $details['name'] }}</td>
                            <td class="text-center">{{ $details['quantity'] }}</td>
                            <td class="text-center">{{ number_format($details['price'], 0, ',', '.') }}đ</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">Giỏ hàng trống!</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right fw-bold">Tổng cộng</td>
                    <td class="text-center fw-bold text-dark">{{ number_format($total, 0, ',', '.') }}đ</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="text-center mt-4">
            <label class="fw-bold d-block mb-2">Hình thức thanh toán</label>
            <select class="form-control d-inline-block shadow-sm" style="width: 200px;">
                <option>Tiền mặt</option>
                <option>Chuyển khoản</option>
            </select>
            <div class="mt-4">
                <button class="btn btn-primary px-5 fw-bold shadow">ĐẶT HÀNG</button>
            </div>
        </div>
    </div>
</x-laptop-layout>