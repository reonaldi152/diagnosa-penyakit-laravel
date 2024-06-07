<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'symptoms', 'diseases'];

    protected $casts = [
        'symptoms' => 'array',
        'diseases' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDiseaseDetailsAttribute()
    {
        return Disease::whereIn('id', $this->diseases)->get();
    }

    public function getSymptomDetailsAttribute()
    {
        return Symptom::whereIn('id', $this->symptoms)->get();
    }
}
