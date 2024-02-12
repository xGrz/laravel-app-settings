<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {


    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('groupName');
            $table->string('keyName');
            $table->string('key')->virtualAs("CONCAT(`groupName`, '.', `keyName`)")->unique();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            // $table->integer('type')->default(SettingValueType::Text);
            $table->timestamps();
        });

    }


    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
