@extends('layout/main')
@section('title', 'Profil')

@section('container')
@php
use Carbon\Carbon;
@endphp
<div class="unselectable container bg-white">
    @if(session()->has('updateError'))
    <div class="alert alert-danger alert-dismissible fade show font-futura-reztya" role="alert">
        {{session('updateError')}}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="pt-4">
        <div class="py-3 d-flex justify-content-center">
            <p class="h5 fw-bold unselectable font-alander-reztya">Profil</p>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-2 bg-white font-futura-reztya mb-4">
        <div class="profile-box">
            <div class="card outline-reztya">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-view">
                        <div class="row row-profile">
                            <div class="d-flex align-self-center ms-4 col-3 view-profile-img">
                                <img width="120px" src="{{asset('storage/' . auth()->user()->profile_picture)}}" class="bg-secondary img-thumbnail rounded-circle" id="preview" aria-expanded="false" alt="Profile Picture">
                            </div>
                            <div class="col-9 mt-4 ms-3">
                                <div class="row">
                                    <div class="col-9 mb-1">
                                        <a class="row text-reztya text-decoration-none edit-icon" href="/edit-profile/{{auth()->user()->username}}">
                                            <h5 class="col-10 fw-bold">{{auth()->user()->name}}</h5>
                                            <i class="col-1 fa-regular fa-pen-to-square mt-1"></i>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div>
                                                <h6>{{auth()->user()->birthdate}}</h6>
                                            </div>
                                            <div>
                                                <h6 class="text-wrap">{{auth()->user()->address}}</h6>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div>
                                                <h6>{{auth()->user()->phone}}</h6>
                                            </div>
                                            <div>
                                                <h6>{{auth()->user()->email}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row mt-5 ms-1-5 mb-4">
                <div class="col-6 active-order-box">
                    <div class="card outline-reztya">
                        <a href="/active-order" class="card-header btn button-outline-reztya">
                            <h5 class="mt-1 d-flex justify-content-start">Pemesanan Aktif</h5>
                        </a>
                        @if(!$orders->isEmpty())
                            @foreach($orders as $index => $order)
                                @if($index == 0)
                                    <ul class="list-group mt-1">
                                        <li class="list-group-item">
                                            <h6 class="fw-bold">Tanggal Pemesanan:</h6>
                                            <h6 class="fw-bold">{{Carbon::parse($order->order_date)->translatedFormat('d F Y')}}</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <ul class="row list-unstyled">
                                                <li class="h6 col-6 fw-bold list-unstyled">Perawatan</li>
                                                <li class="col-6 fw-bold list-unstyled">Rp{{ number_format($servicePrice, 2) }}</li>
                                            </ul>
                                            @foreach($order->orderDetail as $order_detail)
                                                @if($order_detail->service_id)
                                                    @if($printOnce == false)
                                                        <ul class="list-group mb-2">
                                                            <li class="list-group-item list-group-flush">
                                                                {{$order_detail->service->name}}
                                                            </li>
                                                            <li class="list-group-item">
                                                                @php
                                                                    $printOnce = true;
                                                                @endphp
                                                                @if($totalItemService > 1)
                                                                    <p>+{{$totalItemService - 1}} pesanan lainnya</p>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <ul class="list-group">
                                                <ul class="row list-unstyled">
                                                    <li class="h6 col-6 fw-bold list-unstyled">Produk</li>
                                                    <li class="col-6 fw-bold list-unstyled">Rp{{ number_format($productPrice, 2) }}</li>
                                                </ul>
                                                @php
                                                    $printOnce = false;
                                                @endphp
                                                @foreach($order->orderDetail as $order_detail)
                                                    @if($order_detail->product_id)
                                                        @if($printOnce == false)
                                                            <ul class="list-group">
                                                                <li class="list-group-item list-group-flush">
                                                                    {{$order_detail->product->name}}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    @php
                                                                        $printOnce = true;
                                                                    @endphp
                                                                    @if($totalItemProduct > 1)
                                                                        <p>+{{$totalItemProduct - 1}} pesanan lainnya</p>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <ul class="list-group">
                                                <ul class="row list-unstyled">
                                                    <li class="h6 col-6 fw-bold list-unstyled">Total Biaya</li>
                                                    <li class="col-6 fw-bold list-unstyled">Rp{{ number_format($totalPrice, 2) }}</li>
                                                    <li class="list-unstyled small">Belum termasuk biaya pengiriman</li>
                                                </ul>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                            @endforeach
                        @else
                        <ul class="list-group mt-1">
                            <li class="list-group-item">
                                <h6 class="fw-bold">Tidak ada pesanan yang sedang aktif</h6>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-6 me-2-5">
                    <div class="card outline-reztya">
                        <a href="/history-order" class="card-header text-white btn button-outline-reztya">
                            <h5 class="mt-1 d-flex justify-content-start">Riwayat Pemesanan</h5>
                        </a>
                        @if(!$order_history->isEmpty())
                            @foreach($order_history as $index => $order)
                                @if($index == 0)
                                    <ul class="list-group mt-1">
                                        <li class="list-group-item">
                                            <h6 class="fw-bold">Tanggal Pemesanan:</h6>
                                            <h6 class="fw-bold">{{Carbon::parse($order->order_date)->translatedFormat('d F Y')}}</h6>
                                        </li>
                                        <li class="list-group-item">
                                            <ul class="row list-unstyled">
                                                <li class="h6 col-6 fw-bold list-unstyled">Perawatan</li>
                                                <li class="col-6 fw-bold list-unstyled">Rp{{ number_format($servicePriceHistory, 2) }}</li>
                                            </ul>
                                            @foreach($order->orderDetail as $order_detail)
                                            @if($order_detail->service_id)
                                            @if($printServiceOnce == false)
                                            <ul class="list-group mb-2">
                                                <li class="list-group-item list-group-flush">
                                                    {{$order_detail->service->name}}
                                                </li>
                                                <li class="list-group-item">
                                                    @php
                                                    $printServiceOnce = true;
                                                    @endphp
                                                    @if($serviceItemHistory > 1)
                                                    <p>+{{$serviceItemHistory - 1}} pesanan lainnya</p>
                                                    @endif
                                                </li>
                                            </ul>
                                            @endif
                                            @endif
                                            @endforeach
                                            <ul class="list-group">
                                                <ul class="row list-unstyled">
                                                    <li class="h6 col-6 fw-bold list-unstyled">Produk</li>
                                                    <li class="col-6 fw-bold list-unstyled">Rp{{ number_format($productPriceHistory, 2) }}</li>
                                                </ul>
                                                @foreach($order->orderDetail as $order_detail)
                                                @if($order_detail->product_id)
                                                @if($printProductOnce == false)
                                                <ul class="list-group">
                                                    <li class="list-group-item list-group-flush">
                                                        {{$order_detail->product->name}}
                                                    </li>
                                                    <li class="list-group-item">
                                                        @php
                                                        $printProductOnce = true;
                                                        @endphp
                                                        @if($productItemHistory > 1)
                                                        <p>+{{$productItemHistory - 1}} pesanan lainnya</p>
                                                        @endif
                                                    </li>
                                                </ul>
                                                @endif
                                                @endif
                                                @endforeach
                                            </ul>
                                            <ul class="list-group">
                                                <ul class="row list-unstyled">
                                                    <li class="h6 col-6 fw-bold list-unstyled">Total Biaya</li>
                                                    <li class="col-6 fw-bold list-unstyled">Rp{{ number_format($totalPriceHistory, 2) }}</li>
                                                    <li class="list-unstyled small">Belum termasuk biaya pengiriman</li>
                                                </ul>
                                            </ul>
                                        </li>
                                    </ul>
                                @endif
                            @endforeach
                        @else
                        <ul class="list-group mt-1">
                            <li class="list-group-item">
                                <h6 class="fw-bold">Tidak ada riwayat pemesanan</h6>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
    };
</script>
@endsection
