<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PekerjaanRequest;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Pekerjaan::query()
            ->with('karyawan')
            ->when($request->search, function ($query, $search) {
                $query->where('posisi', 'like', '%' . $search . '%')
                    ->orWhere('gaji', 'like', '%' . $search . '%')
                    ->orWhereHas('karyawan', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(10)
            ->withQueryString();
        $karyawan = Karyawan::query()->get();

        return Inertia::render('Pekerjaan/Index', [
            'pekerjaans' => $data,
            'search' => $request->search,
            'karyawans' => $karyawan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PekerjaanRequest $request)
    {
        try {
            $data = Pekerjaan::create([
                'karyawan_id' => $request->karyawan_id,
                'nama_pekerjaan' => $request->nama_pekerjaan,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
                'status_pekerjaan' => $request->status_pekerjaan,
            ]);

            if ($data->save()) {
                return redirect()->back()->with('success', 'Pekerjaan berhasil ditambahkan.');
            }
        } catch (\Exception $e) {
            Log::error('Error creating pekerjaan: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Pekerjaan gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PekerjaanRequest $request, string $id)
    {
        try {
            $data = Pekerjaan::findOrFail($id);
            if ($data) {
                $data->update([
                    'karyawan_id' => $request->karyawan_id,
                    'nama_pekerjaan' => $request->nama_pekerjaan,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
                    'status_pekerjaan' => $request->status_pekerjaan,
                ]);
            }

            return redirect()->back()->with('success', 'Pekerjaan berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error update pekerjaan: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Pekerjaan gagal diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Pekerjaan::findOrFail($id);
            if ($data) {
                $data->delete();
            }
            return redirect()->back()->with('success', 'Pekerjaan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error delete pekerjaan: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Pekerjaan gagal dihapus.');
        }
    }
}
