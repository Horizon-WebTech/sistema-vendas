<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
	public function store(Request $request)
	{
		$request->validate([
			'parcelas' => 'required|array',
			'parcelas.*.venda_id' => 'required|exists:vendas,id',
			'parcelas.*.data_vencimento' => 'required|date',
			'parcelas.*.valor_parcela' => 'required|numeric',
		]);

		foreach ($request->parcelas as $parcela) {
			Parcela::create($parcela);
		}

		return redirect()->back()->with('success', 'Parcelas salvas com sucesso!');
	}
}
