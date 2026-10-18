<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('footer_copyright');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->text('seo_keywords')->nullable()->after('seo_description');
            $table->string('og_image_path')->nullable()->default('/assets/images/og-banner.svg')->after('seo_keywords');
            $table->string('google_verification_code')->nullable()->after('og_image_path');
            $table->string('google_analytics_id')->nullable()->after('google_verification_code');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title',
                'seo_description',
                'seo_keywords',
                'og_image_path',
                'google_verification_code',
                'google_analytics_id',
            ]);
        });
    }
};
