<?php

use App\Enums\AdStatus;
use App\Enums\ModerationAdStatus;
use App\Enums\TypeCall;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Enum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->unsignedBigInteger('price')->default(0);
//            $table->string('brand');
//            $table->string('model');
            $table->integer('year');
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone');
            $table->enum('type_call', array_column(TypeCall::cases(), 'value'))
                ->default(TypeCall::CALL->value);

            $table->string('slug')->unique();

            $table->enum('status', array_column(AdStatus::cases(), 'value'))
                ->default(AdStatus::ACTIVE->value);

            $table->enum('moderation_status', array_column(ModerationAdStatus::cases(), 'value'))
                ->default(ModerationAdStatus::PENDING->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
