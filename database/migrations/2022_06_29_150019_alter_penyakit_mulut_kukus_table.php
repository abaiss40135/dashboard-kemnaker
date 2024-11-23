<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private $tipe = [
        'sapi',
        'kerbau',
        'kambing',
        'domba',
        'babi'
    ];
    private $kategoriExisting = [
        'kandang', 'hewan', 'terinfeksi', 'vaksin'
    ];
    private $kategoriTambahan = [
        'mati',
        'potong',
        'sembuh',
    ];

    public function up()
    {
        Schema::table('penyakit_mulut_kukus', function (Blueprint $table) {
            $table->integer('kandang_sapi')->nullable(true)->change();
            $table->integer('kandang_kerbau')->nullable(true)->change();
            $table->integer('kandang_kambing')->nullable(true)->change();
            $table->integer('kandang_babi')->nullable(true)->change();
            $table->integer('hewan_sapi')->nullable(true)->change();
            $table->integer('hewan_kerbau')->nullable(true)->change();
            $table->integer('hewan_kambing')->nullable(true)->change();
            $table->integer('hewan_babi')->nullable(true)->change();
            $table->integer('terinfeksi_sapi')->nullable(true)->change();
            $table->integer('terinfeksi_kerbau')->nullable(true)->change();
            $table->integer('terinfeksi_kambing')->nullable(true)->change();
            $table->integer('terinfeksi_babi')->nullable(true)->change();
            $table->integer('vaksin_sapi')->nullable(true)->change();
            $table->integer('vaksin_kerbau')->nullable(true)->change();
            $table->integer('vaksin_kambing')->nullable(true)->change();
            $table->integer('vaksin_babi')->nullable(true)->change();

            /**
             * Kategori existing
             */
            foreach ($this->kategoriExisting as $existing){
                $table->integer($existing . '_domba')->nullable(true)->default(0);
            }

            /**
             * kategori tambahan
             */
            foreach ($this->kategoriTambahan as $cat) {
                foreach ($this->tipe as $hewan) {
                    $table->integer($cat . '_' . $hewan)->nullable(true)->default(0);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('penyakit_mulut_kukus', function (Blueprint $table) {
            $table->integer('kandang_sapi')->nullable(false)->change();
            $table->integer('kandang_kerbau')->nullable(false)->change();
            $table->integer('kandang_kambing')->nullable(false)->change();
            $table->integer('kandang_babi')->nullable(false)->change();
            $table->integer('hewan_sapi')->nullable(false)->change();
            $table->integer('hewan_kerbau')->nullable(false)->change();
            $table->integer('hewan_kambing')->nullable(false)->change();
            $table->integer('hewan_babi')->nullable(false)->change();
            $table->integer('terinfeksi_sapi')->nullable(false)->change();
            $table->integer('terinfeksi_kerbau')->nullable(false)->change();
            $table->integer('terinfeksi_kambing')->nullable(false)->change();
            $table->integer('terinfeksi_babi')->nullable(false)->change();
            $table->integer('vaksin_sapi')->nullable(false)->change();
            $table->integer('vaksin_kerbau')->nullable(false)->change();
            $table->integer('vaksin_kambing')->nullable(false)->change();
            $table->integer('vaksin_babi')->nullable(false)->change();

            /**
             * Kategori existing
             */
            foreach ($this->kategoriExisting as $existing){
                $table->dropColumn($existing . '_domba');
            }

            /**
             * kategori tambahan
             */
            foreach ($this->kategoriTambahan as $cat) {
                foreach ($this->tipe as $hewan) {
                    $table->dropColumn($cat . '_' . $hewan);
                }
            }
        });
    }
};
