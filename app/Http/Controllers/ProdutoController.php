<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$produtos = Produto::all();
		return view('produtos.index', compact('produtos'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('produtos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([
			'nome' => 'required',
			'quantidade' => 'required|integer',
			'valor_unitario' => 'required|numeric',
		]);

		Produto::create($request->all());
		return redirect()->route('produtos.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Produto $produto)
	{
		return view('produtos.edit', compact('produto'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Produto $produto)
	{
		$request->validate([
			'nome' => 'required',
			'quantidade' => 'required|integer',
			'valor_unitario' => 'required|numeric',
		]);

		$produto->update($request->all());
		return redirect()->route('produtos.index');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Produto $produto)
	{
		$produto->delete();
		return redirect()->route('produtos.index');
	}
}
