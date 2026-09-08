<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('account_uuid')->nullable()->unique();
        });

        DB::table('users')
            ->whereNull('account_uuid')
            ->get(['id'])
            ->each(function (object $user): void {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['account_uuid' => (string) Str::uuid()]);
            });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['account_uuid']);
            $table->dropColumn('account_uuid');
        });
    }
};
