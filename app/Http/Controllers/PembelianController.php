<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\DetailPembelian;
use App\Models\Pembelian;
use App\Models\Pemesanan_tem;
use App\Models\Temp_pesan;
use App\Models\Jurnal;
use DB;
use Alert;
use PDF;


class PembelianController extends Controller
{
    public function index() 
    {
        // Mengambil semua data dari model Pemesanan
        $pesan = \App\Models\Pemesanan::all();
        
        // Perintah SQL untuk menghilangkan data pemesanan yang sudah dibeli
        $pesan = DB::select('SELECT * FROM pemesanan WHERE NOT EXISTS (SELECT * FROM pembelian WHERE pemesanan.no_pemesanan = pembelian.no_pemesanan)');
        
        // Mengembalikan view dengan data pemesanan
        return view('pembelian.pembelian', ['pemesanan' => $pesan]);

       
    }

    public function edit($id)
    {
        $temp_pesan = \App\Models\Temp_pesan::All();
        $AWAL = 'FKT';
        $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhir = \App\Models\Pembelian::max('no_beli');
        $no = 1;
        $format = sprintf("%03s", abs((int)$noUrutAkhir + 1)) . '/' . $AWAL . '/' . $bulanRomawi[date('n')] . '/' . date('Y');
        //No otomatis untuk jurnal
        $AWALJurnal = 'JRU';
        $bulanRomawij = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $noUrutAkhirj = \App\Models\Jurnal::max('no_jurnal');
        $noj = 1;
        $formatj = sprintf("%03s", abs((int)$noUrutAkhirj + 1)) . '/' . $AWALJurnal . '/' . $bulanRomawij[date('n')] . '/' . date('Y');
        $decrypted = Crypt::decryptString($id);
        $detail = DB::table('tampil_pemesanan')->where('no_pemesanan', $decrypted)->get();
        $pemesanan = DB::table('pemesanan')->where('no_pemesanan', $decrypted)->get();
        $akunkas = DB::table('setting')->where('nama_transaksi', 'Kas')->get();
        $akunpembelian = DB::table('setting')->where('nama_transaksi', 'Pembelian')->get();
        return view('pembelian.beli', ['detail' => $detail, 'format' => $format,
        'no_pesan' => $decrypted, 'pemesanan' => $pemesanan, 'formatj' => $formatj, 'kas' => $akunkas, 'pembelian' => $akunpembelian,'temp_pemesanan' => $temp_pesan]);
    }
    public function pdf($id)
    {
        $decrypted = Crypt::decryptString($id);
        $detail = DB::table('tampil_pemesanan')->where('no_pemesanan', $decrypted)->get();
        $supplier = DB::table('supplier')->get();
        $pemesanan = DB::table('pemesanan')->where('no_pemesanan', $decrypted)->get();
        $pdf = PDF::loadView('laporan.faktur', ['detail' => $detail, 'order' => $pemesanan, 'supp' => $supplier, 'noorder' => $decrypted]);
        return $pdf->stream();
    }

    public function simpan(Request $request)
    {
        if (Pembelian::where('no_pemesanan', $request->no_pesan)->exists()) {
        Alert::warning('Pesan ', 'Pembelian Telah dilakukan ');
        return redirect('pembelian');
        } else {
        //Simpan ke table pembelian
        $tambah_pembelian = new \App\Models\Pembelian;
        $tambah_pembelian->no_beli = $request->no_faktur;
        $tambah_pembelian->tgl_beli = $request->tgl;
        $tambah_pembelian->no_faktur = $request->no_faktur;
        $tambah_pembelian->total_beli = $request->total;
        $tambah_pembelian->no_pemesanan = $request->no_pemesanan;
        $tambah_pembelian->save();
        //SIMPAN DATA KE TABEL DETAIL PEMBELIAN
        $kdbrg = $request->kd_brg;
        $qtybeli = $request->qty_beli;
        $subbeli = $request->sub_beli;
        foreach ($kdbrg as $key => $no) {
        $input['no_beli'] = $request->no_faktur;
        $input['kd_brg'] = $kdbrg[$key];
        $input['qty_beli'] = $qtybeli[$key];
        $input['sub_beli'] = $subbeli[$key];
        DetailPembelian::insert($input);
        }
        //SIMPAN ke table jurnal bagian debet
        $tambah_jurnaldebet = new \App\Models\Jurnal;
        $tambah_jurnaldebet->no_jurnal = $request->no_jurnal;
        $tambah_jurnaldebet->keterangan = 'Pembelian Barang ';
        $tambah_jurnaldebet->tgl_jurnal = $request->tgl;
        $tambah_jurnaldebet->no_akun = $request->pembelian;
        $tambah_jurnaldebet->debet = $request->total;
        $tambah_jurnaldebet->kredit = '0';
        $tambah_jurnaldebet->save();
        //SIMPAN ke table jurnal bagian kredit
        $tambah_jurnalkredit = new \App\Models\Jurnal;
        $tambah_jurnalkredit->no_jurnal = $request->no_jurnal;
        $tambah_jurnalkredit->keterangan = 'Kas';
        $tambah_jurnalkredit->tgl_jurnal = $request->tgl;
        $tambah_jurnalkredit->no_akun = $request->akun;
        $tambah_jurnalkredit->debet = '0';
        $tambah_jurnalkredit->kredit = $request->total;
        $tambah_jurnalkredit->save();
        Alert::success('Pesan ', 'Data berhasil disimpan');
        return redirect('/pembelian');
        
}
}
}
