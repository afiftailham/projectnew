<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use Spatie\Permission\Models\Role;
use Alert;

class SupplierController extends Controller
{
       public function index()
    {
        $supplier = \App\Models\Supplier::All();
        return view ('admin.supplier',['supplier'=>$supplier]);
        
    }
    public function create()
    {
        return view ('admin.supplier.input');
    }

    
    public function store(Request $request)
    {
        $tambah_supp=new \App\Models\Supplier;
        $tambah_supp->kd_supp = $request->addkdsupp;
        $tambah_supp->nm_supp = $request->addnmsupp;
        $tambah_supp->alamat = $request->addalamat;
        $tambah_supp->telepon = $request->addtel;
        $tambah_supp->timestamps = false;
        $tambah_supp->save();
        Alert::success('Pesan','Data berhasil disimpan');
        return redirect ('/supplier');
    }

    public function destroy ($kd_supp)
    {
        $supplier=\App\Models\Supplier::findorFail($kd_supp);
        $supplier ->delete();
        Alert::success('Pesan', 'Data berhasil dihapus');
        return redirect()->route('supplier.index');
    }
    
    public function edit ($kd_supp)
    {
        $supp_edit=\App\Models\Supplier::findorFail($kd_supp);
        return view ('admin.supplier.editSupplier', ['supplier'=> $supp_edit]);ph
    }
    public function update (Request $request, $kd_supp)
    {
        $supp= \App\Models\Supplier::findorFail($kd_supp);
        $supp ->kd_supp = $request -> get ('addkdsupp');
        $supp ->nm_supp = $request -> get ('addnmsupp');
        $supp ->alamat = $request -> get ('addalamat');
        $supp ->telepon = $request -> get ('addtel');
        $supp -> save();

        return redirect() ->route ('supplier.index', [$kd_supp]);

    }
}