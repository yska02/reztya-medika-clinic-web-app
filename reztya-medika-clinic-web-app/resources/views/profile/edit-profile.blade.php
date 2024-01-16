@extends('layout/main')
@section('title', 'Profile')

@section('container')
<div class="unselectable container bg-white sign-box">
    @if(session()->has('updateError'))
    <div class="alert alert-danger alert-dismissible fade show font-futura-reztya" role="alert">
        {{session('updateError')}}
        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="pt-4">
        <div class="py-3 d-flex justify-content-center">
            <p class="h5 fw-bold unselectable font-alander-reztya">Edit Profil</p>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-2 bg-white font-futura-reztya">
        <div class="profile-box">
            <form action="/edit-profile/{{auth()->user()->username}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-center mb-3">
                    <div class="col-auto">
                        <img width="200px" src="{{asset('storage/' . auth()->user()->profile_picture)}}" class="bg-secondary img-thumbnail rounded-circle" id="preview" aria-expanded="false" alt="Profile Picture">
                    </div>
                </div>
                <div class="card outline-reztya">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="name" class="col-form-label">Foto</label>
                                </div>
                                <div class="col-md-9 mt-1">
                                    <input type="file" name="photo" class="shadow-none form-control form-control-sm @error('photo') is-invalid @enderror" aria-describedby="photo" onchange="loadFile(event)">
                                    @error('photo')
                                    <div class="invalid-feedback">
                                        Format foto wajib JPEG, JPG, SVG, GIF, atau PNG
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="username" class="col-form-label">Username</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" name="username" class="shadow-none form-control form-control-sm @error('username') is-invalid @enderror" aria-describedby="username" value="{{old('username', auth()->user()->username)}}">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        Username wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="name" class="col-form-label">Nama Lengkap</label>
                                </div>
                                <div class="col-md-9 mt-2">
                                    <input type="text" name="name" class="shadow-none form-control form-control-sm @error('name') is-invalid @enderror" aria-describedby="name" value="{{old('name', auth()->user()->name)}}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        Nama lengkap wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="birthdate" class="col-form-label">Tanggal Lahir</label>
                                </div>
                                <div class="col-md-5 mt-2">
                                    <input type="date" name="birthdate" class="shadow-none form-control form-control-sm @error('birthdate') is-invalid @enderror" aria-describedby="birthdate" value="{{old('birthdate', auth()->user()->birthdate)}}">
                                    @error('birthdate')
                                    <div class="invalid-feedback">
                                        Tanggal lahir wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="phone" class="col-form-label">Nomor Telepon</label>
                                </div>
                                <div class="col-md-9 mt-3">
                                    <input type="number" name="phone" class="shadow-none form-control form-control-sm @error('phone') is-invalid @enderror" aria-describedby="phone" value="{{old('phone', auth()->user()->phone)}}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        Nomor telepon wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="province_id" class="col-form-label">Provinsi</label>
                                </div>
                                <div class="col-md-9 mt-1">
                                    <select name="province_id" id="province_id" class="form-select form-select-sm shadow-none @error('province_id') is-invalid @enderror" aria-label="Default select example">
                                        <option disabled selected>{{$provinceOrigin}}</option>
                                        @foreach($provinces as $province)
                                        <option value="{{$province['province_id']}}">{{$province['province']}}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                    <div class="invalid-feedback">
                                        Provinsi wajib dipilih
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-3">
                                    <label for="city_id" class="col-form-label">Kota / Kabupaten</label>
                                </div>
                                <div class="col-md-9 mt-1">
                                    <select disabled name="city_id" id="city_id" class="form-select form-select-sm shadow-none @error('city_id') is-invalid @enderror" aria-label="Default select example">
                                        <option disabled selected>{{$cityOrigin}}</option>
                                    </select>
                                    @error('city_id')
                                    <div class="invalid-feedback">
                                        Kota / Kabupaten wajib dipilih
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="address" class="col-form-label">Alamat</label>
                                </div>
                                <div class="col-md-9 mt-1">
                                    <textarea name="address" class="shadow-none form-control form-control-sm @error('address') is-invalid @enderror" aria-describedby="address">{{old('address', auth()->user()->address)}}</textarea>
                                    @error('address')
                                    <div class="invalid-feedback">
                                        Alamat wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="email" class="col-form-label">Email</label>
                                </div>
                                <div class="col-md-9 mt-1">
                                    <input type="text" name="email" class="shadow-none form-control form-control-sm @error('email') is-invalid @enderror" aria-describedby="email" value="{{old('email', auth()->user()->email)}}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        Email wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="password" class="col-form-label">Kata Sandi</label>
                                </div>
                                <div class="col-md-9 mt-1">
                                    <input type="password" name="password" class="shadow-none form-control form-control-sm @error('password') is-invalid @enderror" aria-describedby="password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        Kata sandi wajib diisi / harus sesuai
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="d-flex justify-content-center mt-4 mb-5">
                    <a href="/view-profile/{{auth()->user()->username}}" type="button" class="btn btn-outline-danger mx-3">Batal</a>
                    <button type="submit" class="btn button-outline-reztya me-2"  onclick="return confirm('Apakah anda yakin mengubah profil?')">Simpan</button>
                </div>
                    
            </form>
            <form action="/change-password/{{auth()->user()->username}}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(session()->has('passwordChangeError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('passwordChangeError')}}
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="d-flex justify-content-center">
                    <div class="pt-3 mb-4">
                        <div class="d-flex justify-content-center">
                            <p class="h5 fw-bold unselectable font-alander-reztya">Ubah Kata Sandi</p>
                        </div>
                    </div>
                </div>
                <div class="card outline-reztya">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="oldpass" class="col-form-label">Kata Sandi Lama</label>
                                </div>
                                <div class="col-md-8 mt-3">
                                    <input type="password" name="oldpass" class="shadow-none form-control form-control-sm @error('oldpass') is-invalid @enderror" aria-describedby="oldpass">
                                    @error('oldpass')
                                    <div class="invalid-feedback">
                                        Kata sandi lama wajib diisi / harus sesuai
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="newpass" class="col-form-label">Kata Sandi Baru</label>
                                </div>
                                <div class="col-md-8 mt-3">
                                    <input type="password" name="newpass" class="shadow-none form-control form-control-sm @error('newpass') is-invalid @enderror" aria-describedby="newpass">
                                    @error('newpass')
                                    <div class="invalid-feedback">
                                        Kata sandi baru wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-profile">
                            <div class="row">
                                <div class="col-3">
                                    <label for="confnewpass" class="col-form-label">Konfirmasi Kata Sandi Baru</label>
                                </div>
                                <div class="col-md-8 mt-4">
                                    <input type="password" name="confnewpass" class="shadow-none form-control form-control-sm @error('confnewpass') is-invalid @enderror" aria-describedby="confnewpass">
                                    @error('confnewpass')
                                    <div class="invalid-feedback">
                                        Konfirmasi kata sandi baru wajib diisi
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="d-flex justify-content-center mt-3 mb-5">
                    <a href="/view-profile/{{auth()->user()->username}}" type="button" class="btn btn-outline-danger mx-3">Batal</a>
                    <button class="btn button-outline-reztya" type="submit" onclick="return confirm('Apakah anda yakin mengubah kata sandi?')">Simpan</button>
                </div>
            </form>
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

    var city = JSON.parse({{\Illuminate\Support\Js::from($response)}});

    document.getElementById('province_id').onchange = function() {
        if (this.value === '0') {
            document.getElementById('city_id').disabled = true;
        } else {
            document.getElementById('city_id').disabled = false;

            var option = "<option disabled selected>Kota / Kabupaten</option>";
            const length = city.rajaongkir.results;

            for (const id in length) {
                if (city.rajaongkir.results[id].province_id === document.getElementById('province_id').value) {
                    if (city.rajaongkir.results[id].type === 'Kota') {
                        option += "<option value='" + city.rajaongkir.results[id].city_id + "'>Kota " + city.rajaongkir.results[id].city_name + "</option>";
                    } else if (city.rajaongkir.results[id].type === 'Kabupaten') {
                        option += "<option value='" + city.rajaongkir.results[id].city_id + "'>Kab. " + city.rajaongkir.results[id].city_name + "</option>";
                    } else {
                        option += "<option value='" + city.rajaongkir.results[id].city_id + "'>" + city.rajaongkir.results[id].city_name + "</option>";
                    }
                }
            }
            document.getElementById('city_id').innerHTML = option;
        }
    }
</script>
@endsection