<?php

namespace Database\Seeders;

use App\Models\Child;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChildSeeder extends Seeder
{
    public function run(): void
    {
        $children = [
            [
                'nama' => 'Ahmad',
                'umur' => 24,
                'jenis_kelamin' => 'L',
                'berat_badan' => 12.5,
                'tinggi_badan' => 85.5,
                'lingkar_lengan' => 14.5,
                'tanggal_ukur' => now(),
                'catatan' => 'Data contoh - Normal',
                'sumber' => 'admin',
            ],
            [
                'nama' => 'Siti',
                'umur' => 36,
                'jenis_kelamin' => 'P',
                'berat_badan' => 14.2,
                'tinggi_badan' => 89.0,
                'lingkar_lengan' => 15.0,
                'tanggal_ukur' => now()->subDays(10),
                'catatan' => 'Data contoh - Stunting',
                'sumber' => 'admin',
            ],
            [
                'nama' => 'Budi',
                'umur' => 18,
                'jenis_kelamin' => 'L',
                'berat_badan' => 9.8,
                'tinggi_badan' => 75.0,
                'lingkar_lengan' => 12.5,
                'tanggal_ukur' => now()->subDays(5),
                'catatan' => 'Data contoh - Stunting Berat',
                'sumber' => 'publik',
            ],
            [
                'nama' => 'Dewi',
                'umur' => 48,
                'jenis_kelamin' => 'P',
                'berat_badan' => 16.5,
                'tinggi_badan' => 98.0,
                'lingkar_lengan' => 16.0,
                'tanggal_ukur' => now()->subDays(15),
                'catatan' => 'Data contoh - Normal',
                'sumber' => 'publik',
            ],
        ];

        foreach ($children as $child) {
            Child::create($child);
        }
    }
}