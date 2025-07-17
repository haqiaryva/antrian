<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Staff;
use App\Models\CallLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Fungsi untuk Meneruskan Rata-Rata ke Dashboard
    public function index()
    {
        // Mencari Rata-Rata Pengerjaan berdasarkan TIMESTAMPDIFF (Selisih Detik) pada called_at dan finished_at Menggunakan Second
        $staffTimes = CallLog::select('staff_id', DB::raw('AVG(TIMESTAMPDIFF(SECOND, called_at, finished_at)) as avg_seconds'))
            ->whereNotNull('called_at')
            ->whereNotNull('finished_at')
            ->groupBy('staff_id')
            ->with('staff:id,name') // Ini Menggunakan Relasi Antara Tabel call_logs dan staff, untuk Menampilkan nama
            ->get()
            ->map(function ($item) {
                $seconds = (int) $item->avg_seconds;
                $minutes = floor($seconds / 60);
                $remainingSeconds = $seconds % 60;

                // Output untuk ke Dashboard dengan Menggunakan Format %d m %d d
                return [
                    'name' => $item->staff->name ?? 'Tidak Diketahui',
                    'average_time' => sprintf('%d m %d d', $minutes, $remainingSeconds),
                ];
            });

        // Hanya Respon Menggunakan JSON
        return response()->json([
            'staff_times' => $staffTimes,
        ]);
    }
}