<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'umur',
        'jenis_kelamin',
        'tinggi_badan',
        'tanggal_ukur',
        'status',
    ];

    protected $casts = [
        'tanggal_ukur' => 'date',
        'tinggi_badan' => 'decimal:2',
    ];

    // Accessor untuk status stunting
    public function getStatusStuntingAttribute()
    {
        return $this->calculateStuntingStatus();
    }

    public function calculateStuntingStatus()
    {
        // Standar WHO sederhana berdasarkan umur (dalam bulan)
        $standarTinggi = [
            0 => 49,   // newborn
            1 => 52,   // 1 month
            2 => 55,   // 2 months
            3 => 58,   // 3 months
            6 => 65,   // 6 months
            9 => 70,   // 9 months
            12 => 75,  // 12 months
            18 => 82,  // 18 months
            24 => 87,  // 24 months
            36 => 96,  // 36 months
            48 => 103, // 48 months
            60 => 110, // 60 months
        ];

        // Cari standar yang sesuai dengan umur
        $matchedAge = $this->findClosestAge($this->umur, array_keys($standarTinggi));
        $standarTinggiNormal = $standarTinggi[$matchedAge];

        // Jika tinggi badan < 90% dari standar normal = stunting
        // Jika tinggi badan < 85% dari standar normal = stunting berat
        $persentaseTinggi = ($this->tinggi_badan / $standarTinggiNormal) * 100;

        if ($persentaseTinggi < 85) {
            return 'Stunting Berat';
        } elseif ($persentaseTinggi < 90) {
            return 'Stunting';
        } else {
            return 'Normal';
        }
    }

    public function getColorStatusAttribute()
    {
        return match ($this->status_stunting) {
            'Normal' => 'success',
            'Stunting' => 'warning',
            'Stunting Berat' => 'danger',
            default => 'gray'
        };
    }

    private function findClosestAge($age, $availableAges)
    {
        $closest = null;
        foreach ($availableAges as $availableAge) {
            if ($closest === null || abs($age - $availableAge) < abs($age - $closest)) {
                $closest = $availableAge;
            }
        }
        return $closest;
    }

    // Scope untuk filtering
    public function scopeStuntingBerat($query)
    {
        return $query->get()->filter(function ($child) {
            return $child->status_stunting === 'Stunting Berat';
        });
    }

    public function scopeStunting($query)
    {
        return $query->get()->filter(function ($child) {
            return $child->status_stunting === 'Stunting';
        });
    }

    public function scopeNormal($query)
    {
        return $query->get()->filter(function ($child) {
            return $child->status_stunting === 'Normal';
        });
    }

    public function scopeFromPublic($query)
    {
        return $query->where('sumber', 'publik');
    }

    public function scopeFromAdmin($query)
    {
        return $query->where('sumber', 'admin');
    }
}
