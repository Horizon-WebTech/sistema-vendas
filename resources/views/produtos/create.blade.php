@extends('layouts.layout')

@section('title', 'Novo Produto')

@section('content')
<h1>Novo Produto</h1>

<form action="{{ route('produtos.store') }}" method="POST">
	@csrf
	<div class="mb-3">
		<label for="nome" class="form-label">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" required>
	</div>
	<div class="mb-3">
		<label for="quantidade" class="form-label">Quantidade</label>
		<input type="number" class="form-control" id="quantidade" name="quantidade" required>
	</div>
	<div class="mb-3">
		<label for="valor_unitario" class="form-label">Valor Unitário</label>
		<input type="text" class="form-control" id="valor_unitario" name="valor_unitario" required>
	</div>
	<button type="submit" class="btn btn-primary">Salvar</button>
	<a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection