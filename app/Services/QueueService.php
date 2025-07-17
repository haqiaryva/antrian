<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\CallLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QueueService
{
    // Inisialisasi Properti untuk Banyak Objek Reservasi
    protected $reservationCount = 0;

    // Fungsi Untuk Membuat Algoritma Pemanggilan 2 Reservasi dan 1 Walk-in serta Menyimpannya ke Model CallLog (Tabel call_log) di Database
    public function assignQueueToStaff($staffId)
    {
        return DB::transaction(function () use ($staffId) {
            // Menghitung queue ID yang sudah berisi called_at berdasarkan jenis R dan W
            $calledToday = CallLog::whereDate('called_at', today())->get();
            $countR = $calledToday->where('queue.type', 'R')->count();
            $countW = $calledToday->where('queue.type', 'W')->count();

            // Algoritma Pemanggilan 2 Reservasi dan 1 Walk-in
            $type = ($countR < 2 * ($countW + 1)) ? 'R' : 'W';

            // Mengambil Queue dengan Status Waiting, Berdasarkan Output dari $type (Output Hasil Algoritma), Waktu Dibuatnya Data, dan yang Pertama
            $queue = Queue::where('status', 'waiting')
                ->where('type', $type)
                ->orderBy('created_at')
                ->first();

            // Logika Apakah dalam Tabel Queue Terdapat Tipe R dan W
            if (!$queue) {
                $type = $type === 'R' ? 'W' : 'R';
                $queue = Queue::where('status', 'waiting')
                    ->where('type', $type)
                    ->orderBy('created_at')
                    ->first();
            }

            // Jika Tidak Ada, Maka Tidak Akan Diproses
            if (!$queue) {
                return ['message' => 'Tidak ada antrian yang tersedia'];
            }

            // Merubah Status menjadi 'called' di Dalam Tabel
            $queue->status = 'called';
            $queue->save();

            // Membuat Baris Baru pada Tabel call_logs ke Kolom queue_id, staff_id, dan called_at
            $log = CallLog::create([
                'queue_id' => $queue->id,
                'staff_id' => $staffId,
                'called_at' => now(),
            ]);

            // Hanya Menampilkan Pesan ke JSON
            return [
                'message' => 'Antrian berhasil dipanggil',
                'queue' => $queue,
                'log' => $log
            ];
        });
    }

    // Hanya Fungsi untuk Mendapatkan Nomer Selanjutnya (Metode Sama Dengan assignQueueToStaff) Tapi Tidak Mengeksekusi Sesuatu
    public function getNextQueuePreview()
    {
        $calledToday = CallLog::with('queue')->whereDate('called_at', today())->get();

        $countR = $calledToday->where('queue.type', 'R')->count();
        $countW = $calledToday->where('queue.type', 'W')->count();

        $type = ($countR < 2 * ($countW + 1)) ? 'R' : 'W';

        $queue = Queue::where('status', 'waiting')
            ->where('type', $type)
            ->orderBy('created_at')
            ->first();

        if (!$queue) {
            $altType = $type === 'R' ? 'W' : 'R';

            $queue = Queue::where('status', 'waiting')
                ->where('type', $altType)
                ->orderBy('created_at')
                ->first();
        }

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

    // Fungsi untuk Update Baris pada Kolom finished_at untuk Antrian yang sudah Selesai, dan Merubah Status pada tabel Queue
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