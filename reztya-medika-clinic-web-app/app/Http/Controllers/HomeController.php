<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function home() {
        $service = DB::table('services')->where('service_id', '=', 5)->first();
        $product = DB::table('products')->where('product_id', '=', 2)->first();
        $product1 = DB::table('products')->where('product_id', '=', 5)->first();
        $product2 = DB::table('products')->where('product_id', '=', 11)->first();
        $product3 = DB::table('products')->where('product_id', '=', 9)->first();

        /*
        $url = "https://www.nuskin.com/en_US/topnav-skin-and-beauty/popular.html";
        $html = file_get_contents($url);

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors(false);
        $path = new \DOMXPath($dom);
        $div = $path->query('//div[data-v-3480b6f6]');
        $div = $div->item(0);
        echo $dom->saveXML($div);
        */

        return view('home.home_page')
            ->with(compact('service'))
            ->with(compact('product'))
            ->with(compact('product1'))
            ->with(compact('product2'))
            ->with(compact('product3'));
    }

    public function aboutUs() {
        return view('home.about_us');
    }
}
