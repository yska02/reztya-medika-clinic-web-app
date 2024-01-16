@extends('layout/main')

@section('title', 'Tentang Kami')

@section('container')
<div class="d-flex justify-content-center mb-5">
    <div class="border outline-reztya rounded-4 p-5 font-futura-reztya" style="width: 85%;">
        <div class="py-3 d-flex justify-content-center pt-4">
            <p class="h5 fw-bold unselectable font-alander-reztya">Tentang Kami</p>
        </div>
        <div class="d-flex justify-content-center">
            <div class="row">
                <h5 class="unselectable h4 d-flex align-items-center mb-0 mt-3 mb-4">Klinik Reztya Medika</h5>
                <div class="col-6">
                    <div class="row">
                        <p class="unselectable h5 d-flex align-items-center mb-0 mt-2">Alamat</p>
                    </div>
                    <div class="row">
                        <h6 class="selectable d-flex align-items-center mb-0 mt-2"><a class="text-reztya text-decoration-none" target="_blank" href="{{url('https://goo.gl/maps/yeL4eM1M5zUtUcD78')}}">Perumahan Borneo Indah I <br>Jl. Karya Bersama Blok J 1, RW.2, <br>Tanah Merah, Kecamatan Siak Hulu, <br>Kabupaten Kampar, Riau 28284 Indonesia</a></h6>
                    </div>
                    <div class="row mt-5">
                        <p class="unselectable h5 d-flex align-items-center mb-0 mt-2">Kontak Kami</p>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <i class="d-flex align-items-center mb-0 mt-3 fa fa-lg fa-mobile" style="margin-left: 2px" aria-hidden="true"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="d-flex align-items-center mb-0 mt-2"><a class="text-reztya text-decoration-none" href="tel:082384163709">082384163709</a></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <i class="d-flex align-items-center mb-0 mt-3 fa fa-lg fa-envelope" aria-hidden="true"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="d-flex align-items-center mb-0 mt-2"><a class="text-reztya text-decoration-none" href="mailto:klinikreztya@gmail.com">klinikreztya@gmail.com</a></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <i class="d-flex align-items-center mb-0 mt-3 fa fa-lg fa-instagram" style="margin-left: 1px" aria-hidden="true"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="d-flex align-items-center mb-0 mt-2"><a class="text-reztya text-decoration-none" target="_blank" href="https://www.instagram.com/reztyaofficial/">Klinik Reztya Medika</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row unselectable">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6981852517197!2d101.46905079999999!3d0.4446282999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5af7cc74c4d3b%3A0x27e436a25ed270df!2sKlinik%20Reztya%20Medika!5e0!3m2!1sen!2sid!4v1674034576590!5m2!1sen!2sid" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
