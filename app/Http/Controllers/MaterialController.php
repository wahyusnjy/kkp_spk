<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $suppliers = Supplier::all();
        $materials = Material::with('supplier')->orderBy('id','desc')->paginate(10);
        return view('pages.master.material.index', compact('materials','suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $enum_list_jenis_logam = ['baja', 'aluminium', 'tembaga', 'kuningan', 'stainless_steel', 'besi', 'magnesium', 'titanium'];
        return view('pages.master.material.create', compact('suppliers','enum_list_jenis_logam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'nama_material' => 'required',
            'jenis_logam' => 'required',
            'grade' => 'required',
            'harga' => 'required|min:0'
        ]);
        
        $jenis_logam_type = ['baja', 'aluminium', 'tembaga', 'kuningan', 'stainless_steel', 'besi', 'magnesium', 'titanium'];

        if(!in_array($request->jenis_logam, $jenis_logam_type)){
            return redirect()->back()
            ->withInput()
            ->with('error', 'Jenis logam tidak valid');
        }

        Material::create([
            'supplier_id' => $request->supplier_id,
            'nama_material' => $request->nama_material,
            'jenis_logam' => $request->jenis_logam  ,
            'grade' => $request->grade,
            'spesifikasi_teknis' => $request->spesifikasi_teknis,
            'harga_per_kg' => $request->harga,
        ]);

        return redirect()->route('material.index')
            ->with('success', 'Material berhasil ditambahkan');
    }

    public function show(Material $material)
    {
        // return view('pages.master.material.show', compact('material'));
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $enum_list_jenis_logam = ['baja', 'aluminium', 'tembaga', 'kuningan', 'stainless_steel', 'besi', 'magnesium', 'titanium'];
        $suppliers = Supplier::all();
        return view('pages.master.material.edit', compact('material', 'suppliers','enum_list_jenis_logam'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required',
            'nama_material' => 'required',
            'jenis_logam' => 'required',
            'grade' => 'required',
            'harga' => 'required|min:0'
        ]);
        Material::find($id)->update([
            'supplier_id' => $request->supplier_id,
            'nama_material' => $request->nama_material,
            'jenis_logam' => $request->jenis_logam  ,
            'grade' => $request->grade,
            'spesifikasi_teknis' => $request->spesifikasi_teknis,
            'harga_per_kg' => $request->harga,
        ]);

        return redirect()->route('material.index')
            ->with('success', 'Material berhasil diupdate');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return redirect()->route('material.index')
            ->with('success', 'Material berhasil dihapus');
    }
}
