@extends('layout/main')
@section('title', 'Home')

@section('container')
    <div class="unselectable container bg-white">
        @if(session()->has('addSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('addSuccess')}}
                <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('signupError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('signupError')}}
                <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div id="carouselExampleIndicators" class="carousel carousel-reztya slide" style="height: 400px !important;" data-bs-ride="true">
                <div class="card border border-reztya border-4 h-100 overflow-hidden">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner d-flex align-items-center">
                        <div class="carousel-item active">
                            <div class="text-center">
                                <img src="{{url('storage/banner1.jpg')}}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <div class="carousel-item">
                            <a class="d-flex justify-content-center" href="#">
                                <img src="{{url('storage/banner2.jpg')}}" class="d-block w-100" alt="Klinik Reztya Medika">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a class="d-flex justify-content-center" href="#">
                                <img src="{{url('storage/banner3.jpg')}}" class="d-block w-100" alt="Klinik Reztya Medika">
                            </a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Best Sellers</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-4">
            <div class="col-4 mb--1">
                <div class="card border-reztya border border-4 h-75">
                    <a href="/product-detail/{{$product1->product_id}}" class="overflow-hidden">
                        <img src="{{url('storage/lemon.jpg')}}" class="d-block w-100" alt="...">
                    </a>
                </div>
            </div>
            <div class="col-4 mb--1">
                <div class="card border-reztya border border-4 h-75">
                    <a href="/product-detail/{{$product2->product_id}}" class="overflow-hidden">
                        <img src="{{url('storage/madu.jpg')}}" class="d-block w-100" alt="...">
                    </a>
                </div>
            </div>
            <div class="col-4 mb--1">
                <div class="card border-reztya border border-4 h-75">
                    <a href="/product-detail/{{$product3->product_id}}" class="overflow-hidden">
                        <img src="{{url('storage/granola.jpg')}}" class="d-block w-100" alt="...">
                    </a>
                </div>
            </div>
        </div>
        <hr class="mt-5">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-6">
                <p class="d-flex justify-content-center h5 fw-bold unselectable font-alander-reztya mb-3">Perawatan</p>
                <div class="card border-reztya border border-4 h-75 justify-content-center bg-reztya" width="526" height="439">
                    <a href="/service-detail/{{$service->service_id}}" class="overflow-hidden">
                        <img src="{{url('storage/service-images/pl.jpg')}}" class="d-block w-100" >
                    </a>
                </div>
            </div>
            <div class="col-6">
                <p class="d-flex justify-content-center h5 fw-bold unselectable font-alander-reztya mb-3">Produk</p>
                <div class="card border-reztya border border-4 h-75 justify-content-center bg-reztya">
                    <a href="/product-detail/{{$product->product_id}}" class="overflow-hidden">
                        <img src="{{url('storage/product.png')}}" class="d-block w-100" alt="Product Image">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
