<?php

namespace App\Http\Controllers;

use App\Models\ItemVenda;
use Illuminate\Http\Request;

class ItemVendaController extends Controller
{
	public function store(Request $request)
	{
		$request->validate([
			'venda_id' => 'required|exists:vendas,id',
			'produto_id' => 'required|exists:produtos,id',
			'quantidade' => 'required|integer',
			'valor_unitario' => 'required|numeric',
		]);

		ItemVenda::create($request->all());
		return redirect()->back();
	}
}
