<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('email_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('old_email');
            $table->string('new_email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_changes');
    }
};
