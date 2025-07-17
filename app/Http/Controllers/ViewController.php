<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallLog;
use App\Models\Queue;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    // Fungsi untuk Meneruskan Data ke Dashboard dari Semua Tabel pada Database
    public function dashboard()
    {
        // Untuk Menghitung Jumlah Antrian yang Aktif
        $waiting_queues = Queue::where('status', 'waiting')->count();
        // Untuk Menghitung Jumlah Staff yang Aktif
        $active_staff = Staff::where('is_active', 1)->count();
        // Untuk Mencari 3 Top Staff Berdasarkan banyak staff_id pada Tabel call_logs
        $top_staffs = CallLog::select('staff_id', DB::raw('count(*) as calls'))
            ->groupBy('staff_id')
            ->orderByDesc('calls')
            ->with('staff')
            ->take(3)
            ->get()
            ->map(fn($s) => [
                'name' => optional($s->staff)->name,
                'calls' => $s->calls
            ]);

        // Meneruskan Data $waiting_queues, $active_staff, dan $top_staffs ke Tampilan Dashboard
        return view('dashboard', [
            'waiting_queues' => $waiting_queues,
            'active_staff' => $active_staff,
            'top_staffs' => $top_staffs
        ]);
    }

    // Ini untuk Meneruskan Data Tabel Staff ke Tampilan Queue
    public function queue()
    {
        return view('queue', [
            'staffs' => Staff::all()
        ]);
    }

    public function client()
    {
        return view('client');
    }
}
