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
		<select class="form-select" id="forma_pagamento" name="forma_pagamento" required>
			<option value="" disabled selected>Selecione uma forma de pagamento</option>
			<option value="dinheiro">Dinheiro</option>
			<option value="cartao_credito">Cartão de Crédito</option>
			<option value="cartao_debito">Cartão de Débito</option>
			<option value="transferencia">Transferência</option>
			<option value="boleto">Boleto</option>
		</select>
	</div>

	<div class="mb-3">
		<label for="data_venda" class="form-label">Data da Venda</label>
		<input type="date" class="form-control" id="data_venda" name="data_venda" required>
	</div>

	<h3>Produtos da Venda</h3>
	<div id="produtos_venda">
		<div class="mb-3" id="produto_item_1">
			<label for="produto_id_1" class="form-label">Produto</label>
			<select class="form-control" id="produto_id_1" name="produtos[1][produto_id]" required onchange="updateValorUnitario(1)">
				<option value="" disabled selected>Selecione um produto</option>
				@foreach($produtos as $produto)
				<option value="{{ $produto->id }}" data-valor="{{ $produto->valor_unitario }}">{{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</option>
				@endforeach
			</select>
			<label for="quantidade_1" class="form-label">Quantidade</label>
			<input type="number" class="form-control" id="quantidade_1" name="produtos[1][quantidade]" value="1" min="1" required oninput="atualizarTotal()">
			<label for="valor_unitario_1" class="form-label">Valor Unitário</label>
			<input type="text" class="form-control" id="valor_unitario_1" name="produtos[1][valor_unitario]" readonly>
		</div>
	</div>

	<button type="button" class="btn btn-secondary mb-3" id="add-item">Adicionar Item</button>

	<h3>Parcelas</h3>
	<div class="mb-3">
		<label for="parcelas" class="form-label">Número de Parcelas</label>
		<input type="number" class="form-control" id="parcelas" name="parcelas" min="1" value="1" oninput="gerarParcelas()">
	</div>
	<div id="parcelas_info"></div>

	<h3>Total da Venda: R$ <span id="total_venda">0,00</span></h3>

	<button type="submit" class="btn btn-primary">Salvar Venda</button>
	<a href="{{ route('vendas.index') }}" class="btn btn-secondary">Voltar</a>
</form>

<script>
	let itemCount = 1;
	let totalVenda = 0;

	function atualizarTotal() {
		totalVenda = 0;

		for (let i = 1; i <= itemCount; i++) {
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
		gerarParcelas(); // Atualiza as parcelas com base no total
	}

	function gerarParcelas() {
		const numParcelas = parseInt(document.getElementById('parcelas').value);
		const parcelasContainer = document.getElementById('parcelas_info');
		parcelasContainer.innerHTML = '';

		if (numParcelas > 0) {
			const valorParcela = (totalVenda / numParcelas).toFixed(2);
			const hoje = new Date();

			for (let i = 1; i <= numParcelas; i++) {
				const dataVencimento = new Date(hoje.getFullYear(), hoje.getMonth() + i, hoje.getDate());

				parcelasContainer.innerHTML += `
                <div class="mb-3">
                    <label for="parcela_valor_${i}" class="form-label">Valor da Parcela ${i}</label>
                    <input type="number" class="form-control" id="parcela_valor_${i}" name="parcelas[${i}][valor]" value="${valorParcela}" min="0" step="0.01" oninput="reajustarParcelas(${i}, ${numParcelas})">
                    <label for="parcela_data_${i}" class="form-label">Data de Vencimento</label>
                    <input type="date" class="form-control" id="parcela_data_${i}" name="parcelas[${i}][data_vencimento]" value="${dataVencimento.toISOString().split('T')[0]}">
                </div>
            `;
			}
		}
	}


	function reajustarParcelas(parcelaIndex, numParcelas) {
		let totalParcelas = 0;

		for (let i = 1; i <= numParcelas; i++) {
			const parcelaValor = parseFloat(document.getElementById(`parcela_valor_${i}`).value);
			totalParcelas += parcelaValor;
		}

		const diferenca = totalVenda - totalParcelas;

		for (let i = parcelaIndex + 1; i <= numParcelas; i++) {
			const parcelaValorAtual = parseFloat(document.getElementById(`parcela_valor_${i}`).value); // Garantir que é float
			const novoValor = parcelaValorAtual + (diferenca / (numParcelas - parcelaIndex)); // Ajuste para distribuir a diferença
			document.getElementById(`parcela_valor_${i}`).value = novoValor.toFixed(2);
		}
	}

	document.getElementById('add-item').addEventListener('click', function() {
		itemCount++;
		const itemDiv = document.createElement('div');
		itemDiv.classList.add('mb-3');
		itemDiv.innerHTML = `
            <label for="produto_id_${itemCount}" class="form-label">Produto</label>
            <select class="form-control" id="produto_id_${itemCount}" name="produtos[${itemCount}][produto_id]" required onchange="atualizarTotal()">
                <option value="" disabled selected>Selecione um produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}" data-valor="{{ $produto->valor_unitario }}">{{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</option>
                @endforeach
            </select>
            <label for="quantidade_${itemCount}" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidade_${itemCount}" name="produtos[${itemCount}][quantidade]" value="1" min="1" required oninput="atualizarTotal()">
            <label for="valor_unitario_${itemCount}" class="form-label">Valor Unitário</label>
            <input type="text" class="form-control" id="valor_unitario_${itemCount}" name="produtos[${itemCount}][valor_unitario]" readonly>
        `;
		document.getElementById('produtos_venda').appendChild(itemDiv);
		atualizarTotal();
	});

	// Atualiza o valor unitário ao selecionar o produto
	function updateValorUnitario(itemIndex) {
		const produtoSelect = document.getElementById(`produto_id_${itemIndex}`);
		const valorUnitarioInput = document.getElementById(`valor_unitario_${itemIndex}`);
		const valor = produtoSelect.options[produtoSelect.selectedIndex].getAttribute('data-valor');
		if (valor) {
			valorUnitarioInput.value = parseFloat(valor).toFixed(2).replace('.', ',');
		}
		atualizarTotal(); // Atualiza o total sempre que o valor do produto é alterado
	}

	document.addEventListener('DOMContentLoaded', atualizarTotal);
</script>
@endsection