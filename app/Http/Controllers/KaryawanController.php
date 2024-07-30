<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\KaryawanRequest;
use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Karyawan::query()
            ->with(['divisi'])
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_lahir', 'like', '%' . $search . '%')
                    ->orWhereHas('divisi', function ($query) use ($search) {
                        $query->where('nama_divisi', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(10)
            ->withQueryString();

        $divisi = Divisi::all();

        return Inertia::render('Karyawan/Index', [
            'karyawans' => $data,
            'divisi' => $divisi,
            'search' => $request->search
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
    public function store(KaryawanRequest $request)
    {
        try {
            if ($request->file('foto')) {
                $image = $request->file('foto');
                // Generate a unique name for the image using timestamp and random string
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                // Store the image in the public folder with the unique name
                $image->move('karyawan', $uniqueName);
            }
            $data = Karyawan::create([
                'divisi_id' => $request->divisi_id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'foto' => env('APP_URL') . '/karyawan/' . $uniqueName,
                'no_hp' => $request->no_hp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_masuk' => $request->tanggal_masuk,
                'status' => $request->status,
            ]);

            if ($data->save()) {
                return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
            }
        } catch (\Exception $e) {
            Log::error('Error creating karyawan: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Karyawan gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
    public function update(KaryawanRequest $request, string $id)
    {
        try {

            $data = Karyawan::findOrFail($id);
            if ($data) {

                if ($request->file('foto')) {
                    $image = $request->file('foto');
                    // Generate a unique name for the image using timestamp and random string
                    $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    // Store the image in the public folder with the unique name
                    $image->move('karyawan', $uniqueName);
                    $data->foto = env('APP_URL') . '/karyawan/' . $uniqueName;
                }
                $data->divisi_id = $request->divisi_id;
                $data->nama = $request->nama;
                $data->alamat = $request->alamat;
                $data->no_hp = $request->no_hp;
                $data->tanggal_lahir = $request->tanggal_lahir;
                $data->tanggal_masuk = $request->tanggal_masuk;
                $data->status = $request->status;
                $data->save();
            }

            return redirect()->back()->with('success', 'Karyawan berhasil diupdate.');

        } catch (\Exception $e) {
            Log::error('Error updating karyawan: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Karyawan gagal diupdate.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Karyawan::findOrFail($id);
            if ($data) {
                $filePath = public_path('karyawan/' . str_replace(env('APP_URL') . '/karyawan/', '', $data->foto));

                if (is_file($filePath)) {
                    unlink($filePath);
                }
                $data->delete();
            }
            return redirect()->back()->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting karyawan: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Karyawan gagal dihapus.');
        }
    }

    public function deleteImage($id)
    {
        $image = Karyawan::findOrFail($id);
        if ($image) {
            $filePath = public_path('karyawan/' . str_replace(env('APP_URL') . '/karyawan/', '', $image->foto));

            if (is_file($filePath)) {
                unlink($filePath);
            }

            $image->foto = '';
            $image->save();
            return redirect()->back()->with('success', 'Image deleted successfully');
        } else {
            return redirect()->back()->with('errors', 'Image not found');

        }
    }
}
