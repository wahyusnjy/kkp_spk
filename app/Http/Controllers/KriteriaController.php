<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriterias = Kriteria::paginate(10);
        return view('pages.master.kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('pages.master.kriteria.create');
    }

    public function store(Request $request)
    {
        echo('Test');
        $request->validate([
            'nama_kriteria' => 'required',
            'bobot' => 'required|numeric|min:0|max:5',
            'type' => 'required|in:benefit,cost'
        ]);

        try {
            Kriteria::create([
                'nama_kriteria' => $request->nama_kriteria,
                'bobot' => $request->bobot,
                'type' => $request->type,
                'keterangan' => $request->keterangan, 
            ]);

            return redirect()->route('kriteria.index')
                ->with('success', 'Kriteria berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan kriteria: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $criterion = Kriteria::findOrFail($id);
        return view('pages.master.kriteria.edit', compact('criterion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required',
            'bobot' => 'required|numeric|min:0|max:5', 
            'type' => 'required|in:benefit,cost'
        ]);

        try {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->update([
                'nama_kriteria' => $request->nama_kriteria,
                'bobot' => $request->bobot,
                'type' => $request->type,
                'keterangan' => $request->keterangan,
                'status' => $request->status ?? 'aktif'
            ]);

            return redirect()->route('kriteria.index')
                ->with('success', 'Kriteria berhasil diupdate!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate kriteria: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->delete();

            return redirect()->route('kriteria.index')
                ->with('success', 'Kriteria berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kriteria: ' . $e->getMessage());
        }
    }
}
