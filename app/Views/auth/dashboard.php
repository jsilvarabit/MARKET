<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel | <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <main class="login-page">
        <section class="login-card text-center" aria-labelledby="dashboard-title">
            <div class="brand-area">
                <div class="brand-mark">JVC</div>
                <h1 id="dashboard-title">Bem-vindo!</h1>
                <p>Login realizado com sucesso.</p>
            </div>

            <div class="user-panel">
                <strong><?= htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8') ?></strong>
                <span><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <a href="index.php?route=logout" class="btn btn-login w-100 mt-4">SAIR</a>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
