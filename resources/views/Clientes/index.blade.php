@extends('layouts.layout')

@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center">
	<h1>Clientes</h1>
	<a href="{{ route('clientes.create') }}" class="btn btn-primary"> Novo Cliente</a>
</div>

<table class="table table-bordered mt-4">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>CPF</th>
			<th>RG</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($clientes as $cliente)
		<tr>
			<td>{{ $cliente->id }}</td>
			<td>{{ $cliente->nome }}</td>
			<td>{{ $cliente->cpf }}</td>
			<td>{{ $cliente->rg }}</td>
			<td>
				<a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
				<form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline-block;">
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