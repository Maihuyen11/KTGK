@php use Illuminate\Support\Str; @endphp

<x-laptop-layout>
    <x-slot name="title">Quản lý sản phẩm</x-slot>

    <div class="container mt-4">
        <h2 class="text-center mb-4 text-uppercase font-weight-bold">Quản lý sản phẩm</h2>

        {{-- Thông báo --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <table id="id-table" class="table table-bordered table-striped bg-white">
            <thead>
                <tr class="text-center">
                    <th>Tiêu đề</th>
                    <th>CPU</th>
                    <th>RAM</th>
                    <th>Ổ cứng</th>
                    <th>Khối lượng</th>
                    <th>Giá</th>
                    <th>Ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
                <tbody>
@foreach($laptops as $laptop)
<tr>

    {{-- Tiêu đề --}}
    <td class="font-weight-bold">
        {{ $laptop->tieu_de }}
    </td>

    {{-- CPU --}}
    <td>{{ $laptop->cpu }}</td>

    {{-- RAM --}}
    <td>{{ $laptop->ram }}</td>

    {{-- Ổ cứng --}}
    <td>{{ $laptop->luu_tru }}</td>

    {{-- Khối lượng --}}
    <td>{{ $laptop->khoi_luong }}</td>

    {{-- Giá --}}
    <td>{{ number_format($laptop->gia) }}</td>

    {{-- Ảnh --}}
    <td class="text-center">
        <img src="{{ asset('storage/image/' . $laptop->hinh_anh) }}"
             width="80"
             class="img-thumbnail">
    </td>

    {{-- Thao tác --}}
    <td class="text-center">
        <div class="d-flex justify-content-center gap-1">

            {{-- Xem --}}
            <a href="{{ route('laptop.detail', $laptop->id) }}"
               class="btn btn-primary btn-sm">
                Xem
            </a>

            {{-- Xóa --}}
            <form action="{{ route('laptops.destroy', $laptop->id) }}"
                  method="POST"
                  onsubmit="return confirm('Bạn có chắc muốn xóa laptop này?')"
                  style="display:inline;">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">
                    Xóa
                </button>
            </form>

        </div>
    </td>

</tr>
@endforeach
</tbody>
            
        </table>
    </div>

    {{-- DataTable --}}
    <script>
        $(document).ready(function() {
            $('#id-table').DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    bStateSave:true,
                });


        });
    </script>
</x-laptop-layout>