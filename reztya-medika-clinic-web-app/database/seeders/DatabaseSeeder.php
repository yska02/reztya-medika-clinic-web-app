<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'user_role_name' => 'Admin'
        ]);

        DB::table('user_roles')->insert([
            'user_role_name' => 'Member'
        ]);

        DB::table('users')->insert([
            'user_role_id' => 1,
            'username' => 'Admin',
            'name' => 'Admin Admin Admin',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Your Heart my Darling',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false,
            'city_id' => 166,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'user_role_id' => 2,
            'username' => 'harishsaid',
            'name' => 'Harish Said Bustomi',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Jalan KH. Soleh Iskandar',
            'email' => 'harishsaid37@gmail.com',
            'password' => bcrypt('member'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false,
            'city_id' => 457,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'user_role_id' => 2,
            'username' => 'indahmursyida',
            'name' => 'Indah Mursyida Bahrina',
            'birthdate' => '2001-05-31',
            'phone' => '082173132215',
            'address' => 'Jalan Fedora VIII',
            'email' => 'indahbahrina@gmail.com',
            'password' => bcrypt('member'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false,
            'city_id' => 457,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'user_role_id' => 2,
            'username' => 'yesika',
            'name' => 'Yesika',
            'birthdate' => '2001-11-02',
            'phone' => '085162647060',
            'address' => 'Jalan Manggala IV',
            'email' => 'yesikaa02@gmail.com',
            'password' => bcrypt('member'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false,
            'city_id' => 456,
            'email_verified_at' => now()
        ]);
        Category::create([
            'category_name' => 'Healthy Food'
        ]);

        Category::create([
            'category_name' => 'Body Care'
        ]);


        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '27-02-2023 10.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '27-02-2023 11.00'),
            'status' => 'unavailable'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '27-02-2023 14.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '27-02-2023 15.00'),
            'status' => 'unavailable'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '28-02-2023 10.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '28-02-2023 11.00'),
            'status' => 'available'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '28-02-2023 15.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '28-02-2023 16.00'),
            'status' => 'available'
        ]);

        // Cart::create([
        //     'user_id' => 2,
        //     'service_id' => 2,
        //     'schedule_id' => 2,
        //     'home_service' => 1,
        // ]);

        // Cart::create([
        //     'user_id' => 2,
        //     'service_id' => 1,
        //     'schedule_id' => 1,
        //     'home_service' => 0
        // ]);

        // Cart::create([
        //     'user_id' => 2,
        //     'product_id' => 1,
        //     'quantity' => 1
        // ]);

        // Cart::create([
        //     'user_id' => 2,
        //     'product_id' => 2,
        //     'quantity' => 3
        // ]);

        // Cart::create([
        //     'user_id' => 3,
        //     'service_id' => 2,
        //     'schedule_id' => 2,
        //     'home_service' => 1,
        // ]);

        // Cart::create([
        //     'user_id' => 3,
        //     'product_id' => 2,
        //     'quantity' => 3
        // ]);

        Product::create([
            'name' => 'Susu Almond (Small)',
            'category_id' => '1',
            'description' => "Manfaat Susu Almond\r\n
                                1. Mengurangi resiko penyakit jantung\r\n
                                2. Mencegah kanker\r\n
                                3. Menurunkan kadar kolestrol jahat\r\n
                                4. Meningkatkan kinerja dan kecerdasan otak\r\n
                                5. Menguatkan tulang\r\n
                                6. Tinggi antioksidan\r\n
                                7. Mengurangi resiko penyakit diabetes\r\n
                                8. Baik untuk diet\r\n
                                9. Tinggi kandungan vitamin E\r\n
                                10. Sangat baik dikonsumsi bumil dan busui untuk tumbuh kembang si kecil\r\n",
            'size' => '250 ml',
            'price' => '27000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susu-almond-small.jpg'
        ]);

        Product::create([
            'name' => 'Susu Almond (Medium)',
            'category_id' => '1',
            'description' => "Manfaat Susu Almond\r\n
                                1. Mengurangi resiko penyakit jantung\r\n
                                2. Mencegah kanker\r\n
                                3. Menurunkan kadar kolestrol jahat\r\n
                                4. Meningkatkan kinerja dan kecerdasan otak\r\n
                                5. Menguatkan tulang\r\n
                                6. Tinggi antioksidan\r\n
                                7. Mengurangi resiko penyakit diabetes\r\n
                                8. Baik untuk diet\r\n
                                9. Tinggi kandungan vitamin E\r\n
                                10. Sangat baik dikonsumsi bumil dan busui untuk tumbuh kembang si kecil\r\n",
            'size' => '500 ml',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susu-almond-medium.jpg'
        ]);

        Product::create([
            'name' => 'Susu Almond (Large)',
            'category_id' => '1',
            'description' => "Manfaat Susu Almond\r\n
                                1. Mengurangi resiko penyakit jantung\r\n
                                2. Mencegah kanker\r\n
                                3. Menurunkan kadar kolestrol jahat\r\n
                                4. Meningkatkan kinerja dan kecerdasan otak\r\n
                                5. Menguatkan tulang\r\n
                                6. Tinggi antioksidan\r\n
                                7. Mengurangi resiko penyakit diabetes\r\n
                                8. Baik untuk diet\r\n
                                9. Tinggi kandungan vitamin E\r\n
                                10. Sangat baik dikonsumsi bumil dan busui untuk tumbuh kembang si kecil\r\n",
            'size' => '1000 ml',
            'price' => '95000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susu-almond-large.jpg'
        ]);

        Product::create([
            'name' => 'Sari Lemon California (Small)',
            'category_id' => '1',
            'description' => "Manfaat Sari Lemon California\r\n
                                1. Proses detox (racun) dalam tubuh\r\n
                                2. Menurunkan berat badan\r\n
                                3. Mencerahkan wajah dan menghilangkan jerawat\r\n
                                4. Menurunkan kolestrol, diabetes dan asam urat\r\n
                                5. Mengobati sakit tenggorokan & batuk\r\n
                                6. Mengobati maag\r\n
                                7. Mengatasi sembelit\r\n
                                8. Mencegah timbulnya sakit kanker\r\n
                                9. Mencegah bau mulut\r\n",
            'size' => '250 ml',
            'price' => '60000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/lemonsmall.jpg'
        ]);

        Product::create([
            'name' => 'Sari Lemon California (Medium)',
            'category_id' => '1',
            'description' => "Manfaat Sari Lemon California\r\n
                                1. Proses detox (racun) dalam tubuh\r\n
                                2. Menurunkan berat badan\r\n
                                3. Mencerahkan wajah dan menghilangkan jerawat\r\n
                                4. Menurunkan kolestrol, diabetes dan asam urat\r\n
                                5. Mengobati sakit tenggorokan & batuk\r\n
                                6. Mengobati maag\r\n
                                7. Mengatasi sembelit\r\n
                                8. Mencegah timbulnya sakit kanker\r\n
                                9. Mencegah bau mulut\r\n",
            'size' => '500 ml',
            'price' => '100000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/lemonmedium.jpg'
        ]);

        Product::create([
            'name' => 'Safron',
            'category_id' => '1',
            'description' => "Manfaat Safron Afghanistan\r\n
                                * Melancarkan peredaran darah\r\n
                                * Mencegah pertumbuhan sel kanker\r\n
                                * Mengatasi sistem gangguan pencernaan\r\n
                                * Mencegah stress & depresi\r\n
                                * Mempercepat pengeringan luka\r\n
                                * Meringankan batuk\r\n
                                * Menghilangkan jerawat\r\n
                                * Mencegah peradangan paru-paru mengurangi penyakit insomnia\r\n
                                * Menurunkan kadar kolestrol dalam darah\r\n
                                * Mengembalikan stamina tubuh menguatkan sistem imun sebagai anti aging\r\n",
            'size' => '1 gr',
            'price' => '110000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/safron.jpg'
        ]);

        Product::create([
            'name' => 'Chiaseed (Small)',
            'category_id' => '1',
            'description' => "Manfaat Chiaseed\r\n
                                * Memberikan tambahan energi bagi tubuh\r\n
                                * Membantu proses pembentukan tulang dan gigi\r\n
                                * Kaya akan asam lemak dan omega-3\r\n
                                * Memerangi kanker payudara dan kanker lainnya\r\n
                                * Mencegah penuaan dini\r\n
                                * Membantu proses detoksivikasi\r\n
                                * Membantu menyeimbangkan berat badan\r\n
                                * Membantu menurunkan kolestrol\r\n
                                * Menurunkan resiko penyakit diabetes\r\n
                                * Menstabilkan tekanan darah\r\n",
            'size' => '100 gr',
            'price' => '25000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/chiaseedsmall.jpg'
        ]);

        Product::create([
            'name' => 'Chiaseed (Medium)',
            'category_id' => '1',
            'description' => "Manfaat Chiaseed\r\n
                                * Memberikan tambahan energi bagi tubuh\r\n
                                * Membantu proses pembentukan tulang dan gigi\r\n
                                * Kaya akan asam lemak dan omega-3\r\n
                                * Memerangi kanker payudara dan kanker lainnya\r\n
                                * Mencegah penuaan dini\r\n
                                * Membantu proses detoksivikasi\r\n
                                * Membantu menyeimbangkan berat badan\r\n
                                * Membantu menurunkan kolestrol\r\n
                                * Menurunkan resiko penyakit diabetes\r\n
                                * Menstabilkan tekanan darah\r\n",
            'size' => '250 gr',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/chiaseedmedium.jpg'
        ]);

        Product::create([
            'name' => 'Granola Honey',
            'category_id' => '1',
            'description' => "Komposisi:\r\n
                                Almond, mede, cranberry, rolled oat, kismis kuning, kismis hitam, pumpkin, sunflower\r\n
                                Manfaat Granola Honey\r\n
                                * Memperbaiki sistem pencernaan\r\n
                                * Meningkatkan sistem kekebalan tubuh\r\n
                                * Membantu menurunkan berat badan\r\n
                                * Meningkatkan energi\r\n
                                * Menurunkan kolestrol\r\n
                                * Mendukung kehamilan yang sehat\r\n
                                * Mengatur tekanan darah\r\n
                                * Mengatasi beberapa kondisi medis\r\n
                                * Mengandung protein nabati yang tinggi\r\n",
            'size' => ' gr',
            'price' => '65000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/granola.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Small)',
            'category_id' => '1',
            'description' => "Fungsi madu ternyata tidak sebatas menjadi pemanis alami bagi makanan ataupun bahan masker untuk memperhalus kulit wajah. Tak hanya itu, madu juga memiliki untuk penyembuhan luka karena:\r\n
                                1 Senyawa antibakteri\r\n
                                2. PH rendah\r\n
                                3. Kandungan qula alami\r\n
                                4. Antioksidan\r\n",
            'size' => '250 gr',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/maduhutansmall.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Medium)',
            'category_id' => '1',
            'description' => "Fungsi madu ternyata tidak sebatas menjadi pemanis alami bagi makanan ataupun bahan masker untuk memperhalus kulit wajah. Tak hanya itu, madu juga memiliki untuk penyembuhan luka karena:\r\n
                            1 Senyawa antibakteri\r\n
                            2. PH rendah\r\n
                            3. Kandungan qula alami\r\n
                            4. Antioksidan\r\n",
            'size' => '500 gr',
            'price' => '95000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/maduhutanmedium.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Large)',
            'category_id' => '1',
            'description' => "Fungsi madu ternyata tidak sebatas menjadi pemanis alami bagi makanan ataupun bahan masker untuk memperhalus kulit wajah. Tak hanya itu, madu juga memiliki untuk penyembuhan luka karena:\r\n
                                1 Senyawa antibakteri\r\n
                                2. PH rendah\r\n
                                3. Kandungan qula alami\r\n
                                4. Antioksidan\r\n",
            'size' => '1000 gr',
            'price' => '180000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/maduhutanlarge.jpg'
        ]);

        Service::create([
            'name' => 'Bekam',
            'category_id' => '2',
            'description' => "Manfaat Bekam (Sunnah dan Steril)\r\n
                            ㆍ Membuang sel-sel darah yang mati\r\n
                            ㆍ Menstabilkan tekanan darah\r\n
                            ㆍ Melancarkan peredaran darah\r\n
                            ㆍ Mengeluarkan toksin dalam tubuh\r\n
                            ㆍ Menghilangkan angin dalam badan\r\n
                            ㆍ Mengurangi kolestrol dalam tubuh\r\n
                            ㆍ Meringankan tubuh\r\n
                            ㆍ Melegakan sakit kepala\r\n
                            ㆍ Mengatasi kelelahan\r\n",
            'duration' => '30',
            'price' => '150000',
            'image_path' => '/service-images/bekam.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah, Setrika Wajah, dan Masker',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah\r\n
                                ㆍMencegah penuaan dini\r\n
                                ㆍMelancarkan peredaran darah\r\n
                                ㆍMerelaksasi otot wajah\r\n
                                ㆍMenghilangkan stress\r\n
                                ㆍMengatasi sinusitis\r\n
                                ㆍMengecilkan pori-pori\r\n
                                ㆍDetox kulit secara alami\r\n
                                ㆍMembuat wajah lebih bercahaya\r\n
                                Manfaat Setrika Wajah\r\n
                                ㆍMengencangkan kulit wajah yang sudah mulai mengendur\r\n
                                ㆍMembantu menghilangkan garis-garis halus dan keriput\r\n
                                ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda\r\n
                                ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.\r\n
                                ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini\r\n
                                ㆍUntuk menghilangkan masalah pada kantung mata\r\n
                                Manfaat Setrika Wajah\r\n
                                ㆍMengencangkan kulit wajah yang sudah mulai mengendur\r\n
                                ㆍMembantu menghilangkan garis-garis halus dan keriput\r\n
                                ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda\r\n
                                ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.\r\n
                                ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini\r\n
                                ㆍUntuk menghilangkan masalah pada kantung mata\r\n
                                Manfaat Masker\r\n
                                ㆍMemberi nutrisi ke kulit wajah\r\n
                                ㆍMelembabkan kulit wajah\r\n
                                ㆍMengencangkan kulit wajah\r\n
                                ㆍMenghaluskan kulit wajah\r\n
                                ㆍMencerahkan kulit wajah\r\n
                                ㆍEksfoliasi kulif wajah\r\n
                                ㆍMeredakan masalah kulit wajah\r\n",
            'duration' => '60',
            'price' => '250000',
            'image_path' => '/service-images/psm.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah dan Setrika Wajah',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah\r\n
                            ㆍMencegah penuaan dini\r\n
                            ㆍMelancarkan peredaran darah\r\n
                            ㆍMerelaksasi otot wajah\r\n
                            ㆍMenghilangkan stress\r\n
                            ㆍMengatasi sinusitis\r\n
                            ㆍMengecilkan pori-pori\r\n
                            ㆍDetox kulit secara alami\r\n
                            ㆍMembuat wajah lebih bercahaya\r\n
                            Manfaat Setrika Wajah\r\n
                            ㆍMengencangkan kulit wajah yang sudah mulai mengendur\r\n
                            ㆍMembantu menghilangkan garis-garis halus dan keriput\r\n
                            ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda\r\n
                            ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.\r\n
                            ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini\r\n
                            ㆍUntuk menghilangkan masalah pada kantung mata\r\n",
            'duration' => '60',
            'price' => '225000',
            'image_path' => '/service-images/ps.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah, Lumi SPA, Setrika Wajah, Masker',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah\r\n
                                ㆍMencegah penuaan dini\r\n
                                ㆍMelancarkan peredaran darah\r\n
                                ㆍMerelaksasi otot wajah\r\n
                                ㆍMenghilangkan stress\r\n
                                ㆍMengatasi sinusitis\r\n
                                ㆍMengecilkan pori-pori\r\n
                                ㆍDetox kulit secara alami\r\n
                                ㆍMembuat wajah lebih bercahaya\r\n

                                Manfaat Lumi SPA\r\n
                                ㆍMembersihkan pori-pori dengan sempurna\r\n
                                ㆍTeknologi Oscillation mampu mengangkat kotoran dan minyak di wajah\r\n
                                ㆍMengangkat sel-sel kulit mati\r\n
                                ㆍMampu meningkatkan kesehatan kulit wajah\r\n
                                ㆍDapat mengurangi tanda-tanda penuaan\r\n
                                ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal\r\n
                                ㆍMengatasijerawat dan masalah kulit wajah\r\n
                                ㆍMerangsang produksi kolagen\r\n

                                Manfaat Setrika Wajah\r\n
                                ㆍMengencangkan kulit wajah yang sudah mulai mengendur\r\n
                                ㆍMembantu menghilangkan garis-garis halus dan keriput\r\n
                                ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda\r\n
                                ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.\r\n
                                ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini\r\n
                                ㆍUntuk menghilangkan masalah pada kantung mata\r\n

                                Manfaat Masker\r\n
                                ㆍMemberi nutrisi ke kulit wajah\r\n
                                ㆍMelembabkan kulit wajah\r\n
                                ㆍMengencangkan kulit wajah\r\n
                                ㆍMenghaluskan kulit wajah\r\n
                                ㆍMencerahkan kulit wajah\r\n
                                ㆍEksfoliasi kulif wajah\r\n
                                ㆍMeredakan masalah kulit wajah\r\n",
            'duration' => '50',
            'price' => '325000',
            'image_path' => '/service-images/plsm.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah dan Lumi SPA',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah\r\n
                                ㆍMencegah penuaan dini\r\n
                                ㆍMelancarkan peredaran darah\r\n
                                ㆍMerelaksasi otot wajah\r\n
                                ㆍMenghilangkan stress\r\n
                                ㆍMengatasi sinusitis\r\n
                                ㆍMengecilkan pori-pori\r\n
                                ㆍDetox kulit secara alami\r\n
                                ㆍMembuat wajah lebih bercahaya\r\n

                                Manfaat Lumi SPA\r\n
                                ㆍMembersihkan pori-pori dengan sempurna\r\n
                                ㆍTeknologi Oscillation mampu mengangkat kotoran dan minyak di wajah\r\n
                                ㆍMengangkat sel-sel kulit mati\r\n
                                ㆍMampu meningkatkan kesehatan kulit wajah\r\n
                                ㆍDapat mengurangi tanda-tanda penuaan\r\n
                                ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal\r\n
                                ㆍMengatasijerawat dan masalah kulit wajah\r\n
                                ㆍMerangsang produksi kolagen\r\n",
            'duration' => '50',
            'price' => '175000',
            'image_path' => '/service-images/pl.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah, Lumi SPA, dan Setrika Wajah',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah\r\n
                                ㆍMencegah penuaan dini\r\n
                                ㆍMelancarkan peredaran darah\r\n
                                ㆍMerelaksasi otot wajah\r\n
                                ㆍMenghilangkan stress\r\n
                                ㆍMengatasi sinusitis\r\n
                                ㆍMengecilkan pori-pori\r\n
                                ㆍDetox kulit secara alami\r\n
                                ㆍMembuat wajah lebih bercahaya\r\n
                                Manfaat Lumi SPA\r\n
                                ㆍMembersihkan pori-pori dengan sempurna\r\n
                                ㆍTeknologi Oscillation mampu mengangkat kotoran dan minyak di wajah\r\n
                                ㆍMengangkat sel-sel kulit mati\r\n
                                ㆍMampu meningkatkan kesehatan kulit wajah\r\n
                                ㆍDapat mengurangi tanda-tanda penuaan\r\n
                                ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal\r\n
                                ㆍMengatasijerawat dan masalah kulit wajah\r\n
                                ㆍMerangsang produksi kolagen\r\n

                                Manfaat Setrika Wajah\r\n
                                ㆍMengencangkan kulit wajah yang sudah mulai mengendur\r\n
                                ㆍMembantu menghilangkan garis-garis halus dan keriput\r\n
                                ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda\r\n
                                ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.\r\n
                                ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini\r\n
                                ㆍUntuk menghilangkan masalah pada kantung mata\r\n",
            'duration' => '50',
            'price' => '275000',
            'image_path' => '/service-images/pls.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah, Lumi SPA, Setrika Wajah, Masker, Totok Inner Beauty',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah\r\n
                                ㆍMencegah penuaan dini\r\n
                                ㆍMelancarkan peredaran darah\r\n
                                ㆍMerelaksasi otot wajah\r\n
                                ㆍMenghilangkan stress\r\n
                                ㆍMengatasi sinusitis\r\n
                                ㆍMengecilkan pori-pori\r\n
                                ㆍDetox kulit secara alami\r\n
                                ㆍMembuat wajah lebih bercahaya\r\n

                                Manfaat Lumi SPA\r\n
                                ㆍMembersihkan pori-pori dengan sempurna\r\n
                                ㆍTeknologi Oscillation mampu mengangkat kotoran dan minyak di wajah\r\n
                                ㆍMengangkat sel-sel kulit mati\r\n
                                ㆍMampu meningkatkan kesehatan kulit wajah\r\n
                                ㆍDapat mengurangi tanda-tanda penuaan\r\n
                                ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal\r\n
                                ㆍMengatasijerawat dan masalah kulit wajah\r\n
                                ㆍMerangsang produksi kolagen\r\n

                                Manfaat Setrika Wajah\r\n
                                ㆍMengencangkan kulit wajah yang sudah mulai mengendur\r\n
                                ㆍMembantu menghilangkan garis-garis halus dan keriput\r\n
                                ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda\r\n
                                ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.\r\n
                                ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini\r\n
                                ㆍUntuk menghilangkan masalah pada kantung mata\r\n

                                Manfaat Masker\r\n
                                ㆍMemberi nutrisi ke kulit wajah\r\n
                                ㆍMelembabkan kulit wajah\r\n
                                ㆍMengencangkan kulit wajah\r\n
                                ㆍMenghaluskan kulit wajah\r\n
                                ㆍMencerahkan kulit wajah\r\n
                                ㆍEksfoliasi kulif wajah\r\n
                                ㆍMeredakan masalah kulit wajah",
            'duration' => '120',
            'price' => '385000',
            'image_path' => '/service-images/plsmt.jpg'
        ]);

        Service::create([
            'name' => 'Totok Punggung',
            'category_id' => '2',
            'description' => "Manfaat Totok Punggung\r\n 
            Metode pengobatan yang dilakukan dengan menggunakan jari untuk memberikan stimulan pada titik / simpul syaraf tertentu yang terpusat di area tulang belakang, yang mana titik / simpul tersebut itu terkoneksi langsung dengan keluhan penyakit atau organ yang sedang mengalami gangguan.\r\n",
            'duration' => '30',
            'price' => '100000',
            'image_path' => '/service-images/totokpunggung.jpg'
        ]);

        Service::create([
            'name' => 'Akupuntur Kecantikan & Kesehatan',
            'category_id' => '2',
            'description' => 'Deskripsi Akupuntur Kecantikan & Kesehatan',
            'duration' => '30',
            'price' => '125000',
            'image_path' => '/service-images/akupuntur.jpg'
        ]);
    }
}
