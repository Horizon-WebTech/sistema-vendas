<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
	public function store(Request $request)
	{
		$request->validate([
			'venda_id' => 'required|exists:vendas,id',
			'data_vencimento' => 'required|date',
			'valor_parcela' => 'required|numeric',
		]);

		Parcela::create($request->all());
		return redirect()->back();
	}
}
