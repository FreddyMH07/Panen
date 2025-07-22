<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('panen_harians', function (Blueprint $table) {
            // First add the new columns
            $table->foreignId('kebun_id')->nullable()->after('kebun');
            $table->foreignId('divisi_id')->nullable()->after('divisi');

            // Create foreign key constraints
            $table->foreign('kebun_id')->references('id')->on('kebuns')->onDelete('cascade');
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('cascade');

            // Update the existing rows to set the foreign key values
            DB::statement('
                UPDATE panen_harians ph
                INNER JOIN kebuns k ON k.nama_kebun = ph.kebun
                SET ph.kebun_id = k.id
            ');

            DB::statement('
                UPDATE panen_harians ph
                INNER JOIN divisis d ON d.nama_divisi = ph.divisi
                SET ph.divisi_id = d.id
            ');

            // Make the columns required after data migration
            $table->foreignId('kebun_id')->nullable(false)->change();
            $table->foreignId('divisi_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panen_harians', function (Blueprint $table) {
            $table->dropForeign(['kebun_id']);
            $table->dropForeign(['divisi_id']);
            $table->dropColumn(['kebun_id', 'divisi_id']);
        });
    }
};
