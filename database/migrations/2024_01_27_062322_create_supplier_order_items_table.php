<?php

use App\Models\Supply\SupplierOrder;
use App\Models\Supply\SupplierListing;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SupplierOrder::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SupplierListing::class)->nullable()->constrained()->cascadeOnDelete();
            $table->decimal('unit_weight', 7, 3)->nullable();
            $table->decimal('quantity', 7, 2);
            $table->decimal('unit_price', 7, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_order_items');
    }
};
