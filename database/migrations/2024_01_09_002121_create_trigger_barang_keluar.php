<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::unprepared("CREATE TRIGGER update_stok_barang_keluar AFTER INSERT ON barang_keluars
        FOR EACH ROW
        BEGIN
            UPDATE  barangs set stok  = stok - new.jumlah where id = new.barang_id;
        END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `update_stok_barang_keluar`');
    }
};
