<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;

class VendaController extends Controller
{
	public function index()
	{
		$vendas = Venda::all();
		return view('vendas.index', compact('vendas'));
	}

	public function create()
	{
		$clientes = Cliente::all();
		$produtos = Produto::all();
		return view('vendas.create', compact('clientes', 'produtos'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'cliente_id' => 'nullable|exists:clientes_id',
			'forma_pagamento' => 'required|string',
			'data_venda' => 'required|date',
		]);

		$venda = Venda::create($request->all());

		//Logica

		return redirect()->route('vendas.index');
	}

	public function edit(Venda $venda)
	{
		$clientes = Cliente::all();
		$produtos = Produto::all();
		return view('vendas.edit', compact('venda', 'clientes', 'produtos'));
	}

	public function update(Request $request, Venda $venda)
	{
		$request->validate([
			'cliente_id' => 'nullable|exists:clientes_id',
			'forma_pagamento' => 'required|string',
			'data_venda' => 'required|date',
		]);

		$venda->update($request->all());
		return redirect()->route('vendas.index');
	}

	public function destroy(Venda $venda)
	{
		$venda->delete();
		return redirect()->route('vendas.index');
	}
}
