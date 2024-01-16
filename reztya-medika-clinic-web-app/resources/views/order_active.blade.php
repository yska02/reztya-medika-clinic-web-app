@extends('layout/main')

@section('title', 'Active Order')

@section('container')
@php
use Carbon\Carbon;
@endphp
<div class="d-flex justify-content-center">
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya" style="margin-bottom:100px; width: 85%;">
        <h5 class="my-3 text-center font-alander-reztya fw-bold unselectable pt-4">Pesanan Aktif</h5>
        <div class="dropdown">
            <button class="btn button-outline-reztya dropdown-toggle mt-4 mb-2" type="button" data-toggle="dropdown" aria-expanded="false">
                Status
            </button>
            <ul class="dropdown-menu">
                <li><a href="/order/{{'ongoing'}}" class="button-outline-reztya dropdown-item">Sedang Berjalan</a></li>
                <li><a href="/order/{{'waiting'}}" class="button-outline-reztya dropdown-item">Menunggu Konfirmasi Pembayaran</a></li>
            </ul>
        </div>
        @if(!$orders->isEmpty())
            @foreach($orders as $key=> $order)
                @php
                    $totalPrice = 0;
                    foreach($order->orderDetail as $order_detail)
                    {
                        if($order_detail->service_id)
                            $totalPrice += $order_detail->service->price;
                        else
                            $totalPrice += $order_detail->product->price * $order_detail->quantity;
                    }
                    if($order->delivery_fee)
                        $totalPrice += $order->delivery_fee;
                @endphp
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 align-items-center">{{ Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</h5>
                        @if($order->status == "ongoing")
                        <p class="rounded-2 mb-0 ms-4" style="background-color: orange; cursor: default;">
                            <span class="badge">SEDANG BERJALAN</span>
                        </p>
                        @elseif($order->status == "waiting")
                        <p class="rounded-2 mb-0 ms-4" style="background-color: #7DC241; cursor: default;">
                            <span class="badge">MENUNGGU KONFIRMASI PEMBAYARAN</span>
                        </p>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="d-flex flex-column">
                            <p class="mb-0 text-end">Total Harga</p>
                            <p class="fw-bold mb-0">Rp{{ number_format($totalPrice, 2)}}</p>
                        </div>
                        <a href="/order-detail/{{$order->order_id}}" class="btn button-outline-reztya ms-3" type="button">Detail Pesanan</a>
                    </div>
                </div>
                @if(Auth::user()->user_role_id == 1)
                <div class="d-flex flex-column mb-3" style="margin-left: -1%;">
                    <div class="container">
                        <div class="row">
                            <div class="col-2">
                                Pemesan
                            </div>
                            <div class="col-1 text-end">
                                :
                            </div>
                            <div class="col-7 fw-bold">
                                {{ $order->user->name }}
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                No. HP
                            </div>
                            <div class="col-1 text-end">
                                :
                            </div>
                            <div class="col-7 fw-bold">
                                {{ $order->user->phone }}
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                Alamat
                            </div>
                            <div class="col-1 text-end">
                                :
                            </div>
                            <div class="col-7 fw-bold">
                                {{ $order->user->address }}
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="d-flex flex-column">
                    <div class="container">
                        @if($order->orderDetail[0]->service_id)
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <h5 class="mb-0">Perawatan</h5>
                            </div>
                            <div class="col-7">
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/' . $order->orderDetail[0]->service->image_path) }}" alt="" width="100px" height="100px">
                            </div>
                            <div class="col-7">
                                <p class="fw-bold m-0">{{ $order->orderDetail[0]->service->name }}</p>
                                Rp{{ number_format($order->orderDetail[0]->service->price, 2) }}
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        @elseif($order->orderDetail[0]->product_id != null)
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <h5 class="mb-0" style="padding-right:25%;">Produk</h5>
                            </div>
                            <div class="col-7">
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/' . $order->orderDetail[0]->product->image_path) }}" alt="" width="100px" height="100px">
                            </div>
                            <div class="col-7">
                                <p class="fw-bold m-0">{{ $order->orderDetail[0]->product->name }}</p>
                                <div>
                                    {{ $order->orderDetail[0]->quantity }} buah x Rp{{ number_format($order->orderDetail[0]->product->price, 2) }}
                                </div>
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        @endif
                        @php
                            $totalItem = count($order->orderDetail);
                        @endphp
                        @if ($totalItem > 1)
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <p class="mb-4">+{{$totalItem - 1}} pesanan lainnya</p>
                            </div>
                            <div class="col-7">
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        @endif
                    </div>
                    @if($key != count($orders) - 1)
                        <hr/>
                    @endif
                </div>
            @endforeach
        @else
        <p class="my-3">Tidak ada pesanan yang sedang aktif.</p>
        @endif
    </div>
</div>
@endsection
