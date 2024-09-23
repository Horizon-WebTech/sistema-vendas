@extends('layouts.layout')

@section('title', 'Vendas')

@section('content')
<div class="d-flex justify-content-between align-items-center">
	<h1>Vendas</h1>
	<a href="{{ route('vendas.create') }}" class="btn btn-primary">Nova Venda</a>
</div>

<table class="table table-bordered mt-4">
	<thead>
		<tr>
			<th>ID</th>
			<th>Cliente</th>
			<th>Data</th>
			<th>Forma de Pagamento</th>
			<th>Total</th>
			<th>Parcelas</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($vendas as $venda)
		<tr>
			<td>{{ $venda->id }}</td>
			<td>{{ $venda->cliente->nome ?? 'N/A' }}</td>
			<td>{{ $venda->data_venda }}</td>
			<td>{{ $venda->forma_pagamento }}</td>
			<td>R$ {{ number_format($venda->total(), 2, ',', '.') }}</td>
			<td>{{ $venda->parcelas->count() }}</td>
			<td>
				<a href="{{ route('vendas.edit', $venda->id) }}" class="btn btn-warning btn-sm">Editar</a>
				<form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" style="display:inline-block;">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-danger btn-sm">Excluir</button>
				</form>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection