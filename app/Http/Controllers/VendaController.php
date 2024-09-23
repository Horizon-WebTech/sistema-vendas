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
		$vendas = Venda::with(['cliente', 'parcelas'])->get();
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
			$venda->produtos()->attach($item['produto_id'], [
				'quantidade' => $item['quantidade'],
				'valor_unitario' => $valorUnitario
			]);
		}

		$numParcelas = (int) $request->parcelas;
		$valorTotal = (float) $venda->total;
		$valorParcela = $valorTotal / $numParcelas;
		$dataVencimento = now();

		for ($i = 0; $i < $numParcelas; $i++) {
			Parcela::create([
				'venda_id' => $venda->id,
				'valor' => $valorParcela,
				'valor_parcela' => $valorParcela,
				'data_vencimento' => $dataVencimento->copy()->addMonths($i),
			]);
		}

		return redirect()->route('vendas.index')->with('success', 'Venda registrada com sucesso!');
	}


	public function edit($id)
	{
		$venda = Venda::findOrFail($id);
		$produtosVenda = $venda->produtos;
		$clientes = Cliente::all();
		$produtos = Produto::all();

		$produtosVenda = $venda->produtos()->get();
		if ($produtosVenda->isEmpty()) {
			$produtosVenda = [];
		}

		$venda->data_venda = \Carbon\Carbon::parse($venda->data_venda);

		return view('vendas.edit', compact('venda', 'clientes', 'produtos', 'produtosVenda'));
	}

	public function update(Request $request, $id)
	{
		$venda = Venda::findOrFail($id);
		$venda->cliente_id = $request->cliente_id;
		$venda->forma_pagamento = $request->forma_pagamento;
		$venda->data_venda = $request->data_venda;
		$venda->save();
		// dd($venda->all());

		$venda->produtos()->detach();
		foreach ($request->produtos as $item) {
			$valorUnitario = str_replace(['R$', ' ', '.'], '', $item['valor_unitario']);
			$valorUnitario = str_replace(',', '.', $valorUnitario);

			$venda->produtos()->attach($item['produto_id'], ['quantidade' => $item['quantidade'], 'valor_unitario' => $valorUnitario]);
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
