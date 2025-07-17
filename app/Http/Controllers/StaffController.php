<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // Fungsi untuk Mendapatkan Status Karyawan (Gunanya Untuk Sinkronisasi)
    public function status($id)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            return response()->json(['message' => 'Staff tidak ditemukan'], 404);
        }

        return response()->json([
            'is_active' => $staff->is_active
        ]);
    }

    // Fungsi untuk Merubah is_active pada Tabel staff ke Nilai 1 / True
    public function activate($id)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            return response()->json(['message' => 'Staff tidak ditemukan'], 404);
        }

        $staff->is_active = true;
        $staff->save();

        return response()->json([
            'message' => 'Staff berhasil diaktifkan',
            'staff' => $staff
        ]);
    }

    // Fungsi untuk Merubah is_active pada Tabel staff ke Nilai 0 / False
    public function deactivate($id)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            return response()->json(['message' => 'Staff tidak ditemukan'], 404);
        }

        $staff->is_active = false;
        $staff->save();

        return response()->json([
            'message' => 'Staff berhasil dinonaktifkan',
            'staff' => $staff
        ]);
    }
}