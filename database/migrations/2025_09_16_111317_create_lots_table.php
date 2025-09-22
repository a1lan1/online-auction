<?php

use App\Enums\LotStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('starting_price', 10, 2);
            $table->decimal('current_price', 10, 2)->default(0);
            $table->string('status')->default(LotStatus::PENDING->value);

            $table->foreignId('auction_id')->constrained()->onDelete('cascade');
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('winning_bid_id')->nullable()->constrained('bids')->nullOnDelete();

            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->timestamps();

            $table->index(['title', 'starts_at', 'ends_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
