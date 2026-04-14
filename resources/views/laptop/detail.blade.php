<x-laptop-layout>
    <x-slot name="title">Chi tiết: {{ $laptop->tieu_de }}</x-slot>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-5">
            <div class="border p-2">
                <img src="{{ asset('storage/image/' . $laptop->hinh_anh) }}" class="img-fluid" alt="{{ $laptop->tieu_de }}">
            </div>
        </div>

        <div class="col-md-7">
            <h3 class="fw-bold">{{ $laptop->tieu_de }}</h3>
            <ul class="list-unstyled mt-3" style="line-height: 2;">
                <li><strong>CPU:</strong> {{ $laptop->cpu }}</li>
                <li><strong>RAM:</strong> {{ $laptop->ram }}</li>
                <li><strong>Ổ cứng:</strong> {{ $laptop->luu_tru }}</li>
                <li><strong>Đồ họa:</strong> {{ $laptop->chip_do_hoa }}</li>
                <li><strong>Màn hình:</strong> {{ $laptop->man_hinh }}</li>
                <li><strong>Hệ điều hành:</strong> {{ $laptop->he_dieu_hanh }}</li>
            </ul>
            
            <h4 class="text-danger fw-bold mt-3">Giá: {{ number_format($laptop->gia, 0, ',', '.') }} VNĐ</h4>

            <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="id" value="{{ $laptop->id }}">
                <div class="d-flex align-items-center">
                    <span class="me-2 fw-bold">Số lượng mua:</span>
                    <input type="number" name="quantity" value="1" min="1" class="form-control text-center" style="width: 80px;">
                    <button type="submit" class="btn btn-primary ms-3 px-4">Thêm vào giỏ hàng</button>
                </div>
            </form>

            <div class="mt-5">
                <h5 class="fw-bold border-bottom pb-2">Thông tin khác</h5>
                <ul class="list-unstyled mt-2" style="line-height: 1.8;">
                    <li><strong>Khối lượng:</strong> {{ $laptop->khoi_luong }}</li>
                    <li><strong>Webcam:</strong> {{ $laptop->webcam }}</li>
                    <li><strong>Pin:</strong> {{ $laptop->pin }}</li>
                    <li><strong>Bàn phím:</strong> {{ $laptop->ban_phim }}</li>
                    <li><strong>Cổng kết nối:</strong> {{ $laptop->cong_ket_noi }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
</x-laptop-layout>