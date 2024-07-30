<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jumlah total karyawan
        $totalKaryawan = Karyawan::count();

        // Jumlah karyawan berdasarkan status
        $karyawanAktif = Karyawan::where('status', 'Aktif')->count();
        $karyawanNonaktif = Karyawan::where('status', 'Tidak Aktif')->count();

        // Filter jumlah karyawan berdasarkan divisi
        $divisiId = $request->input('divisi_id');
        $karyawanByDivisi = Karyawan::when($divisiId, function($query, $divisiId) {
            return $query->where('divisi_id', $divisiId);
        })->count();

        // Mengambil semua divisi untuk filter
        $divisiList = Divisi::all();

        return Inertia::render('Dashboard', [
            'totalKaryawan' => $totalKaryawan,
            'karyawanAktif' => $karyawanAktif,
            'karyawanNonaktif' => $karyawanNonaktif,
            'karyawanByDivisi' => $karyawanByDivisi,
            'divisiList' => $divisiList
        ]);
    }

}
