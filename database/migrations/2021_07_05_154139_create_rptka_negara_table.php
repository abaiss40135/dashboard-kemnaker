<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptkaNegaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rptka_negara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rptka_id');
            $table->foreign('rptka_id')
                ->references('id')
                ->on('data_rptka')
                ->onDelete('cascade');

            $table->string('id_negara',2)->nullable();
            $table->double('jumlah',11)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rptka_negara');
    }
}
