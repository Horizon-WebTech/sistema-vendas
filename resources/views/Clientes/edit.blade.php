@extends('layouts.layout')

@section('title', 'Editar Cliente')

@section('content')
<h1>Editar Cliente</h1>

<form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
	@csrf
	@method('PUT')
	<div class="mb-3">
		<label for="nome" class="form-label">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" value="{{ $cliente->nome }}" required>
	</div>
	<div class="mb-3">
		<label for="cpf" class="form-label">CPF</label>
		<input type="text" class="form-control" id="cpf" name="cpf" value="{{ $cliente->cpf }}">
	</div>
	<div class="mb-3">
		<label for="rg" class="form-label">RG</label>
		<input type="text" class="form-control" id="rg" name="rg" value="{{ $cliente->rg }}">
	</div>
	<button type="submit" class="btn btn-primary">Atualizar</button>
	<a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection