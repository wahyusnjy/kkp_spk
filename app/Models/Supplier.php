<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = ['kode_supplier', 'nama_supplier', 'alamat','kontak','kategori_material','status'];

    public function assessmentScores()
    {
        return $this->hasMany(AssessmentScore::class, 'supplier_id');
    }
    
    /**
     * Relasi ke Topsis Results
     */
    public function topsisResults()
    {
        return $this->hasMany(Topsis_Result::class, 'supplier_id');
    }
    
    /**
     * Relasi ke Assessments melalui scores
     */
    public function assessments()
    {
        return $this->hasManyThrough(
            Assessment::class,
            AssessmentScore::class,
            'supplier_id', // Foreign key pada AssessmentScore
            'id', // Foreign key pada Assessment
            'id', // Local key pada Supplier
            'assessment_id' // Local key pada AssessmentScore
        )->distinct();
    }
}
