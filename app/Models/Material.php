<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $fillable = ['supplier_id', 'nama_material', 'jenis_logam','grade','spesifikasi_teknis','harga_per_kg'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
