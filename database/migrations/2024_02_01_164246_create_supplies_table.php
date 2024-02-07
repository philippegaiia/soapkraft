<?php

use App\Models\Supply\SupplierListing;
use Illuminate\Support\Facades\Schema;
use App\Models\Supply\SupplierOrderItem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(SupplierOrderItem::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SupplierListing::class)->constrained()->cascadeOnDelete();
            $table->string('order_ref')->nullable();
            $table->string('batch_number')->nullable();
            $table->decimal('initial_quantity', 10, 3)->nullable();
            $table->decimal('quantity_in', 7, 2)->nullable();
            $table->decimal('quantity_out', 7, 2)->nullable();
            $table->decimal('unit_price', 7, 2)->nullable();
            $table->date('expiration_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
