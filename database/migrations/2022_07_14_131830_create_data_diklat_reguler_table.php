<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDiklatRegulerTable extends Migration
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
        "sdh",
        "blm",
        "jml"
    ];


    public function up()
    {
        Schema::dropIfExists('data_diklat_reguler');
        Schema::create('data_diklat_reguler', function (Blueprint $table) {
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
        Schema::dropIfExists('data_diklat_reguler');
    }
}
