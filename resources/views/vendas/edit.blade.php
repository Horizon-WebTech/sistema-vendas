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
			<option value="{{ $cliente->id }}" {{ $venda->cliente_id == $cliente->id ? 'selected' : '' }}>
				{{ $cliente->nome }}
			</option>
			@endforeach
		</select>
	</div>

	<div class="mb-3">
		<label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
		<select class="form-select" id="forma_pagamento" name="forma_pagamento" required>
			<option value="" disabled>Selecione uma forma de pagamento</option>
			<option value="dinheiro" {{ $venda->forma_pagamento == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
			<option value="cartao_credito" {{ $venda->forma_pagamento == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
			<option value="cartao_debito" {{ $venda->forma_pagamento == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
			<option value="transferencia" {{ $venda->forma_pagamento == 'transferencia' ? 'selected' : '' }}>Transferência</option>
			<option value="boleto" {{ $venda->forma_pagamento == 'boleto' ? 'selected' : '' }}>Boleto</option>
		</select>
	</div>

	<div class="mb-3">
		<label for="data_venda" class="form-label">Data da Venda</label>
		<input type="date" class="form-control" id="data_venda" name="data_venda" value="{{ $venda->data_venda->format('Y-m-d') }}" required>
	</div>

	<h3>Produtos da Venda</h3>
	<div id="produtos_venda">
		@foreach($produtosVenda as $index => $produto)
		<div class="mb-3">
			<label for="produto_id_{{ $index }}" class="form-label">Produto</label>
			<select class="form-control" id="produto_id_{{ $index }}" name="produtos[{{ $index }}][produto_id]" required>
				@foreach($produtos as $p)
				<option value="{{ $p->id }}" {{ $p->id == $produto->id ? 'selected' : '' }}>
					{{ $p->nome }} - R$ {{ number_format($p->valor_unitario, 2, ',', '.') }}
				</option>
				@endforeach
			</select>
			<label for="quantidade_{{ $index }}" class="form-label">Quantidade</label>
			<input type="number" class="form-control" id="quantidade_{{ $index }}" name="produtos[{{ $index }}][quantidade]" value="{{ $produto->pivot->quantidade }}" required>
		</div>
		@endforeach
	</div>

	<button type="submit" class="btn btn-primary">Salvar Venda</button>
	<a href="{{ route('vendas.index') }}" class="btn btn-secondary">Voltar</a>
</form>
@endsection