@extends('layout/main')

@section('title', 'Daftar Produk')

@section('container')
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show font-futura-reztya" role="alert">
    {{session('success')}}
    <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show font-futura-reztya" role="alert">
    {{session('error')}}
    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="border outline-reztya rounded-4 p-5 font-futura-reztya">
    <div class="pt-4">
        <div class="py-3 d-flex justify-content-center">
            <p class="h5 fw-bold unselectable font-alander-reztya">Daftar Produk</p>
        </div>
    </div>
    <a href="/add-product" class="btn button-outline-reztya my-3"><i class="fa-solid fa-plus"></i> Tambah Produk</a>
    <table class="table table-striped">
        <thead>
            <tr class="text-center table-head-reztya">
                <th>No.</th>
                <th>Gambar Produk</th>
                <th>Nama Produk</th>
                <th>Stok Produk</th>
                <th>Harga Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($products->isEmpty())
            <tr>
                <td colspan="6" class="text-center">Produk tidak tersedia</td>
            </tr>
            @else
            @php
            $i = 1
            @endphp
            @foreach($products as $product)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td><img src="{{ asset('storage/' . $product->image_path) }}" width="150" height="150" class="img-preview img-fluid img-thumbnail"></td>
                <td class="td-name">{{ $product->name }}</td>
                <td>{{ $product->stock }} buah</td>
                <td>Rp{{ number_format($product->price, 2) }}</td>
                <td>
                    <a class="btn btn-outline-secondary btn-sm" href="/product-detail/{{ $product->product_id }}"><i class="fa-solid fa-circle-info"></i> Detail</a>
                    <a class="btn button-outline-reztya btn-sm" href="/edit-product/{{ $product->product_id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form method="post" action="/delete-product/{{ $product->product_id }}" class="d-inline">
                        @method('post') @csrf
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin mengapus produk ini?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>

            @php
            $i++
            @endphp
            @endforeach
            @endif
        </tbody>
    </table>
</div>

@endsection