<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'additional_symptoms'];

    protected $casts = [
        'additional_symptoms' => 'array',
    ];

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class);
        // return $this->belongsToMany(Symptom::class, 'disease_symptom', 'disease_id', 'symptom_id');
    }
}
