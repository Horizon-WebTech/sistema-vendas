@extends('layouts.layout')

@section('title', 'Editar Produto')

@section('content')
<h1>Editar Produto</h1>

<form action="{{ route('produtos.update', $produto->id) }}" method="POST">
	@csrf
	@method('PUT')

	<div class="mb-3">
		<label for="nome" class="form-label">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" value="{{ $produto->nome }}" required>
	</div>

	<div class="mb-3">
		<label for="quantidade" class="form-label">Quantidade</label>
		<input type="number" class="form-control" id="quantidade" name="quantidade" value="{{ $produto->quantidade }}" required>
	</div>

	<div class="mb-3">
		<label for="valor_unitario" class="form-label">Valor Unitário</label>
		<input type="text" class="form-control" id="valor_unitario" name="valor_unitario" value="{{ number_format($produto->valor_unitario, 2, ',', '.') }}" required>
	</div>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection