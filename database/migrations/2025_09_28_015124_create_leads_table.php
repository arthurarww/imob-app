<?php

use App\Enums\Lead\LeadProfileEnum;
use App\Enums\Lead\LeadStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('organization_id')->nullable()->constrained('organizations');
            $table->string('name');
            $table->enum('status', LeadStatusEnum::cases());
            $table->enum('profile', LeadProfileEnum::cases());
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('source')->nullable();
            $table->string('source_id')->nullable();
            $table->string('source_url')->nullable();
            $table->string('property_id')->nullable();
            $table->string('property_url')->nullable();
            $table->text('observation')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lead_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('organization_id')->nullable()->constrained('organizations');
            $table->foreignId('lead_id')->constrained('leads');
            $table->enum('status', LeadStatusEnum::cases());
            $table->text('observation')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
        Schema::dropIfExists('lead_histories');
    }
};
