<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupplierController extends Controller
{
    /**
     * Display a listing of the suppliers.
     */
    public function index(): View
    {
        $suppliers = Supplier::orderBy('id', 'desc')->paginate(15);
        return view('pages.master.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create(): View
    {   
        $latestId = Supplier::max('id') ?? 0;
        $nextId = $latestId + 1;
        return view('pages.master.supplier.create', compact('nextId'));
    }

    /**
     * Store a newly created supplier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'kode_supplier' => 'required',
            'kategori_material' => 'required',
            'kontak' => 'required',
            'alamat' => 'required',
        ]);
        $supplier = Supplier::create([  
            'nama_supplier' => $request->nama_supplier,
            'kode_supplier' => $request->kode_supplier,
            'kategori_material' => $request->kategori_material,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit(int $id): View
    {
        $supplier = Supplier::findOrFail($id);
        return view('pages.master.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_supplier' => 'required',
            'kode_supplier' => 'required',
            'kategori_material' => 'required',
            'kontak' => 'required',
            'alamat' => 'required',
        ]);
        $supplier = Supplier::where('id',$id)->update([  
            'nama_supplier' => $request->nama_supplier,
            'kode_supplier' => $request->kode_supplier,
            'kategori_material' => $request->kategori_material,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
?>