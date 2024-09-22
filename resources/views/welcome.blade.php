@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<a class="navbar-brand" href="/">Sistema de Vendas</a>
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('vendas.create') }}">Cadastrar Venda</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('vendas.index') }}">Visualizar Vendas</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container mt-5">
	<h1 class="text-center">Bem-vindo ao Sistema de Vendas</h1>
	<p class="text-center">Clique no menu acima para navegar pelo sistema.</p>
</div>
@endsection