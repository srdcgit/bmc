<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('payments', 'cam_charges')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('cam_charges')->default(0)->nullable()->after('amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('payments', 'cam_charges')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('cam_charges');
            });
        }
    }
};
