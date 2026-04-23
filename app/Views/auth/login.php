<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <main class="login-page">
        <section class="login-card" aria-labelledby="login-title">
            <div class="brand-area">
                <div class="brand-mark">JVC</div>
                <h1 id="login-title">JVC DEVWEB</h1>
                <p>Gestao simples para seu mercado</p>
            </div>

            <?php if ($error !== null): ?>
                <div class="alert alert-danger login-alert" role="alert">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form action="index.php?route=login" method="post" class="login-form">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?>" placeholder="Digite seu usuario" autocomplete="username" required>
                </div>

                <div class="mb-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" autocomplete="current-password" required>
                </div>

                <button type="submit" class="btn btn-login w-100">LOGIN</button>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>
