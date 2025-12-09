<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'tahun',
        'deskripsi',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    /**
     * Relasi ke Material
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    /**
     * Relasi ke Assessment Scores
     */
    public function scores(): HasMany
    {
        return $this->hasMany(AssessmentScore::class, 'assessment_id');
    }

    /**
     * Relasi ke Topsis Results
     */
    public function topsisResults(): HasMany
    {
        return $this->hasMany(Topsis_Result::class, 'assessment_id');
    }

    /**
     * Hitung total score
     */
    public function getTotalScoreAttribute(): float
    {
        return $this->scores()->sum('score');
    }

    /**
     * Hitung rata-rata score
     */
    public function getAverageScoreAttribute(): float
    {
        $count = $this->scores()->count();
        return $count > 0 ? $this->total_score / $count : 0;
    }

    /**
     * Hitung jumlah supplier unik
     */
    public function getSupplierCountAttribute(): int
    {
        return $this->scores()->distinct('supplier_id')->count('supplier_id');
    }

    /**
     * Cek status assessment
     */
    public function getStatusAttribute(): string
    {
        if ($this->topsisResults()->exists()) {
            return 'completed';
        } elseif ($this->scores()->exists()) {
            return 'scoring';
        } else {
            return 'draft';
        }
    }

    /**
     * Scope untuk ambil assessment yang sudah ada scores
     */
    public function scopeHasScores($query)
    {
        return $query->whereHas('scores');
    }

    /**
     * Scope untuk ambil assessment yang sudah diproses TOPSIS
     */
    public function scopeHasTopsisResults($query)
    {
        return $query->whereHas('topsisResults');
    }
}
