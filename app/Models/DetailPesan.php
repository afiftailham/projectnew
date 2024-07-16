<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesan extends Model
{
    protected $primaryKey = 'no_pemesanan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = "detail_pesan";
    protected $fillable=['no_pemesanan','kd_brg','qty_pesan','subtotal'];
}
