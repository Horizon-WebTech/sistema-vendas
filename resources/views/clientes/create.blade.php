@extends('layouts.layout')

@section('title', 'Novo Cliente')

@section('content')
<h1>Novo Cliente</h1>

<form action="{{ route('clientes.store') }}" method="POST">
	@csrf
	<div class="mb-3">
		<label for="nome" class="form-label">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" required>
	</div>
	<div class="mb-3">
		<label for="cpf" class="form-label">CPF</label>
		<input type="text" class="form-control" id="cpf" name="cpf">
	</div>
	<div class="mb-3">
		<label for="rg" class="form-label">RG</label>
		<input type="text" class="form-control" id="rg" name="rg">
	</div>
	<button type="submit" class="btn btn-primary">Salvar</button>
	<a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection