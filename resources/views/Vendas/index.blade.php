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
	<h1>Vendas Realizadas</h1>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Cliente</th>
				<th>Forma de Pagamento</th>
				<th>Valor Total</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($vendas as $venda)
			<tr>
				<td>{{ $venda->cliente }}</td>
				<td>{{ $venda->forma_pagamento }}</td>
				<td>{{ $venda->valor_total }}</td>
				<td>
					<a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-info">Detalhes</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection