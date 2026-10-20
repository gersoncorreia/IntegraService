<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('legal_name')->nullable()->after('company_city');
            $table->string('cnpj')->nullable()->after('legal_name');
            $table->longText('privacy_policy_text')->nullable()->after('footer_copyright');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'legal_name',
                'cnpj',
                'privacy_policy_text',
            ]);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }
};
