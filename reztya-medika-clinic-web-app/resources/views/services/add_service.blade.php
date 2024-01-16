@extends('layout/main')

@section('title', 'Tambah Perawatan')

@section('container')

<div class="container-product border outline-reztya rounded-4 font-futura-reztya py-5">
    <div class="pt-4">
        <div class="py-3 d-flex justify-content-center">
            <p class="h5 fw-bold unselectable font-alander-reztya">Tambah Perawatan</p>
        </div>
    </div>
    <div class="d-flex justify-content-center my-4">
        <img class="img-preview img-fluid img-responsive img-thumbnail" width="300" height="300">
    </div>

    <form method="post" action="/store-service" enctype="multipart/form-data" class="row g-4 needs-validation" novalidate>
        @method('post') @csrf
        <div class="col-md-4">
            <label class="form-label" for="image">Foto Perawatan</label>
        </div>
        <div class="col-md-8">
            <input class="form-control @error('image_path') is-invalid @enderror" type="file" id="image_path" name="image_path" onchange="previewImage()">
            @error('image_path')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="name">Nama Perawatan</label>
        </div>
        <div class="col-md-8">
            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="category_id">Kategori Perawatan</label>
        </div>
        <div class="col-md-8">
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                <option value="" selected disabled hidden>Pilih kategori</option>
                @foreach($categories as $category) @if(old('category_id') == $category->category_id)
                <option value="{{ $category->category_id }}" selected>{{ $category->category_name }}</option>
                @else
                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                @endif @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="description">Deskripsi Perawatan</label>
        </div>
        <div class="col-md-8">
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" style="height: 100px" value="{{ old('description') }}">{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="duration">Durasi Perawatan</label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <input type="number" class="form-control @error('duration') is-invalid @enderror form-quantity" id="duration" name="duration" value="{{ old('duration', 1) }}" min="1" max="1000">
                <span class="input-group-text">Menit</span>
            </div>
            @error('duration')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label" for="price">Harga Perawatan</label>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
            </div>

            @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="d-flex justify-content-center mt-4">
            <a href="/manage-services" type="button" class="btn btn-outline-danger mx-3">Batal</a>
            <button type="submit" class="btn button-outline-reztya me-2">Simpan</button>
        </div>
    </form>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#image_path');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection