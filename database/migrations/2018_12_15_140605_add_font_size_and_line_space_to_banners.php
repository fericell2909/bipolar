<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFontSizeAndLineSpaceToBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->decimal('letter_spacing_desktop', 7, 2)->default(1)->after('relative_url');
            $table->decimal('letter_spacing_tablet', 7, 2)->default(1)->after('relative_url');
            $table->decimal('letter_spacing_mobile', 7, 2)->default(1)->after('relative_url');
            $table->decimal('line_height_desktop', 7, 2)->default(171)->after('relative_url');
            $table->decimal('line_height_tablet', 7, 2)->default(90)->after('relative_url');
            $table->decimal('line_height_mobile', 7, 2)->default(56)->after('relative_url');
            $table->decimal('font_size_desktop', 7, 2)->default(120)->after('relative_url');
            $table->decimal('font_size_tablet', 7, 2)->default(60)->after('relative_url');
            $table->decimal('font_size_mobile', 7, 2)->default(40)->after('relative_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ((\DB::getDriverName() !== 'sqlite')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->dropColumn('letter_spacing_mobile');
                $table->dropColumn('letter_spacing_desktop');
                $table->dropColumn('letter_spacing_tablet');
                $table->dropColumn('line_height_mobile');
                $table->dropColumn('line_height_desktop');
                $table->dropColumn('line_height_tablet');
                $table->dropColumn('font_size_desktop');
                $table->dropColumn('font_size_mobile');
                $table->dropColumn('font_size_tablet');
            });
        }
    }
}
