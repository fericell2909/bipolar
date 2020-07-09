<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class AddQuestionsForProducts extends Migration
{
    const STANDARD_ID = 3;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fits', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->json('name');
            $table->decimal('value', 2, 1);
        });

        if (Schema::hasTable('fits')) {
            \DB::table('fits')->insert(['name' => '{"es": "Angosto", "en": "Stretch"}', 'uuid' => Str::uuid(), 'value' => -1]);
            \DB::table('fits')->insert(['name' => '{"es": "Semi angosto", "en": "Semi stretch"}', 'uuid' => Str::uuid(), 'value' => -0.5]);
            \DB::table('fits')->insert(['name' => '{"es": "Estándar", "en": "Standard"}', 'uuid' => Str::uuid(), 'value' => 0]);
            \DB::table('fits')->insert(['name' => '{"es": "Semi ancho", "en": "Semi wide"}', 'uuid' => Str::uuid(), 'value' => 0.5]);
            \DB::table('fits')->insert(['name' => '{"es": "Ancho", "en": "Wide"}', 'uuid' => Str::uuid(), 'value' => 1]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('fit_id')->default(self::STANDARD_ID)->after('label_id');
            $table->decimal('width_level_very_low', 2, 1)->default(0)->after('weight');
            $table->decimal('width_level_low', 2, 1)->default(0)->after('weight');
            $table->decimal('width_level_normal', 2, 1)->default(0)->after('weight');
            $table->decimal('width_level_high', 2, 1)->default(0)->after('weight');
            $table->decimal('width_level_very_high', 2, 1)->default(0)->after('weight');
            $table->decimal('instep_level_very_low', 2, 1)->default(0)->after('weight');
            $table->decimal('instep_level_low', 2, 1)->default(0)->after('weight');
            $table->decimal('instep_level_normal', 2, 1)->default(0)->after('weight');
            $table->decimal('instep_level_high', 2, 1)->default(0)->after('weight');
            $table->decimal('instep_level_very_high', 2, 1)->default(0)->after('weight');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('fit_id')->references('id')->on('fits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['fit_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('fit_id');
            $table->dropColumn('width_level_very_low');
            $table->dropColumn('width_level_low');
            $table->dropColumn('width_level_normal');
            $table->dropColumn('width_level_high');
            $table->dropColumn('width_level_very_high');
            $table->dropColumn('instep_level_very_low');
            $table->dropColumn('instep_level_low');
            $table->dropColumn('instep_level_normal');
            $table->dropColumn('instep_level_high');
            $table->dropColumn('instep_level_very_high');
        });

        Schema::dropIfExists('fits');
    }
}
