<?php

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
        Schema::create('vendas_produtos', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade');
            $table->foreignId('venda_id')->constrained('vendas')->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            $table->decimal('valor_produto', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendas_produtos', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
            $table->dropForeign(['venda_id']);
        });
        Schema::dropIfExists('vendas_produtos');
    }
};
