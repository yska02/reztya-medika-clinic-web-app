<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function filterCategory(Request $request) {
        $category_id = $request->category_id;
        $services = DB::table('services')
            ->where('category_id', '=', $category_id)
            ->paginate()
            ->appends(['category' => $category_id]);

        $schedules = DB::table('schedules')
            ->where('status','LIKE', 'available')
            ->where('start_time', '>', Carbon::now())->get();
        $noSchedule = false;

        if ($schedules->isEmpty()) {
            $noSchedule = true;
        }

        return view('services.view_services', [
            'services' => $services,
            'categories' => Category::all(),
            'noSchedule' => $noSchedule
        ]);
    }

    public function filterPriceHightoLow() {
        $services = DB::table('services')
            ->orderBy('price', 'desc')
            ->get();

        $schedules = DB::table('schedules')
            ->where('status','LIKE', 'available')
            ->where('start_time', '>', Carbon::now())->get();
        $noSchedule = false;

        if ($schedules->isEmpty()) {
            $noSchedule = true;
        }

        return view('services.view_services', [
            'services' => $services,
            'categories' => Category::all(),
            'noSchedule' => $noSchedule
        ]);
    }

    public function filterPriceLowtoHigh() {
        $services = DB::table('services')
            ->orderBy('price')
            ->get();

        $schedules = DB::table('schedules')
            ->where('status','LIKE', 'available')
            ->where('start_time', '>', Carbon::now())->get();
        $noSchedule = false;

        if ($schedules->isEmpty()) {
            $noSchedule = true;
        }

        return view('services.view_services', [
            'services' => $services,
            'categories' => Category::all(),
            'noSchedule' => $noSchedule
        ]);
    }

    public function filterZtoA() {
        $services = DB::table('services')
            ->orderBy('name', 'desc')
            ->get();

        $schedules = DB::table('schedules')
            ->where('status','LIKE', 'available')
            ->where('start_time', '>', Carbon::now())->get();
        $noSchedule = false;

        if ($schedules->isEmpty()) {
            $noSchedule = true;
        }

        return view('services.view_services', [
            'services' => $services,
            'categories' => Category::all(),
            'noSchedule' => $noSchedule
        ]);
    }

    public function filterAtoZ() {
        $services = DB::table('services')
            ->orderBy('name')
            ->get();

        $schedules = DB::table('schedules')
            ->where('status','LIKE', 'available')
            ->where('start_time', '>', Carbon::now())->get();
        $noSchedule = false;

        if ($schedules->isEmpty()) {
            $noSchedule = true;
        }

        return view('services.view_services', [
            'services' => $services,
            'categories' => Category::all(),
            'noSchedule' => $noSchedule
        ]);
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $services = DB::table('services')
            ->where('name', 'LIKE', "%$keyword%")
            ->paginate()
            ->appends(['keyword' => $keyword]);

        $schedules = DB::table('schedules')
            ->where('status','LIKE', 'available')
            ->where('start_time', '>', Carbon::now())->get();
        $noSchedule = false;

        if ($schedules->isEmpty()) {
            $noSchedule = true;
        }

        return view('services.view_services', [
            'services' => $services,
            'categories' => Category::all(),
            'noSchedule' => $noSchedule
        ]);
    }

    public function view() {
        $schedules = DB::table('schedules')
            ->where('status','LIKE', 'available')
            ->where('start_time', '>', Carbon::now())->get();
        $noSchedule = false;

        if ($schedules->isEmpty()) {
            $noSchedule = true;
        }

        return view('services.view_services', [
            'services' => Service::all(),
            'categories' => Category::all()
        ])->with(compact('noSchedule'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('services.manage_services', [
            'services' => Service::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.add_service', [
            'services' => Service::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'category_id' => 'required',
                'name' => 'required|unique:services|max:255',
                'description' => 'required',
                'duration' => 'required|numeric',
                'price' => 'required|numeric',
                'image_path' => 'required|image'
            ],
            [
                'category_id.required' => 'Kategori perawatan wajib diisi',
                'name.required' => 'Nama perawatan wajib diisi',
                'name.unique' => 'Nama perawatan tidak boleh sama dengan nama perawatan lainnya',
                'name.max' => 'Nama perawatan tidak boleh lebih dari 255 karakter',
                'description.required' => 'Deskripsi perawatan perawatan wajib diisi',
                'duration.required' => 'Durasi perawatan wajib diisi',
                'duration.numeric' => 'Durasi perawatan harus angka',
                'price.required' => 'Harga perawatan wajib diisi',
                'price.numeric' => 'Harga perawatan harus angka',
                'image_path.required' => 'Foto perawatan wajib diisi',
                'image_path.image' => 'Foto perawatan harus berbentuk jpeg, jpg, atau png'
            ]
        );

        if ($request->file('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('service-images');
        }

        Service::create($validatedData);

        return redirect('manage-services')->with('success', 'Perawatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
        $description = explode("\r\n", $service->description);

        return view('services.service_detail', [
            'service' => $service,
            'schedules' => Schedule::where('status', 'available')->where('start_time', '>', Carbon::now())->get(),
            'description' => $description
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);
        return view('services.edit_service', [
            'service' => $service,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'category_id' => 'required',
                'name' => 'required|max:255',
                'description' => 'required',
                'duration' => 'required|numeric',
                'price' => 'required|numeric'
            ],
            [
                'category_id.required' => 'Kategori perawatan wajib diisi',
                'name.required' => 'Nama perawatan wajib diisi',
                'name.max' => 'Nama perawatan tidak boleh lebih dari 255 karakter',
                'description.required' => 'Deskripsi perawatan perawatan wajib diisi',
                'duration.required' => 'Durasi perawatan wajib diisi',
                'duration.numeric' => 'Durasi perawatan harus angka',
                'price.required' => 'Harga perawatan wajib diisi',
                'price.numeric' => 'Harga perawatan harus angka'
            ]
        );

        if($request->image_path){
            $validatedData['image_path'] = $request->validate([
                'image_path' => 'required|image'
            ],[
                'image_path.required' => 'Foto produk wajib diisi',
                'image_path.image' => 'Foto produk harus berbentuk jpeg, jpg, atau png'
            ]);
        }
        if ($request->file('image_path')) {
            if ($request->old_image) {
                Storage::delete($request->old_image);
            }
            $validatedData['image_path'] = $request->file('image_path')->store('service-images');
        }
        Service::find($id)
            ->update($validatedData);

        return redirect('/manage-services')->with('success', 'Perawatan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        $isExist = true;
        if($service){
            if(OrderDetail::where('service_id', $id)->count() == 0){
                $isExist = false;
            }
        }

        if(!$isExist){
            if($service->image_path){
                Storage::delete($service->image_path);
            }
            Cart::where('service_id', $id)->delete();
            Service::destroy($id);
        }else{
            return redirect('/manage-services')->with('error', 'Perawatan tidak dapat dihapus karena masih berada pada order yang aktif!');
        }

        return redirect('/manage-services')->with('success', 'Perawatan berhasil dihapus!');
    }
}
