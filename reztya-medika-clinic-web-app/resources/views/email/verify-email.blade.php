@extends('layout.main')
@section('title', 'Verifikasi Email')

@section('container')
    <div class="container sign-box mb-5">
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show font-futura-reztya" role="alert">
                {{session('message')}}
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="box-up pt-4">
            <div class="d-flex justify-content-center">
                <p class="h5 fw-bold unselectable font-alander-reztya">Verifikasi Email</p>
            </div>
        </div>
        <div class="unselectable d-flex justify-content-center mt-3">
            <div class="card card-sign bg-white outline-reztya">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <h5 class="text-color-reztya font-futura-reztya text-center">Tolong verfikasi email anda sebelum mengakses halaman lain</h5>
                        <a href="/home" class="btn button-outline-reztya font-futura-reztya mt-3">Balik ke Halaman Utama</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="unselectable d-flex justify-content-center mt-3">
            <div class="card card-sign bg-white outline-reztya">
                <div class="card-body">
                    <form action="/email/verification-notification" method="POST">
                        <div class="d-grid gap-2">
                            @csrf
                            <button class="btn button-outline-reztya font-futura-reztya" type="submit">Kirim Ulang Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
