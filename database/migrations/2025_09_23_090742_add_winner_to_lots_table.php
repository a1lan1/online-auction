<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->foreignId('winner_id')->after('auction_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('winning_bid_id')->after('winner_id')->nullable()->constrained('bids')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->dropForeign(['winner_id', 'winning_bid_id']);
            $table->dropColumn(['winner_id', 'winning_bid_id']);
        });
    }
};
