<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DivisiRequest;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = Divisi::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_divisi', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Divisi/Index', [
            'divisis' => $data,
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
    public function store(DivisiRequest $request)
    {
        try {
            $data = Divisi::create([
                'nama_divisi' => $request->nama_divisi,
            ]);

            if ($data->save()) {
                return redirect()->back()->with('success', 'Divisi berhasil ditambahkan.');
            }
        } catch (\Exception $e) {
            Log::error('Error creating divisi: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Divisi gagal ditambahkan.');
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
    public function update(DivisiRequest $request, string $id)
    {
        try {
            $data = Divisi::findOrFail($id);
            if ($data){
                $data->update([
                    'nama_divisi' => $request->nama_divisi,
                ]);
            }

            if ($data->save()) {
                return redirect()->back()->with('success', 'Divisi berhasil diupdate.');
            }
        } catch (\Exception $e) {
            Log::error('Error update divisi: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Divisi gagal diupdate.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Divisi::findOrFail($id);
            if ($data){
                $data->delete();
            }
            return redirect()->back()->with('success', 'Divisi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error delete divisi: ' . $e->getMessage());
            return redirect()->back()->with('errors', 'Divisi gagal dihapus.');
        }
    }
}
