<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PanenHarian;
use App\Models\Kebun;
use App\Models\Divisi;
use Carbon\Carbon;

class PanenHarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kebuns = Kebun::with('divisis')->get();
        
        // Generate data untuk 30 hari terakhir
        for ($i = 29; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            
            foreach ($kebuns as $kebun) {
                foreach ($kebun->divisis as $divisi) {
                    // Skip beberapa hari secara random untuk variasi data
                    if (rand(1, 10) <= 2) continue;
                    
                    $luasPanen = rand(50, 200) / 10; // 5.0 - 20.0 Ha
                    $jjgPanen = rand(800, 2500);
                    $timbangKebun = $jjgPanen * (rand(180, 250) / 10); // 18-25 kg per JJG
                    $timbangPks = $timbangKebun * (rand(95, 105) / 100); // 95-105% dari timbang kebun
                    $jumlahTk = rand(15, 50);
                    $refraksiKg = $timbangKebun * (rand(1, 5) / 100); // 1-5% refraksi
                    $alokasiBudget = $timbangPks * (rand(80, 120) / 100); // Budget sekitar 80-120% dari produksi
                    
                    PanenHarian::create([
                        'tanggal_panen' => $tanggal,
                        'kebun_id' => $kebun->id,
                        'divisi_id' => $divisi->id,
                        'luas_panen' => $luasPanen,
                        'jjg_panen' => $jjgPanen,
                        'timbang_kebun' => $timbangKebun,
                        'timbang_pks' => $timbangPks,
                        'jumlah_tk' => $jumlahTk,
                        'refraksi_kg' => $refraksiKg,
                        'alokasi_budget' => $alokasiBudget,
                    ]);
                }
            }
        }
    }
}
