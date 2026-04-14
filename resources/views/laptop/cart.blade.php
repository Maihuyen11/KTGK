<x-laptop-layout :title="$title" :categories="$categories">

<div class="py-4">
    <h4 class="text-center text-primary font-weight-bold">
        DANH SÁCH SẢN PHẨM TRONG GIỎ
    </h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered mt-3 text-center">
        <thead class="thead-light">
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Xóa</th>
            </tr>
        </thead>

        <tbody>
        @php $total = 0; @endphp

        @forelse($cart as $id => $item)
            @php $total += $item['price'] * $item['quantity'] @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-left">{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td class="text-danger font-weight-bold">
                    {{ number_format($item['price']) }}đ
                </td>
                <td>
                    <a href="{{ route('cart.remove', $id) }}" 
                       class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i> Xóa
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-muted">Giỏ hàng trống</td>
            </tr>
        @endforelse
        </tbody>

        <tr class="font-weight-bold bg-light">
            <td colspan="3" class="text-right">Tổng cộng:</td>
            <td colspan="2" class="text-danger">
                {{ number_format($total) }}đ
            </td>
        </tr>
    </table>

    {{-- FORM ĐẶT HÀNG --}}
    @if(count($cart) > 0)
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 border p-4 rounded shadow-sm bg-white">

            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="font-weight-bold">
                        Hình thức thanh toán
                    </label>

                    <select name="payment_method" class="form-control">
                        <option value="Tiền mặt">
                            Thanh toán khi nhận hàng (COD)
                        </option>
                        <option value="Chuyển khoản">
                            Chuyển khoản ngân hàng
                        </option>
                    </select>
                </div>

                <button type="submit" 
                        class="btn btn-primary btn-block font-weight-bold">
                    XÁC NHẬN ĐẶT HÀNG
                </button>
            </form>

        </div>
    </div>
    @endif

</div>

</x-laptop-layout>