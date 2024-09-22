<?php

namespace App\Http\Controllers;

use App\Models\ProdutoVenda;
use Illuminate\Http\Request;

class ProdutoVendaController extends Controller
{
	public function store(Request $request)
	{
		$request->validate([
			'venda_id' => 'required|exists:vendas,id',
			'produto_id' => 'required|exists:produtos,id',
			'quantidade' => 'required|integer',
			'valor_unitario' => 'required|numeric',
		]);

		ProdutoVenda::create($request->all());
		return redirect()->back();
	}
}
