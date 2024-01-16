@extends('layout/main')
@section('title', 'Akun-akun Pengguna')

@section('container')
@php
    use Carbon\Carbon;
@endphp
<div class="unselectable container bg-white ban-unban-box mb-5">
    @if(session()->has('successUpdate'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('successUpdate')}}
        <button type="button" class="btn btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="pt-4">
        <div class="py-3 d-flex justify-content-center">
            <p class="h5 fw-bold unselectable font-alander-reztya">Ban / Unban Member</p>
        </div>
    </div>
    @foreach($members as $member)
    <div class="mt-2">
        <div class="card outline-reztya">
            <div class="col-auto mt-2 ms-3">
                <div class="row d-flex justify-content-center">
                    <div class="row text-center">
                        <h5 class="fw-bold text-color-reztya">{{$member->name}}</h5>
                    </div>
                    <div class="row text-center mb-2">
                        <p class="fw-bold text-color-reztya">{{$member->username}}</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <h6 class="text-wrap fw-bold">Tanggal Lahir:</h6>
                                <h6 class="text-wrap">{{ Carbon::parse($member->birthdate)->translatedFormat('l, d F Y') }}</h6>
                            </div>
                            <div>
                                <h6 class="text-wrap fw-bold">Alamat:</h6>
                                <h6 class="text-wrap">{{$member->address}}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <h6 class="text-wrap fw-bold">No. HP:</h6>
                                <h6 class="text-wrap">{{$member->phone}}</h6>
                            </div>
                            <div>
                                <h6 class="text-wrap fw-bold">Email:</h6>
                                <h6 class="text-wrap">{{$member->email}}</h6>
                            </div>
                        </div>
                    </div>
                    @if($member->is_banned == false)
                        <form class="d-grid me-3 mb-1 mt-2" action="/ban-user/{{$member->username}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button class="btn btn-outline-danger mb-1 mt-1" onclick="return confirm('Apakah anda yakin ingin melakukan ban terhadap {{$member->username}}?')">
                                Ban
                            </button>
                        </form>
                    @else
                        <form class="d-grid me-3 mb-1 mt-2" action="/unban-user/{{$member->username}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button class="btn button-outline-reztya mb-1 mt-1" onclick="return confirm('Apakah anda yakin ingin melakukan unban terhadap {{$member->username}}?')">
                                Unban
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
