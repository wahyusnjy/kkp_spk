<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topsis_Result extends Model
{
    use HasFactory;

    protected $table = 'topsis_results';

    protected $fillable = [
        'assessment_id',
        'supplier_id',
        'preference_score',
        'rank'
    ];

    protected $casts = [
        'preference_score' => 'decimal:6'
    ];

    /**
     * Relasi ke Assessment
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    /**
     * Relasi ke Supplier
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Accessor untuk preference_score dalam persen
     */
    public function getNilaiPreferensiPersenAttribute(): string
    {
        return number_format($this->preference_score * 100, 2) . '%';
    }

    /**
     * Scope untuk rank terbaik
     */
    public function scopeTopRank($query, $limit = 1)
    {
        return $query->orderBy('rank')->limit($limit);
    }

    /**
     * Scope untuk assessment tertentu
     */
    public function scopeForAssessment($query, $assessmentId)
    {
        return $query->where('assessment_id', $assessmentId);
    }
}
