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
                        'bulan' => $tanggal->format('F'),
                        'tahun' => $tanggal->year,
                        'kebun' => $kebun->nama_kebun,
                        'divisi' => $divisi->nama_divisi,
                        'akp_panen' => null,
                        'jumlah_tk_panen' => $jumlahTk,
                        'luas_panen_ha' => $luasPanen,
                        'jjg_panen_jjg' => $jjgPanen,
                        'jjg_kirim_jjg' => 0,
                        'ketrek' => null,
                        'total_jjg_kirim_jjg' => 0,
                        'tonase_panen_kg' => $timbangKebun,
                        'refraksi_kg' => $refraksiKg,
                        'refraksi_persen' => 0,
                        'restant_jjg' => 0,
                        'bjr_hari_ini' => 0,
                        'output_kg_hk' => 0,
                        'output_ha_hk' => 0,
                        'budget_harian' => $alokasiBudget,
                        'timbang_kebun_harian' => $timbangKebun,
                        'timbang_pks_harian' => $timbangPks,
                        'rotasi_panen' => 0,
                        'input_by' => 'Seeder',
                        'additional_data' => null,
                    ]);
                }
            }
        }
    }
}
