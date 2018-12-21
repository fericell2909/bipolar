<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarginBottomColorAndFontsToBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('color', 8)->default('#000000')->after('relative_url');
            $table->string('font', 50)->default('SaharaBodoni')->after('relative_url');
            $table->decimal('padding_bottom_desktop', 7)->default(0)->after('relative_url');
            $table->decimal('padding_bottom_tablet', 7)->default(0)->after('relative_url');
            $table->decimal('padding_bottom_mobile', 7)->default(0)->after('relative_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['color', 'font', 'padding_bottom_desktop', 'padding_bottom_tablet', 'padding_bottom_mobile']);
        });
    }
}
