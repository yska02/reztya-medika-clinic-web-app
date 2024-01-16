@php
    use Carbon\Carbon;
@endphp

<h3>Halo Klinik Reztya Medika,</h3>
<p>Pengguna <strong>{{$content['username']}}</strong> memberikan Kritik dan Saran pada pesanan dengan informasi sebagai berikut:</p>

<br>
<div class="container">
<p>Nama Pelanggan&emsp;&emsp;: {{ $content['name'] }}</p>
<p>Nomor Order &emsp; &emsp; &emsp;: {{ $content['order_id'] }}</p>
<p>Tanggal Order&emsp;&emsp; &emsp;: {{ Carbon::parse($content['order_date'])->translatedFormat('d F Y') }}</p>
<p>Kritik dan Saran&emsp; &emsp; : <strong>"{{ $content['review'] }}"</strong></p>
</div>
<br>
<a class="text-decoration-none font-futura-reztya" href="http://127.0.0.1:8000/order-detail/{{$content['order_id']}}">Link Kritik dan Saran</a>
