<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Years of experience now lives only in profiles.years_experience,
     * so drop the duplicate entry from the stats list.
     */
    public function up(): void
    {
        DB::table('profiles')->whereNotNull('stats')->get(['id', 'stats'])->each(function ($profile) {
            $stats = json_decode($profile->stats, true) ?: [];

            $filtered = array_values(array_filter(
                $stats,
                fn (array $stat) => ! str_contains(strtolower($stat['label'] ?? ''), 'years of experience'),
            ));

            if (count($filtered) !== count($stats)) {
                DB::table('profiles')->where('id', $profile->id)->update(['stats' => json_encode($filtered)]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
