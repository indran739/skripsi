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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_opd_fk');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nik', 50)->unique();  
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('alamat');
            $table->string('tempat_lahir');  
            $table->string('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('no_hp');
            $table->string('pekerjaan');
            $table->string('gol_darah');
            $table->string('status_pernikahan'); 
            $table->string('jabatan'); 
            $table->string('verification');
            $table->string('foto_ktp');
            $table->string('foto_wajah');        
            $table->string('role');
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
        Schema::dropIfExists('users');
    }
};
