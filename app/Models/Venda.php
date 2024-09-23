<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
	use HasFactory;

	protected $fillable = ['cliente_id', 'forma_pagamento', 'data_venda', 'total'];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function produtos()
	{
		return $this->belongsToMany(Produto::class)->withPivot('quantidade', 'valor_unitario');
	}

	public function parcelas()
	{
		return $this->hasMany(Parcela::class);
	}

	public function total()
	{
		$total = 0;
		foreach ($this->produtos as $produto) {
			$total += $produto->valor_unitario * $produto->pivot->quantidade;
		}
		return $total;
	}
}
