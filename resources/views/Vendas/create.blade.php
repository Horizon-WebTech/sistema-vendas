@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">Sistema de Vendas</a>
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('vendas.create') }}">Cadastrar Venda</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('vendas.index') }}">Visualizar Vendas</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container mt-5">
	<h1>Cadastrar Nova Venda</h1>
	<form method="POST" action="{{ route('vendas.store') }}">
		@csrf
		<div class="mb-3">
			<label class="form-label">Cliente</label>
			<input type="text" class="form-control" name="cliente" placeholder="Nome do cliente (opcional)">
		</div>
		<div class="mb-3">
			<label class="form-label">Forma de Pagamento</label>
			<input type="text" class="form-control" name="forma_pagamento" placeholder="Forma de pagamento">
		</div>
		<div class="mb-3">
			<label class="form-label">Valor Total</label>
			<input type="number" class="form-control" name="valor_total" step="0.01" placeholder="Valor total da venda">
		</div>
		<button type="submit" class="btn btn-primary">Cadastrar Venda</button>
	</form>
</div>
@endsection