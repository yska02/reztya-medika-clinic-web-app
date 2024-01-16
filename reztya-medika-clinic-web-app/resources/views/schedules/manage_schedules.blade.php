@extends('layout/main')

@section('title', 'Manage Schedule')

@section('container')
@php
    use Carbon\Carbon;
@endphp
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
            <p class="h5 fw-bold unselectable font-alander-reztya">Daftar Jadwal Perawatan</p>
        </div>
    </div>
    <div class="mt-2 mb-4">
    <a href="{{ url('/add-schedule') }}" class="btn button-outline-reztya my-3"><i class="fa-solid fa-plus"></i> Tambah Jadwal</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="text-center table-head-reztya">
                <th scope="col">No.</th>
                <th scope="col">Hari, Tanggal</th>
                <th scope="col">Waktu Mulai</th>
                <th scope="col">Waktu Berakhir</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>        
        <tbody>
            @if($schedules->isEmpty())
            <tr>
                <td colspan="5" class="text-center">Jadwal tidak tersedia</td>
            </tr>
            @else
            @php
                $i = 1
            @endphp
            @foreach($schedules as $schedule)
            <tr class="align-middle text-center">
                <td>{{ $i++ }}</td>
                <td>{{ Carbon::parse($schedule->start_time)->translatedFormat('l, d F Y') }} </td>
                <td>{{ Carbon::parse($schedule->start_time)->translatedFormat('H:i') }} WIB</td>
                <td>{{ Carbon::parse($schedule->end_time)->translatedFormat('H:i') }} WIB</td>
                @if ($schedule->status == 'available')
                    <td>Tersedia</td>
                @else
                    <td>Tidak Tersedia</td>
                @endif
                <td>
                    <a href="/edit-schedule/{{$schedule->schedule_id}}" type="button" class="btn button-outline-reztya btn-sm" title="Edit Jadwal">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <a href="/delete-schedule/{{$schedule->schedule_id}}" type="button" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" title="Hapus Jadwal">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
              </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection