@extends('layouts.layout')

@section('title', 'Nova Venda')

@section('content')
<h1>Nova Venda</h1>

<form action="{{ route('vendas.store') }}" method="POST">
	@csrf
	<div class="mb-3">
		<label for="cliente_id" class="form-label">Cliente</label>
		<select class="form-control" id="cliente_id" name="cliente_id">
			<option value="">Selecione um cliente (opcional)</option>
			@foreach($clientes as $cliente)
			<option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
			@endforeach
		</select>
	</div>

	<div class="mb-3">
		<label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
		<input type="text" class="form-control" id="forma_pagamento" name="forma_pagamento" required>
	</div>

	<div class="mb-3">
		<label for="data_venda" class="form-label">Data da Venda</label>
		<input type="date" class="form-control" id="data_venda" name="data_venda" required>
	</div>

	<h3>Itens da Venda</h3>
	<div id="itens_venda">
		<div class="mb-3">
			<label for="produto_id_1" class="form-label">Produto</label>
			<select class="form-control" id="produto_id_1" name="produtos[1][produto_id]" required>
				@foreach($produtos as $produto)
				<option value="{{ $produto->id }}">{{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</option>
				@endforeach
			</select>
			<label for="quantidade_1" class="form-label">Quantidade</label>
			<input type="number" class="form-control" id="quantidade_1" name="produtos[1][quantidade]" required>
		</div>
	</div>

	<button type="button" class="btn btn-secondary mb-3" id="add-item">Adicionar Item</button>

	<h3>Parcelas</h3>
	<div class="mb-3">
		<label for="parcelas" class="form-label">Número de Parcelas</label>
		<input type="number" class="form-control" id="parcelas" name="parcelas" min="1" value="1">
	</div>

	<button type="submit" class="btn btn-primary">Salvar Venda</button>
	<a href="{{ route('vendas.index') }}" class="btn btn-secondary">Voltar</a>
</form>

<script>
	let itemCount = 1;
	document.getElementById('add-item').addEventListener('click', function() {
		itemCount++;
		const itemDiv = document.createElement('div');
		itemDiv.classList.add('mb-3');
		itemDiv.innerHTML = `
                <label for="produto_id_${itemCount}" class="form-label">Produto</label>
                <select class="form-control" id="produto_id_${itemCount}" name="produtos[${itemCount}][produto_id]" required>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</option>
                    @endforeach
                </select>
                <label for="quantidade_${itemCount}" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade_${itemCount}" name="produtos[${itemCount}][quantidade]" required>
            `;
		document.getElementById('itens_venda').appendChild(itemDiv);
	});
</script>
@endsection