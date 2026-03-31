<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Appointment;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('customer')->latest()->get();
        return view('booking.index', compact('appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        // ❌ không cho đặt quá khứ
        $datetime = Carbon::parse($request->date . ' ' . $request->time);

        if ($datetime < now()) {
            return back()->with('error', 'Không được đặt lịch quá khứ');
        }

        // ❌ kiểm tra trùng giờ
        $exists = Appointment::where('date', $request->date)
            ->where('time', $request->time)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Khung giờ đã được đặt');
        }

        // 🔥 tạo khách (nếu chưa có)
        $customer = Customer::firstOrCreate([
            'name' => $request->name
        ]);

        // 🔥 tạo lịch
        Appointment::create([
            'customer_id' => $customer->id,
            'date' => $request->date,
            'time' => $request->time
        ]);

        return back()->with('success', 'Đặt lịch thành công');
    }

    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return back()->with('success', 'Đã hủy lịch');
    }
}