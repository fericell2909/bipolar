<?php

use Doctrine\DBAL\Types\Type;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class AddUuidToTypesSubtypesSizesAndColors extends Migration
{
    private function generateUUIDForTable(string $table)
    {
        Schema::table($table, function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        $records = DB::table($table)->get();

        foreach ($records as $record) {
            DB::table($table)
                ->where('id', $record->id)
                ->update(['uuid' => Str::uuid()]);
        }

        Schema::table($table, function (Blueprint $table) {
            $table->uuid('uuid')->index()->nullable(false)->change();
        });
    }

    private function removeUUIDForTable(string $table)
    {
        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

        $this->generateUUIDForTable('types');
        $this->generateUUIDForTable('subtypes');
        $this->generateUUIDForTable('sizes');
        $this->generateUUIDForTable('colors');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->removeUUIDForTable('types');
        $this->removeUUIDForTable('subtypes');
        $this->removeUUIDForTable('sizes');
        $this->removeUUIDForTable('colors');
    }
}
