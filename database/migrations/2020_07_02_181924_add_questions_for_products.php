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
        Schema::create('fits_widths', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->json('name');
        });

        if (Schema::hasTable('fits_widths')) {
            \DB::table('fits_widths')->insert(['name' => '{"es": "Angosto", "en": "Stretch"}', 'uuid' => Str::uuid()]);
            \DB::table('fits_widths')->insert(['name' => '{"es": "Semi angosto", "en": "Semi stretch"}', 'uuid' => Str::uuid()]);
            \DB::table('fits_widths')->insert(['name' => '{"es": "Estándar", "en": "Standard"}', 'uuid' => Str::uuid()]);
            \DB::table('fits_widths')->insert(['name' => '{"es": "Semi ancho", "en": "Semi wide"}', 'uuid' => Str::uuid()]);
            \DB::table('fits_widths')->insert(['name' => '{"es": "Ancho", "en": "Wide"}', 'uuid' => Str::uuid()]);
        }

        Schema::create('fits_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->json('name');
            $table->decimal('value', 2, 1);
        });

        if (Schema::hasTable('fits_sizes')) {
            \DB::table('fits_sizes')->insert(['name' => '{"es": "Escoge una talla menos", "en": "Choose one more less"}', 'uuid' => Str::uuid(), 'value' => -1]);
            \DB::table('fits_sizes')->insert(['name' => '{"es": "Escoge media talla menos", "en": "Choose half a size less"}', 'uuid' => Str::uuid(), 'value' => -0.5]);
            \DB::table('fits_sizes')->insert(['name' => '{"es": "Estándar", "en": "Standard"}', 'uuid' => Str::uuid(), 'value' => 0]);
            \DB::table('fits_sizes')->insert(['name' => '{"es": "Escoge media talla más", "en": "Choose half a size more"}', 'uuid' => Str::uuid(), 'value' => 0.5]);
            \DB::table('fits_sizes')->insert(['name' => '{"es": "Escoge una talla más", "en": "Choose one more size"}', 'uuid' => Str::uuid(), 'value' => 1]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('fit_width_id')->default(self::STANDARD_ID)->after('label_id');
            $table->unsignedInteger('fit_size_id')->default(self::STANDARD_ID)->after('label_id');
            $table->decimal('width_level_very_low', 3, 2)->default(0)->after('weight');
            $table->decimal('width_level_low', 3, 2)->default(0)->after('weight');
            $table->decimal('width_level_normal', 3, 2)->default(0)->after('weight');
            $table->decimal('width_level_high', 3, 2)->default(0)->after('weight');
            $table->decimal('width_level_very_high', 3, 2)->default(0)->after('weight');
            $table->decimal('instep_level_very_low', 3, 2)->default(0)->after('weight');
            $table->decimal('instep_level_low', 3, 2)->default(0)->after('weight');
            $table->decimal('instep_level_normal', 3, 2)->default(0)->after('weight');
            $table->decimal('instep_level_high', 3, 2)->default(0)->after('weight');
            $table->decimal('instep_level_very_high', 3, 2)->default(0)->after('weight');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('fit_width_id')->references('id')->on('fits_widths');
            $table->foreign('fit_size_id')->references('id')->on('fits_sizes');
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
            $table->dropForeign(['fit_width_id']);
            $table->dropForeign(['fit_size_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('fit_width_id');
            $table->dropColumn('fit_size_id');
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

        Schema::dropIfExists('fits_widths');
        Schema::dropIfExists('fits_sizes');
    }
}
