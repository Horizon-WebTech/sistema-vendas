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
		<div class="mb-3" id="produto_item_{{ $index }}">
			<label for="produto_id_{{ $index }}" class="form-label">Produto</label>
			<select class="form-control" id="produto_id_{{ $index }}" name="produtos[{{ $index }}][produto_id]" required onchange="updateValorUnitario('{{ $index }}')">
				@foreach($produtos as $p)
				<option value="{{ $p->id }}" data-valor="{{ $p->valor_unitario }}" {{ $p->id == $produto->id ? 'selected' : '' }}>
					{{ $p->nome }} - R$ {{ number_format($p->valor_unitario, 2, ',', '.') }}
				</option>
				@endforeach
			</select>

			<label for="quantidade_{{ $index }}" class="form-label">Quantidade</label>
			<input type="number" class="form-control" id="quantidade_{{ $index }}" name="produtos[{{ $index }}][quantidade]" value="{{ $produto->pivot->quantidade }}" required oninput="atualizarTotal()">

			<label for="valor_unitario_{{ $index }}" class="form-label">Valor Unitário</label>
			<input type="text" class="form-control" id="valor_unitario_{{ $index }}" name="produtos[{{ $index }}][valor_unitario]" value="{{ number_format($produto->pivot->valor_unitario, 2, ',', '.') }}" readonly>
		</div>
		@endforeach
	</div>

	<button type="button" class="btn btn-secondary mb-3" id="add-item">Adicionar Item</button>

	<div class="mb-3">
		<label for="parcelas" class="form-label">Número de Parcelas</label>
		<input type="number" class="form-control" id="parcelas" name="parcelas" value="{{ is_countable($venda->parcelas) ? count($venda->parcelas) : 1 }}" min="1" required oninput="gerarParcelas()">
	</div>

	<div id="parcelas_info">
		@if(is_array($venda->parcelas) || is_object($venda->parcelas))
		@foreach($venda->parcelas as $index => $parcela)
		<div class="mb-3">
			<label for="parcela_valor_{{ $index }}" class="form-label">Valor da Parcela {{ $index + 1 }}</label>
			<input type="number" class="form-control" id="parcela_valor_{{ $index }}" name="parcelas[{{ $index }}][valor]" value="{{ $parcela->valor }}" step="0.01" min="1" required oninput="reajustarParcelas('{{ $index }}', '{{ count($venda->parcelas) }}')">

			<label for="parcela_data_{{ $index }}" class="form-label">Data de Vencimento</label>
			<input type="date" class="form-control" id="parcela_data_{{ $index }}" name="parcelas[{{ $index }}][data_vencimento]" value="{{ $parcela->data_vencimento->format('Y-m-d') }}" required>
		</div>
		@endforeach
		@else
		<p>Nenhuma parcela encontrada.</p>
		@endif
	</div>

	<h3>Total da Venda: R$ <span id="total_venda">{{ number_format($venda->total, 2, ',', '.') }}</span></h3>

	<button type="submit" class="btn btn-primary">Salvar Venda</button>
	<a href="{{ route('vendas.index') }}" class="btn btn-secondary">Voltar</a>
</form>

