<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\CallLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QueueService
{
    // Fungsi untuk staff mengambil antrian berikutnya
    public function assignQueueToStaff($staffId)
    {
        return DB::transaction(function () use ($staffId) {
            // Mengambil antrian waiting yang paling lama menunggu
            $queue = Queue::where('status', 'waiting')
                ->orderBy('created_at')
                ->first();

            // Jika tidak ada antrian waiting
            if (!$queue) {
                return ['message' => 'Tidak ada antrian yang tersedia'];
            }

            // Merubah status menjadi 'called'
            $queue->status = 'called';
            $queue->save();

            // Membuat log pemanggilan
            $log = CallLog::create([
                'queue_id' => $queue->id,
                'staff_id' => $staffId,
                'called_at' => now(),
            ]);

            return [
                'message' => 'Antrian berhasil dipanggil',
                'queue' => $queue,
                'log' => $log
            ];
        });
    }

    // Fungsi untuk mendapatkan preview antrian berikutnya
    public function getNextQueuePreview()
    {
        $queue = Queue::where('status', 'waiting')
            ->orderBy('created_at')
            ->first();

        if (!$queue) {
            return [
                'message' => 'Tidak ada antrian waiting',
                'queue_number' => null
            ];
        }

        return [
            'queue_number' => $queue->queue_number
        ];
    }

    // Fungsi untuk menyelesaikan antrian
    public function finishQueue($staffId, $queueId)
    {
        return DB::transaction(function () use ($staffId, $queueId) {
            $queue = Queue::findOrFail($queueId);
            $queue->status = 'done';
            $queue->save();

            $log = CallLog::where('queue_id', $queueId)
                ->where('staff_id', $staffId)
                ->latest()
                ->first();

            if ($log) {
                $log->finished_at = now();
                $log->save();
            }

            return [
                'message' => 'Antrian selesai',
                'queue' => $queue,
                'log' => $log
            ];
        });
    }
}