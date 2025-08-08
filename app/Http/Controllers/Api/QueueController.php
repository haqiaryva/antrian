<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Queue;
use App\Models\Staff;
use App\Services\QueueService;

class QueueController extends Controller
{
    protected $service;
    public function __construct(QueueService $Service)
    {
        $this->service = $Service;
    }

    // Untuk Menyimpan Antrian yang Diinput Klien
    public function store(Request $request)
    {
        // Karena sekarang hanya satu jenis antrian, kita tidak perlu validasi type
        $type = 'A'; // 'A' untuk antrian umum (general queue)
        
        // Untuk Ambil nomor terakhir dari antrian hari ini
        $lastQueue = Queue::where('type', $type)
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('queue_number', 'desc')
            ->first();

        // Untuk Menambah Number agar Menjadi A001, A002, A003, dst...
        $nextNumber = 1;

        if ($lastQueue) {
            $lastNumber = intval(substr($lastQueue->queue_number, 1));
            $nextNumber = $lastNumber + 1;
        }

        // Format Number Agar Memiliki 3 Digit
        $formattedNumber = $type . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Buat Antrian ke Tabel
        $queue = Queue::create([
            'queue_number' => $formattedNumber,
            'type' => $type,
            'status' => 'waiting',
        ]);

        // Output JSON
        return response()->json([
            'message' => 'Antrian berhasil dibuat',
            'data' => $queue
        ]);
    }

    // mengambil nomer antrian selanjutnya
    public function getNextQueue(Request $request)
    {
        $result = $this->service->getNextQueuePreview();

        return response()->json($result);
    }

    // Fungsi untuk Staff (Hanya yang Aktif) Mengambil Antrian
    public function requestQueue(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
        ]);

        $staff = Staff::find($request->staff_id);

        if (!$staff->is_active) {
            return response()->json([
                'message' => 'Staff tidak aktif'
            ], 403);
        }

        $result = $this->service->assignQueueToStaff($staff->id);

        return response()->json($result);
    }

    // Fungsi untuk Menyelesaikan Antrian (Hanya yang Aktif)
    public function finishQueue(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'queue_id' => 'required|exists:queues,id'
        ]);

        $staff = Staff::find($request->staff_id);

        if (!$staff->is_active) {
            return response()->json([
                'message' => 'Staff tidak aktif'
            ], 403);
        }

        $result = $this->service->finishQueue($staff->id, $request->queue_id);

        return response()->json($result);
    }
}