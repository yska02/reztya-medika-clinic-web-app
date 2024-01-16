@extends('layout/main')
@section('title', 'Produk')

@section('container')
    <div class="container mb-5">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$errors}}
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="pt-4">
            <div class="py-3 d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Produk</p>
            </div>
        </div>
        <div class="mt-5 d-flex justify-content-center">
            <div class="w-50">
                <form action="/view-products/search-product" method="GET" enctype="multipart/form-data">
                    <div class="input-group">
                    <span class="input-group-text bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#00A54F" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                        </svg>
                    </span>
                        <input type="search" class="form-control shadow-none w-75 font-futura-reztya" placeholder="Search" aria-label="Search" name="keyword">
                    </div>
                </form>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn button-outline-reztya dropdown-toggle mt-4 mb-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu">
                <li><a href="/view-products/filter/name/a-to-z" class="button-outline-reztya dropdown-item">A ke Z</a></li>
                <li><a href="/view-products/filter/name/z-to-a" class="button-outline-reztya dropdown-item">Z ke A</a></li>
                <li><a href="/view-products/filter/price/high-to-low" class="button-outline-reztya dropdown-item">Harga: Tertinggi ke Terendah</a></li>
                <li><a href="/view-products/filter/price/low-to-high" class="button-outline-reztya dropdown-item">Harga: Terendah to Tertinggi</a></li>
                @foreach($categories as $category)
                    <form action="/view-products/filter/category/{{$category->category_name}}" method="GET" enctype="multipart/form-data">
                        <input hidden type="hidden" name="category_id" value="{{$category->category_id}}">
                        <li><button type="submit" class="button-outline-reztya dropdown-item">{{$category->category_name}}</button></li>
                    </form>
                @endforeach
            </ul>
        </div>
        <div class="unselectable mt-2">
            <div class="row">
                @foreach($products as $product)
                    @if($product->stock > 1)
                        <div class="col-3 mb-3 font-futura-reztya">
                            <a href="/product-detail/{{$product->product_id}}" class="text-decoration-none">
                                <div class="card bg-white outline-reztya h-100">
                                    <div class="card-header d-flex h-300">
                                        <img class="rounded img-fluid m-auto mh-100" src="{{ asset('storage/' . $product->image_path) }}">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="card-title text-reztya">
                                            <b>{{$product->name}}</b>
                                        </div>
                                        <div class="card-description text-black">
                                            Rp{{ number_format($product->price, 2) }}
                                        </div>
                                        <div class="mt-auto">
                                            <a href="/product-detail/{{$product->product_id}}" class="btn button-outline-reztya float-end">
                                                Lihat Produk
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-3 mb-3 font-futura-reztya">
                            <a href="/product-detail/{{$product->product_id}}" class="text-decoration-none">
                                <div class="card bg-white outline-reztya h-100">
                                    <div class="card-header d-flex h-300">
                                        <img class="rounded img-fluid m-auto mh-100" src="{{ asset('storage/' . $product->image_path) }}">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="card-title text-reztya">
                                            <b>{{$product->name}}</b>
                                        </div>
                                        <div class="card-description text-black">
                                            Rp{{ number_format($product->price, 2) }}
                                        </div>
                                        <div class="mt-auto">
                                            <a class="disabled btn btn-outline-dark float-end">
                                                Produk Habis
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
