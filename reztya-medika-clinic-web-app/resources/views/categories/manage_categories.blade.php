@extends('layout/main')

@section('title', 'Daftar Kategori')

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
            <p class="h5 fw-bold unselectable font-alander-reztya">Daftar Kategori</p>
        </div>
    </div>
    <a href="/add-category" class="btn button-outline-reztya my-3"><i class="fa-solid fa-plus"></i> Tambah Kategori</a>
    <table class="table table-striped">
        <thead>
            <tr class="text-center table-head-reztya">
                <th>No.</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($categories->isEmpty())
            <tr>
                <td colspan="3" class="text-center">Kategori tidak tersedia</td>
            </tr>
            @else
            @php
            $i = 1
            @endphp
            @foreach($categories as $category)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td>{{ $category->category_name }}</td>
                <td>
                    <a class="btn button-outline-reztya btn-sm" href="/edit-category/{{ $category->category_id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form method="post" action="/delete-category/{{ $category->category_id }}" class="d-inline">
                        @method('post') @csrf
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin mengapus kategori ini?')">
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