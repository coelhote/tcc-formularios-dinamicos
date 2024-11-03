<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Minha Aplicação')</title>
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</head>

<body class="antialiased bg-light">
    <div id="loading" style="display: none;">
        <div class="spinner"></div>
    </div>

    <header class="bg-primary text-white">
        <nav class="navbar navbar-expand-lg navbar-light container">
            <a class="navbar-brand" href="{{ route('home') }}">Minha Aplicação</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Página Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="openPasswordModal('{{ route('questions.list') }}')">Listar Perguntas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="openPasswordModal('{{ route('forms.list') }}')">Listar Formulários</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Digite a Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="password" id="passwordInput" class="form-control" placeholder="Senha">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="submitPassword()">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <main class="container my-4">
        @yield('content')
    </main>

    <footer class="bg-light text-dark text-center py-3">
        <p>&copy; {{ date('Y') }} Minha Aplicação. Todos os direitos reservados.</p>
    </footer>
</body>

<script>
    let redirectUrl;

    function openPasswordModal(url) {
        redirectUrl = url;
        $('#passwordModal').modal('show');
    }

    function submitPassword() {
        const password = document.getElementById('passwordInput').value;

        if (password !== null) {
            $('#loading').show();

            const formData = new FormData();
            formData.append('permission', password);

            axios.post('/has-permission', formData)
                .then((response) => {
                    if (response.status === 200) {
                        window.location.href = redirectUrl;
                    }
                })
                .catch((error) => {
                    alert("Erro ao tentar autenticar.");
                })
                .finally(() => {
                    $('#loading').hide();
                    $('#passwordModal').modal('hide');
                    document.getElementById('passwordInput').value = '';
                });
        }
    }
</script>

</html>