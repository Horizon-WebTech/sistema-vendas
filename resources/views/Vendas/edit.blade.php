@extends('layouts.layout')

@section('title', 'Editar Venda')

@section('content')
<h1>Editar Venda</h1>

<form action="{{ route('vendas.update', $venda->id) }}" method="POST">
	@csrf
	@method('PUT')
	<div class="mb-3">
		<label for="cliente_id" class="form-label">Cliente</label>
		<select class="form-control" id="cliente_id" name="cliente_id">
			<option value="">Selecione um cliente (opcional)</option>
			@foreach($clientes as $cliente)
			<option value="{{ $cliente->id }}" {{ $venda->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
			@endforeach
		</select>
	</div>

	<div class="mb-3">
		<label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
		<input type="text" class="form-control" id="forma_pagamento" name="forma_pagamento" value="{{ $venda->forma_pagamento }}" required>
	</div>

	<div class="mb-3">
		<label for="data_venda" class="form-label">Data da Venda</label>
		<input type="date" class="form-control" id="data_venda" name="data_venda" value="{{ $venda->data_venda }}" required>
	</div>

	<!-- Itens da Venda e Parcelas poderiam ser listados aqui também, com a possibilidade de edição -->

	<button type="submit" class="btn btn-primary">Atualizar Venda</button>
	<a href="{{ route('vendas.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection