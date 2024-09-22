<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$clientes = Cliente::all();
		return view('clientes.index', compact('clientes'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('clientes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([
			'nome' => 'required',
			'cpf' => 'nullable|digits:11',
			'rg' => 'nullable|string|max:9',
		]);

		Cliente::create($request->all());
		return redirect()->route('clientes.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Cliente $cliente)
	{
		return view('clientes.edit', compact('cliente'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Cliente $cliente)
	{
		$request->validate([
			'nome' => 'required',
			'cpf' => 'nullable|digits:11',
			'rg' => 'nullable|string|max:9',
		]);

		$cliente->update($request->all());
		return redirect()->route('clientes.index');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Cliente $cliente)
	{
		$cliente->delete();
		return redirect()->route('clientes.index');
	}
}
