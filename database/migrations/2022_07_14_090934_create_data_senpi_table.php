<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSenpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    private $polices = [
        "polsuspas",
        "polhut_lhk",
        "polhut_perhutani",
        "polsus_cagar_budaya",
        "polsuska",
        "polsus_pwp3k",
        "polsus_karantina_ikan",
        "polsus_barantan",
        "polsus_satpol_pp",
        "polsus_dishubdar"
    ];

    private $attributes = [
        "genggam",
        "panjang",
        "jml"
    ];


    public function up()
    {
        Schema::create('data_senpi', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, "user_id");
            $table->string("polres");
            $table->string("polda");
            $table->string("kode_satuan");
            foreach($this->polices as $police)
            {
                foreach($this->attributes as $attribute)
                {
                    $table->integer($police . "_" . $attribute)->default(0);
                }
            }
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
        Schema::dropIfExists('data_senpi');
    }
}
