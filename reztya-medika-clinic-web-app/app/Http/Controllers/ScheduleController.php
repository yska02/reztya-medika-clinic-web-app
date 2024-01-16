<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\OrderDetail;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\ScheduleWorkCommand;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('start_time', '>', Carbon::now())->paginate(10);
        return view('schedules.manage_schedules')->with('schedules', $schedules);
    }

    public function add()
    {
        return view('schedules.add_schedule');
    }

    public function store(Request $req)
    {
        $validated_data = $req->validate([
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time'
        ],[
            'start_time.required' => 'Waktu Mulai harus diisi',
            'end_time.required' => 'Waktu Berakhir harus diisi',
            'start_time.before' => 'Waktu Mulai harus mendahului Waktu Berakhir',
            'end_time.after' => 'Waktu Berakhir harus melewati  Waktu Mulai'
        ]);

        $validated_data['status'] = 'available';
        Schedule::create($validated_data);
        return redirect('/manage-schedules')->with('success','Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $schedule = Schedule::find($id);
        return view('schedules.edit_schedule')->with('schedule', $schedule);
    }

    public function update(Request $req, $id)
    {
        $validated_data = $req->validate([
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time'
        ],[
            'start_time.required' => 'Waktu Mulai harus diisi',
            'end_time.required' => 'Waktu Berakhir harus diisi',
            'start_time.before' => 'Waktu Mulai harus mendahului dari Waktu Berakhir',
            'end_time.after' => 'Waktu Berakhir harus melewati  Waktu Mulai'
        ]);
        $validated_data['status'] = 'available';
        Schedule::find($id)->update($validated_data);
        return redirect('/manage-schedules')->with('success','Jadwal berhasil diperbarui!');
    }

    public function delete($id)
    {
        $schedule = Schedule::find($id);
        $isExist = true;
        if($schedule){
            if(OrderDetail::where('schedule_id', $id)->count() == 0){
                $isExist = false;
            }
        }

        if(!$isExist){
            Cart::where('schedule_id', $id)->delete();
            Schedule::destroy($id);
        }else{
            return redirect('/manage-schedules')->with('error', 'Jadwal tidak dapat dihapus karena masih berada pada order yang aktif!');
        }
        return redirect('/manage-schedules')->with('success','Jadwal berhasil dihapus!');
    }
}
