<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
	use HasFactory;
	
	protected $fillable = ['nome', 'quantidade', 'valor_unitario'];

	public function itensVenda()
	{
		return $this->hasMany(ItemVenda::class);
	}
}
