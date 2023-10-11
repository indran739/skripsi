<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_opd_fk');
            $table->unsignedBigInteger('id_category_fk');
            $table->unsignedBigInteger('id_user_fk');
            $table->string('judul')->nullable();
            $table->text('isi_laporan')->nullable();
            $table->string('lokasi_kejadian')->nullable();
            $table->date('tanggal_kejadian')->nullable();
            $table->text('tanggapan_admin')->nullable();
            $table->text('tanggapan_opd')->nullable();
            $table->string('validasi_laporan','5')->nullable();
            $table->string('disposisi_opd','5')->nullable();
            $table->string('lampiran')->nullable();
            $table->date('tanggal_tindak')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('first_image')->nullable();
            $table->string('sec_image')->nullable();
            $table->string('anonim')->nullable();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengaduans');
    }
};