<script>
	let itemCount = document.querySelectorAll('#produtos_venda .mb-3').length;
	let totalVenda = 0;

	function atualizarTotal() {
		totalVenda = 0;
		for (let i = 0; i < itemCount; i++) {
			const produtoId = document.querySelector(`#produto_id_${i}`);
			const quantidade = document.querySelector(`#quantidade_${i}`);
			const valorUnitario = document.querySelector(`#valor_unitario_${i}`);

			if (produtoId && quantidade && valorUnitario) {
				const valor = produtoId.options[produtoId.selectedIndex].getAttribute('data-valor');
				if (valor && quantidade.value) {
					const subtotal = parseFloat(valor) * parseInt(quantidade.value);
					totalVenda += subtotal;
					valorUnitario.value = parseFloat(valor).toFixed(2).replace('.', ',');
				}
			}
		}
		document.getElementById('total_venda').textContent = totalVenda.toFixed(2).replace('.', ',');
		gerarParcelas();
	}

	function gerarParcelas() {
		const numParcelas = parseInt(document.getElementById('parcelas').value);
		const parcelasContainer = document.getElementById('parcelas_info');
		parcelasContainer.innerHTML = '';

		if (numParcelas > 0) {
			const valorParcela = (totalVenda / numParcelas).toFixed(2);

			for (let i = 0; i < numParcelas; i++) {
				const dataAtual = new Date();
				dataAtual.setMonth(dataAtual.getMonth() + i);
				const dataVencimento = dataAtual.toISOString().split('T')[0];

				parcelasContainer.innerHTML += `
                    <div class="mb-3">
                        <label for="parcela_valor_${i}" class="form-label">Valor da Parcela ${i + 1}</label>
                        <input type="number" class="form-control" id="parcela_valor_${i}" name="parcelas[${i}][valor]" value="${valorParcela}" step="0.01" min="1" required oninput="reajustarParcelas(${i}, ${numParcelas})">
                        <label for="parcela_data_${i}" class="form-label">Data de Vencimento</label>
                        <input type="date" class="form-control" id="parcela_data_${i}" name="parcelas[${i}][data_vencimento]" value="${dataVencimento}" required>
                    </div>
                `;
			}
		}
	}

	function reajustarParcelas(parcelaIndex, numParcelas) {
		let totalParcelas = 0;

		for (let i = 0; i < numParcelas; i++) {
			const parcelaValor = parseFloat(document.getElementById(`parcela_valor_${i}`).value);
			totalParcelas += parcelaValor;
		}

		const diferenca = totalVenda - totalParcelas;

		for (let i = parcelaIndex + 1; i < numParcelas; i++) {
			const parcelaValorAtual = parseFloat(document.getElementById(`parcela_valor_${i}`).value);
			const novoValor = parcelaValorAtual + (diferenca / (numParcelas - parcelaIndex));
			document.getElementById(`parcela_valor_${i}`).value = novoValor.toFixed(2);
		}
	}

	function updateValorUnitario(itemIndex) {
		const produtoSelect = document.getElementById(`produto_id_${itemIndex}`);
		const valorUnitarioInput = document.getElementById(`valor_unitario_${itemIndex}`);
		const valor = produtoSelect.options[produtoSelect.selectedIndex].getAttribute('data-valor');
		if (valor) {
			valorUnitarioInput.value = parseFloat(valor).toFixed(2).replace('.', ',');
		}
		atualizarTotal();
	}

	document.addEventListener('DOMContentLoaded', function() {
		atualizarTotal();
		gerarParcelas();
	});

	document.getElementById('add-item').addEventListener('click', function() {
		const newIndex = itemCount++;
		const produtosContainer = document.getElementById('produtos_venda');
		const newItem = `
            <div class="mb-3" id="produto_item_${newIndex}">
                <label for="produto_id_${newIndex}" class="form-label">Produto</label>
                <select class="form-control" id="produto_id_${newIndex}" name="produtos[${newIndex}][produto_id]" required onchange="updateValorUnitario('${newIndex}')">
                    @foreach($produtos as $p)
                    <option value="{{ $p->id }}" data-valor="{{ $p->valor_unitario }}">
                        {{ $p->nome }} - R$ {{ number_format($p->valor_unitario, 2, ',', '.') }}
                    </option>
                    @endforeach
                </select>

                <label for="quantidade_${newIndex}" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade_${newIndex}" name="produtos[${newIndex}][quantidade]" value="1" required oninput="atualizarTotal()">

                <label for="valor_unitario_${newIndex}" class="form-label">Valor Unitário</label>
                <input type="text" class="form-control" id="valor_unitario_${newIndex}" name="produtos[${newIndex}][valor_unitario]" value="0,00" readonly>
            </div>
        `;
		produtosContainer.insertAdjacentHTML('beforeend', newItem);
		atualizarTotal();
	});
</script>

@endsection