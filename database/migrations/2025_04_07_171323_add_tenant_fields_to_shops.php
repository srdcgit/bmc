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
        Schema::table('shops', function (Blueprint $table) {
            $table->boolean('owner_type')->default(0)->nullabler()->after('owner_name');
            $table->string('tenant_name')->nullabler()->after('owner_name');
            $table->string('tenant_phone')->nullabler()->after('owner_name');
            $table->string('tenant_email')->nullabler()->after('owner_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('owner_type');
            $table->dropColumn('tenant_name');
            $table->dropColumn('tenant_phone');
            $table->dropColumn('tenant_email');
        });
    }
};
