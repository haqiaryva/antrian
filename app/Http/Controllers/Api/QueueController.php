<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Queue;
use App\Models\Staff;
use App\Services\QueueService;
use Illuminate\Support\Facades\Log;

class QueueController extends Controller
{
    protected $service;

    public function __construct(QueueService $service)
    {
        $this->service = $service;
    }

    /**
     * Membuat antrian baru (hanya tipe A)
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $type = 'A'; // Fixed type untuk general queue

            // Reset nomor setiap hari berdasarkan tanggal
            $today = now()->format('Y-m-d');

            // Ambil nomor antrian terakhir hari ini
            $lastQueue = Queue::where('type', $type)
                ->whereDate('created_at', $today)
                ->orderBy('queue_number', 'desc')
                ->first();

            // Generate nomor berikutnya (reset ke 1 jika hari baru)
            $nextNumber = $lastQueue ?
                intval(substr($lastQueue->queue_number, 1)) + 1 : 1;

            $formattedNumber = 'A' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Buat antrian baru
            $queue = Queue::create([
                'queue_number' => $formattedNumber,
                'type' => $type,
                'status' => 'waiting',
                'created_at' => now() // Pastikan menggunakan timestamp saat ini
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil dibuat',
                'data' => [
                    'queue_number' => $queue->queue_number,
                    'created_at' => $queue->created_at->format('Y-m-d H:i:s')
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat antrian', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat antrian'
            ], 500);
        }
    }

    /**
     * Mendapatkan antrian berikutnya
     */
    public function getNextQueue(Request $request)
    {
        try {
            $result = $this->service->getNextQueuePreview();
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Gagal mendapatkan antrian berikutnya', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan antrian berikutnya'
            ], 500);
        }
    }

    /**
     * Memanggil antrian untuk staff
     */
    public function requestQueue(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
        ]);

        try {
            $staff = Staff::findOrFail($request->staff_id);

            if (!$staff->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Staff tidak aktif'
                ], 403);
            }

            $result = $this->service->assignQueueToStaff($staff->id);
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Gagal memanggil antrian', [
                'staff_id' => $request->staff_id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memanggil antrian'
            ], 500);
        }
    }

    /**
     * Menyelesaikan antrian
     */
    public function finishQueue(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'queue_id' => 'required|exists:queues,id'
        ]);

        try {
            $staff = Staff::findOrFail($request->staff_id);

            if (!$staff->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Staff tidak aktif'
                ], 403);
            }

            $result = $this->service->finishQueue($staff->id, $request->queue_id);
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Gagal menyelesaikan antrian', [
                'queue_id' => $request->queue_id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyelesaikan antrian'
            ], 500);
        }
    }
}
