<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAtAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggaran_proyek', function($table) {
            $table->string('ukuran')->after('id_proyek')->nullable();
            $table->string('jenis')->after('ukuran')->nullable();
            $table->integer('volume')->after('jenis')->nullable();
            $table->string('satuan')->after('volume')->nullable();
            $table->integer('hargasatuan')->after('satuan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
