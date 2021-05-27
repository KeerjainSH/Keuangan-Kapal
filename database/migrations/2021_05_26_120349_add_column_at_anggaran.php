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
            $table->string('jenisAnggaran')->after('ukuran')->nullable();
            $table->float('volume', 8, 2)->after('jenisAnggaran')->nullable();
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
