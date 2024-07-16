<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPesan;
use App\Models\Pemesanan;
use Alert;

class DetailPesanController extends Controller
{
    public function simpan(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_pemesanan' => 'required|string|max:255',
            'total' => 'required|numeric',
            'supp' => 'required|string|max:255',
            'tgl' => 'required|date',
            'kd_brg' => 'required|array',
            'kd_brg.*' => 'required|string|max:255',
            'qty_pesan' => 'required|array',
            'qty_pesan.*' => 'required|integer',
            'sub_total' => 'required|array',
            'sub_total.*' => 'required|numeric',
        ]);

        // Simpan ke table pemesanan
        $tambah_pemesanan = new Pemesanan();
        $tambah_pemesanan->no_pemesanan = $request->no_pemesanan;
        $tambah_pemesanan->total = $request->total;
        $tambah_pemesanan->kd_supp = $request->supp;
        $tambah_pemesanan->tgl_pesan = $request->tgl;
        $tambah_pemesanan->save();

        // Simpan data ke tabel detail
        $kd_brg = $request->kd_brg;
        $qty = $request->qty_pesan;
        $sub_total = $request->sub_total;

        foreach ($kd_brg as $key => $no) {
            $input = [];
            $input['no_pemesanan'] = $request->no_pemesanan;
            $input['kd_brg'] = $kd_brg[$key];
            $input['qty_pesan'] = $qty[$key];
            $input['subtotal'] = $sub_total[$key];
            DetailPesan::insert($input);
        }

        Alert::success('Pesan', 'Data berhasil disimpan');
        return redirect('/transaksi');
    }
}
