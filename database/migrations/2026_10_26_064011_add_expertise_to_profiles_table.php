<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->json('expertise')->nullable()->after('stats');
        });

        // Give the existing profile sensible defaults so the new section isn't empty.
        DB::table('profiles')->whereNull('expertise')->update([
            'expertise' => json_encode(self::defaults()),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('expertise');
        });
    }

    public static function defaults(): array
    {
        return [
            ['icon' => 'credit-card', 'title' => 'Payments & Billing', 'description' => 'Stripe and PayTabs integrations, idempotent webhooks, subscriptions, recurring invoicing and ETA e-invoicing.'],
            ['icon' => 'layers', 'title' => 'ERP Architecture', 'description' => 'Multi-tenant HR, payroll, finance and procurement modules with RBAC and reusable approval engines.'],
            ['icon' => 'gauge', 'title' => 'Performance at Scale', 'description' => 'Query optimization on MySQL, PostgreSQL and Neo4j (25M+ records), Redis caching and queue-driven workloads.'],
            ['icon' => 'shield-check', 'title' => 'Quality & Delivery', 'description' => 'Clean Architecture, SOLID, TDD with PHPUnit/Pest, code reviews and CI/CD on Azure Pipelines.'],
        ];
    }
};
