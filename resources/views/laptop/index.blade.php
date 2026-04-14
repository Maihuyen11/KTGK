<x-laptop-layout>
    <x-slot name="title">Trang chủ - Danh sách Laptop</x-slot>

    <div class="container mt-4">
        {{-- XÓA ĐOẠN <nav> THƯƠNG HIỆU Ở ĐÂY VÌ TRONG LAYOUT ĐÃ CÓ RỒI --}}

        <div class="text-center mb-4">
            <span>Tìm kiếm theo </span>
            <a href="{{ route('home', array_merge(request()->query(), ['sort_price' => 'asc'])) }}" class="btn btn-outline-dark mx-1">Giá tăng dần</a>
            <a href="{{ route('home', array_merge(request()->query(), ['sort_price' => 'desc'])) }}" class="btn btn-outline-dark mx-1">Giá giảm dần</a>
        </div>

        <div class="list-laptop">
            @foreach($laptops as $item)
            <div class="laptop">
               
                    <a href="{{ route('laptop.detail', $item->id) }}">
                        {{-- Hiển thị ảnh từ storage theo yêu cầu đề bài [cite: 3, 18] --}}
                        <img src="{{ asset('storage/image/' . $item->hinh_anh) }}" class="card-img-top p-3" alt="{{ $item->tieu_de }}">
                    </a>
                   
                        <h6 class="card-title">
                            <a href="{{ route('laptop.detail', $item->id) }}" class="text-dark text-decoration-none fw-bold">
                                {{ $item->tieu_de }}
                            </a>
                        </h6>
                        <p class="text-danger fw-bold fs-5">
                            {{ number_format($item->gia, 0, ',', '.') }} VNĐ
                        </p>
                    
            </div>
            @endforeach
        </div>
    </div>
</x-laptop-layout>