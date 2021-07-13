<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateApiSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('api_settings');
        Schema::create('api_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->String('api_url', 384)->unique();
            $table->integer('execute_duration_min');
            $table->timestamp('next_executed_at')->default(now());
            $table->longText('error_message')->nullable();
            $table->boolean('active');
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
        Schema::dropIfExists('api_settings');
    }
}
