<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
	use HasFactory;

	protected $fillable = ['cliente_id', 'forma_pagamento', 'data_venda'];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function itensVenda()
	{
		return $this->hasMany(ItemVenda::class);
	}

	public function parcelas()
	{
		return $this->hasMany(Parcela::class);
	}
}
