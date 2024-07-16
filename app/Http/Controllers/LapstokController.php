<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporanstok;
use PDF;
use DB;

class LapstokController extends Controller
{
    public function index()
    {
        $data = Laporanstok::All();
        return view('laporan.stok', ['data' => $data]);
    }

    public function show(Request $request)
    {
        $periode = $request->get('periode');
        
        if ($periode == 'All') {
            $bb = Laporanstok::all();
            $akun = \App\Models\Akun::all();
            $pdf = PDF::loadView('laporan.print', ['laporan' => $bb, 'akun' => $akun])->setPaper('A4', 'landscape');
            return $pdf->stream();
        } elseif ($periode == 'periode') {
            $tglawal = $request->get('tglawal');
            $tglakhir = $request->get('tglakhir');
            $akun = \App\Models\Akun::all();
            $bb = DB::table('barang')
                ->whereBetween('tgl_jurnal', [$tglawal, $tglakhir])
                ->orderBy('tgl_jurnal', 'ASC')
                ->get();
            $pdf = PDF::loadView('laporan.print', ['laporan' => $bb, 'akun' => $akun])->setPaper('A4', 'landscape');
            return $pdf->stream();

        

        }
    }
}
