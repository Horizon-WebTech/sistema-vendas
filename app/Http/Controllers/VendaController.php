<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Parcela;
use Illuminate\Http\Request;

class VendaController extends Controller
{
	public function index()
	{
		$vendas = Venda::with('cliente', 'parcelas')->get();
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
			'cliente_id' => 'nullable|exists:clientes,id',
			'forma_pagamento' => 'required|string',
			'data_venda' => 'required|date',
			'produtos' => 'required|array',
			'produtos.*.produto_id' => 'required|exists:produtos,id',
			'produtos.*.quantidade' => 'required|integer|min:1',
			'parcelas' => 'required|array|min:1',
			'parcelas.*.valor' => 'required|numeric|min:0.01',
			'parcelas.*.data_vencimento' => 'required|date',
		]);

		$venda = new Venda();
		$venda->cliente_id = $request->cliente_id;
		$venda->forma_pagamento = $request->forma_pagamento;
		$venda->data_venda = $request->data_venda;

		$total = 0;
		foreach ($request->produtos as $item) {
			$produto = Produto::find($item['produto_id']);
			$valorUnitario = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $item['valor_unitario']);
			$valorUnitario = floatval($valorUnitario);
			$total += $valorUnitario * $item['quantidade'];
		}
		$venda->total = $total;
		$venda->save();

		foreach ($request->produtos as $item) {
			$valorUnitario = str_replace(['R$', ' ', '.', ','], ['', '', '', '.'], $item['valor_unitario']);
			$valorUnitario = floatval($valorUnitario);
			$venda->produtos()->attach($item['produto_id'], [
				'quantidade' => $item['quantidade'],
				'valor_unitario' => $valorUnitario
			]);
		}

		foreach ($request->parcelas as $parcela) {
			$venda->parcelas()->create([
				'valor_parcela' => $parcela['valor'],
				'data_vencimento' => $parcela['data_vencimento'],
			]);
		}

		return redirect()->route('vendas.index')->with('success', 'Venda registrada com sucesso!');
	}


	public function edit($id)
	{
		$venda = Venda::with('parcelas', 'produtos')->findOrFail($id);
		$clientes = Cliente::all();
		$produtos = Produto::all();
		$produtosVenda = $venda->produtos;

		$venda->data_venda = \Carbon\Carbon::parse($venda->data_venda);

		foreach ($venda->parcelas as $parcela) {
			$parcela->data_vencimento = \Carbon\Carbon::parse($parcela->data_vencimento);
		}

		return view('vendas.edit', compact('venda', 'clientes', 'produtos', 'produtosVenda'));
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'cliente_id' => 'nullable|exists:clientes,id',
			'forma_pagamento' => 'required|string',
			'data_venda' => 'required|date',
			'produtos' => 'required|array',
			'produtos.*.produto_id' => 'required|exists:produtos,id',
			'produtos.*.quantidade' => 'required|integer|min:1',
			'parcelas' => 'required|array|min:1',
			'parcelas.*.valor' => 'required|numeric|min:0.01',
			'parcelas.*.data_vencimento' => 'required|date',
		]);

		$venda = Venda::findOrFail($id);
		$venda->cliente_id = $request->cliente_id;
		$venda->forma_pagamento = $request->forma_pagamento;
		$venda->data_venda = $request->data_venda;
		$venda->save();

		$venda->produtos()->detach();
		foreach ($request->produtos as $item) {
			$valorUnitario = str_replace(['R$', ' ', '.'], '', $item['valor_unitario']);
			$valorUnitario = str_replace(',', '.', $valorUnitario);

			$venda->produtos()->attach($item['produto_id'], [
				'quantidade' => $item['quantidade'],
				'valor_unitario' => $valorUnitario
			]);
		}

		$venda->parcelas()->delete();
		foreach ($request->parcelas as $parcela) {
			$venda->parcelas()->create([
				'valor_parcela' => $parcela['valor'],
				'data_vencimento' => $parcela['data_vencimento'],
			]);
		}

		return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
	}

	public function destroy($id)
	{
		$venda = Venda::findOrFail($id);
		$venda->delete();

		return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso!');
	}
}
