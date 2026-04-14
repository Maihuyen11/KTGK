<x-laptop-layout :title="$title" :categories="$categories">

    <div class="py-4">
        <h3>Kết quả tìm kiếm: "{{ $keyword }}"</h3>

        <div class="list-laptop">
            @forelse($laptops as $item)
                <div class="laptop">
                    <a href="{{ url('laptop/'.$item->id) }}">
                        <img src="{{ asset('storage/image/'.($item->hinh_anh ?? '')) }}" width="100%">
                        <p>{{ $item->tieu_de ?? ($item->ten_san_pham ?? 'San pham') }}</p>
                        <p>{{ number_format($item->gia ?? ($item->price ?? 0)) }}đ</p>
                    </a>
                </div>
            @empty
                <p>Không tìm thấy sản phẩm</p>
            @endforelse
        </div>

        {{ $laptops->links() }}
    </div>
</x-laptop-layout>