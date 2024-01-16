
@if(Auth::user()->user_role_id == 1)
<h3>Halo {{ $content['username'] }},</h3>
<p>Jadwal perawatan {{ $content['service_name'] }} anda pada tanggal {{ $content['old_schedule'] }} WIB telah mengalami perubahan, berikut informasinya:</p>
@else
<h3>Halo Klinik Reztya Medika,</h3>
<p>Jadwal perawatan pelanggan pada tanggal {{ $content['old_schedule'] }} WIB telah mengalami perubahan, berikut informasinya:</p>
@endif

<br>
<div class="container">
<p>Nomor Order &emsp;&emsp;&emsp;: {{ $content['order_id'] }}</p>
<p>Nama Pelanggan &emsp;: {{ $content['name'] }}</p>
<p>Nama Perawatan &emsp;: {{ $content['service_name'] }}</p>
<p>Jadwal Terbaru &emsp;&emsp;: {{ $content['new_schedule'] }} WIB</p>
</div>
<br>
@if(Auth::user()->user_role_id == 1)
<p>Mohon maaf atas ketidaknyamanannya, jika anda mempunyai pertanyaan lebih lanjut,
  silahkan menghubungi Admin Klinik Reztya Medika: 082384163709 atau email ke klinikreztya@gmail.com.</p>
@endif
<br>
<p>Terima kasih.</p>