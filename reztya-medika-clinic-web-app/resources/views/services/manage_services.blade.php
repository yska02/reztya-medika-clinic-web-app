@extends('layout/main')

@section('title', 'Daftar Perawatan')

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
            <p class="h5 fw-bold unselectable font-alander-reztya">Daftar Perawatan</p>
        </div>
    </div>
    <a href="/add-service" class="btn button-outline-reztya my-3"><i class="fa-solid fa-plus"></i> Tambah Perawatan</a>
    <table class="table table-striped">
        <thead>
            <tr class="text-center table-head-reztya">
                <th>No.</th>
                <th>Gambar Perawatan</th>
                <th>Nama Perawatan</th>
                <th>Durasi Perawatan</th>
                <th>Harga Perawatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($services->isEmpty())
            <tr>
                <td colspan="6" class="text-center">Perawatan tidak tersedia</td>
            </tr>
            @else
            @php
            $i = 1
            @endphp
            @foreach($services as $service)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td><img src="{{ asset('storage/' . $service->image_path) }}" width="150" height="150" class="img-preview img-fluid img-thumbnail"></td>
                <td class="td-name">{{ $service->name }}</td>
                <td>{{ $service->duration }} menit</td>
                <td>Rp{{ number_format($service->price, 2) }}</td>
                <td>
                    <a class="btn btn-outline-secondary btn-sm" href="/service-detail/{{ $service->service_id }}"><i class="fa-solid fa-circle-info"></i> Detail</a>
                    <a class="btn  button-outline-reztya btn-sm" href="/edit-service/{{ $service->service_id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form method="post" action="/delete-service/{{ $service->service_id }}" class="d-inline">
                        @method('post') @csrf
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus perawatan ini?')">
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