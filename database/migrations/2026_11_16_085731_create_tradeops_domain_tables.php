<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('recorded_on');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('recorded_on');
            $table->boolean('include_in_reports')->default(false);
            $table->boolean('show_in_profit_chart')->default(false);
            $table->boolean('is_sold')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('recorded_on');
            $table->boolean('include_in_reports')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image')->nullable();
            $table->text('video_url')->nullable();
            $table->string('speed')->nullable();
            $table->string('length')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('weight_info')->nullable();
            $table->date('recorded_on');
            $table->boolean('is_deleted')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->id();
            // 1 = income, 0 = expense (legacy)
            $table->unsignedTinyInteger('type');
            $table->text('note')->nullable();
            $table->foreignId('material_id')->nullable()->constrained('materials')->nullOnDelete();
            $table->text('description')->nullable();
            $table->integer('amount_try');
            $table->decimal('amount_usd', 15, 2)->default(0);
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->date('recorded_on');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->index(['recorded_on', 'id']);
            $table->index('is_deleted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_entries');
        Schema::dropIfExists('machines');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('companies');
    }
};
