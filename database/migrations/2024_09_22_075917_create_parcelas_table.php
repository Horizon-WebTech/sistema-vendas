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
		Schema::create('parcelas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('venda_id')->constrained('vendas')->onDelete('cascade');
			$table->decimal('valor_parcela', 10, 2);
			$table->date('data_vencimento');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('parcelas');
	}
};
