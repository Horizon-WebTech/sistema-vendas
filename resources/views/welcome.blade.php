@extends('layouts.app')

@section('content')

<div class="container mt-5">
	<h1 class="text-center">Bem-vindo ao Sistema de Vendas</h1>
	<p class="text-center">Escolha uma opção abaixo:</p>

	<div class="d-flex justify-content-center flex-column mt-4 gap-2 w-75 mx-auto">
		<a href="{{ route('vendas.create') }}" class="btn btn-primary mx-2">Cadastrar venda</a>
		<a href="{{ route('vendas.index') }}" class="btn btn-secondary mx-2">Visualizar vendas</a>
		<a href="{{ route('produtos.create') }}" class="btn btn-primary mx-2">Cadastrar produtos</a>
		<a href="{{ route('produtos.index') }}" class="btn btn-secondary mx-2">Visualizar produtos</a>
		<a href="{{ route('clientes.create') }}" class="btn btn-primary mx-2">Cadastrar clientes</a>
		<a href="{{ route('clientes.index') }}" class="btn btn-secondary mx-2">Visualizar clientes</a>

	</div>
</div>
@endsection