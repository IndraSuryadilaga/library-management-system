<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Item;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('barcode')->unique();
            $table->enum('status', [
                Item::STATUS_AVAILABLE,
                Item::STATUS_LOANED,
                Item::STATUS_LOST,
                Item::STATUS_DAMAGED,
            ])->default(Item::STATUS_AVAILABLE);
            $table->foreignId('library_branch_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
