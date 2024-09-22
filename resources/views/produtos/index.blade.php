@extends('layouts.layout')

@section('title', 'Produtos')

@section('content')
<div class="d-flex justify-content-between align-items-center">
	<h1>Produtos</h1>
	<a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo Produto</a>
</div>

<table class="table table-bordered mt-4">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>Quantidade</th>
			<th>Valor Unitário</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($produtos as $produto)
		<tr>
			<td>{{ $produto->id }}</td>
			<td>{{ $produto->nome }}</td>
			<td>{{ $produto->quantidade }}</td>
			<td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
			<td>
				<a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning btn-sm">Editar</a>
				<form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" style="display:inline-block;">
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