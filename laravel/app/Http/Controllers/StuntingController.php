<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StuntingController extends Controller
{

    public function welcome()
    {
        return view('welcome');
    }

    public function index()
    {
        return view('stunting-check');
    }

    public function check(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1|max:60',
            'jenis_kelamin' => 'required',
            'tinggi_badan' => 'required|numeric|min:30|max:150',
        ], [
            'nama.required' => 'Nama anak harus diisi',
            'umur.required' => 'Umur harus diisi',
            'umur.min' => 'Umur minimal 1 bulan',
            'umur.max' => 'Umur maksimal 60 bulan',
            'tinggi_badan.required' => 'Tinggi badan harus diisi',
        ]);

        // dd($request);

        // Kirim POST request ke ML Service
        $response = Http::post('http://127.0.0.1:8000/predict', [
            "umur_bulan" => $request->umur,
            "tinggi_badan_cm" => $request->tinggi_badan,
            "jenis_kelamin" => $request->jenis_kelamin,
        ]);

        // Ambil hasil dari response
        $result = $response->json();
        // dd($result);

        $user_id = Auth::id();

        $status = $result['prediction_label'];
        if ($status == 'severely stunted') {
            $status = 'sangat pendek (severely stunted)';
        } elseif ($status == 'stunted') {
            $status = 'pendek (stunted)';
        }

        // dd($status);

        // Simpan data ke database
        $child = Child::create([
            'user_id' => $user_id,
            'nama' => $request->nama,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin == 'laki-laki' ? 'L' : 'P',
            'tinggi_badan' => $request->tinggi_badan,
            'tanggal_ukur' => now(),
            'status' => $status
        ]);

        // Hitung status stunting
        $status = $child->status;

        $data = $request->all();
        $data['status'] = $status;
        $data['id'] = $child->id;

        return view('stunting-result', compact('data'));
    }
}
