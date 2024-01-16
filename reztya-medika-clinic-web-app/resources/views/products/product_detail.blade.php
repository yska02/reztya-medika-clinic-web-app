@extends('layout/main')

@section('title', 'Detail Produk')

@section('container')
<div class="d_flex justify-content-center">
    <div class="container-product border outline-reztya rounded-4 font-futura-reztya py-5" style="margin-bottom:100px;">
        <div class="pt-4">
            <div class="py-3 d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Detail Produk</p>
            </div>
        </div>
        <form method="post" action="/buy-product" enctype="multipart/form-data" novalidate>
            @method('post') @csrf
            <input type="hidden" value="{{ $product->product_id }}" name="product_id" id="product_id">
            <div class="row py-3">
                <div class="col-sm-6 pe-5">
                    <img src="{{ asset('storage/' . $product->image_path) }}" class="img-fluid img-thumbnail">
                </div>
    
                <div class="col-sm-6 pb-3">
                    <div class="btn btn-outline-secondary rounded-pill">{{$product->category->category_name}}</div>
                    <h3 class="text-reztya my-3">{{ $product->name }}</h3>
                    @if(!is_null($product->size))
                    <p>Ukuran: {{ $product->size }}</p>
                    @endif
                    <h5>Rp{{ number_format($product->price, 2) }}</h5>
                    <div class="my-3">
                        @foreach($description as $desc)
                            @if(str_starts_with($desc, 'Manfaat'))
                                <p class="font-futura-reztya fs-6 text-wrap fw-bold">{{ $desc }}</p>
                            @else
                                <p class="font-futura-reztya fs-6 lh-sm text-wrap">{{ $desc }}</p>
                            @endif
                        @endforeach
                    </div>
                    @if($product->stock > 1)
                        <p>Expired Date: {{ date('d F Y', strtotime($product->expired_date)) }}</p>
                        <p class="my-2">Stok tersedia: {{$product->stock}} pcs</p>
                        <label for="quantity" class="my-2">Jumlah:</label>
                        <input type="number" class="form-control form-quantity shadow-none @error('quantity') is-invalid  @enderror" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="{{ old('quantity', 1) }}">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
            </div>
            @if($product->stock > 1)
                <div class="d-flex justify-content-center mt-3 pb-4">
                    <button class="btn button-outline-reztya" type="submit"><i class="fa-solid fa-cart-shopping"></i> Tambahkan ke keranjang</button>
                </div>
            @else
                <div class="d-flex justify-content-center pb-5">
                    <button class="btn btn-dark disabled"><i class="fa-solid fa-cart-shopping"></i> Stok Habis</button>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
