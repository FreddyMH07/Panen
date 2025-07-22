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
        // First add the new columns without constraints
        Schema::table('panen_harians', function (Blueprint $table) {
            $table->unsignedBigInteger('kebun_id')->nullable()->after('kebun');
            $table->unsignedBigInteger('divisi_id')->nullable()->after('divisi');
        });

        // Update the existing rows to set the foreign key values using SQLite syntax
        DB::statement('
            UPDATE panen_harians
            SET kebun_id = (
                SELECT id FROM kebuns
                WHERE nama_kebun = panen_harians.kebun
                LIMIT 1
            )
        ');

        DB::statement('
            UPDATE panen_harians
            SET divisi_id = (
                SELECT id FROM divisis
                WHERE nama_divisi = panen_harians.divisi
                LIMIT 1
            )
        ');

        // Add foreign key constraints after data is updated
        Schema::table('panen_harians', function (Blueprint $table) {
            $table->foreign('kebun_id')->references('id')->on('kebuns')->onDelete('cascade');
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('cascade');
            
            // Make the columns required now that data is migrated
            $table->unsignedBigInteger('kebun_id')->nullable(false)->change();
            $table->unsignedBigInteger('divisi_id')->nullable(false)->change();
        });
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
