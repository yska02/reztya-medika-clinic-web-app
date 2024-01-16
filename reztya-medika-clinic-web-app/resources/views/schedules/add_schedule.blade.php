@extends('layout/main')

@section('title', 'Add Schedule')

@section('container')
<div class="d-flex justify-content-center">
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya d-flex flex-column add-schedule align-self-center" style="width: 50%;">
        <div class="py-3 d-flex justify-content-center pt-4">
            <p class="h5 fw-bold unselectable font-alander-reztya m-0">Tambah Jadwal</p>
        </div>
        <form action="/add-schedule" method="POST">
            @csrf
            <div class="container">
                <div class="col mb-2">
                    <p class="mb-2">Waktu Mulai</p>
                    <input class="ps-3 form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" type="datetime-local">
                    @error('start_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col mb-2">
                    <p class="mb-2">Waktu Berakhir</p>
                    <input class=" ps-3 form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" type="datetime-local">
                    @error('end_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4 mb-2">
                <a href="/manage-schedules" type="button" class="btn btn-outline-danger mx-3">Batal</a>
                <button type="submit" class="btn btn-outline-success me-2">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection