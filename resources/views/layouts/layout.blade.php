<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title') - Sistema de Vendas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Sistema de Vendas</a>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('produtos.index') }}">Produtos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('vendas.index') }}">Vendas</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container mt-4">
		@yield('content')
	</div>

	<footer class="text-center mt-4">
		<p>&copy; {{ date('Y') }} - Sistema de Vendas</p>
	</footer>
</body>

</html>