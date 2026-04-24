<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Produto | <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout-base.css">
    <link rel="stylesheet" href="assets/css/cadastrarProduto.css">
</head>
<body>
    <div class="page-shell">
        <aside class="page-sidebar">
            <div class="page-sidebar-brand">
                <div class="page-brand-mark">JVC</div>
                <div>
                    <strong>JVC DEVWEB</strong>
                    <span>Mercado</span>
                </div>
            </div>

            <nav class="page-sidebar-nav" aria-label="Menu principal">
                <div class="page-nav-group">
                    <button class="page-nav-parent" type="button" data-bs-toggle="collapse" data-bs-target="#produtosMenu" aria-expanded="true" aria-controls="produtosMenu">
                        Produtos
                    </button>
                    <div class="collapse show" id="produtosMenu">
                        <a class="page-nav-child" href="index.php?route=dashboard">Acompanhar Estoque</a>
                        <a class="page-nav-child active" href="index.php?route=cadastrarProduto">Cadastrar produto</a>
                    </div>
                </div>

                <div class="page-nav-group">
                    <button class="page-nav-parent" type="button" data-bs-toggle="collapse" data-bs-target="#usuariosMenu" aria-expanded="false" aria-controls="usuariosMenu">
                        Usuarios
                    </button>
                    <div class="collapse" id="usuariosMenu">
                        <a class="page-nav-child" href="index.php?route=gerenciarUsuarios">Gerenciar Usuarios</a>
                    </div>
                </div>
            </nav>

            <div class="page-sidebar-user">
                <span>Logado como</span>
                <strong><?= htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8') ?></strong>
                <a href="index.php?route=logout">Sair do sistema</a>
            </div>
        </aside>

        <main class="page-main">
            <header class="page-header">
                <div>
                    <span class="page-eyebrow">Produtos</span>
                    <h1>Cadastrar novo produto</h1>
                    <p>Inclua um item no estoque informando descricao, preco e quantidade.</p>
                </div>
            </header>

            <section class="page-content-card produto-form-card" aria-labelledby="produto-form-title">
                <div class="page-section-heading">
                    <div>
                        <h2 id="produto-form-title">Dados do produto</h2>
                    </div>
                </div>

                <?php if (!empty($produtoFlash)): ?>
                    <div class="alert alert-<?= htmlspecialchars($produtoFlash['type'], ENT_QUOTES, 'UTF-8') ?> produto-alert" role="alert">
                        <?= htmlspecialchars($produtoFlash['message'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?route=cadastrarProduto" method="post" class="produto-form">
                    <div class="mb-3">
                        <label for="descricaoProduto" class="form-label">Descricao do produto</label>
                        <input type="text" class="form-control" id="descricaoProduto" name="descricao" value="<?= htmlspecialchars($descricao, ENT_QUOTES, 'UTF-8') ?>" placeholder="Ex: Arroz Tipo 1 5kg" required>
                    </div>

                    <div class="produto-form-grid">
                        <div class="mb-3">
                            <label for="precoProduto" class="form-label">Preco</label>
                            <input type="number" class="form-control" id="precoProduto" name="preco" value="<?= htmlspecialchars($preco, ENT_QUOTES, 'UTF-8') ?>" min="0" step="0.01" placeholder="0,00" required>
                        </div>

                        <div class="mb-3">
                            <label for="quantidadeProduto" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" id="quantidadeProduto" name="quantidade" value="<?= htmlspecialchars($quantidade, ENT_QUOTES, 'UTF-8') ?>" min="0" step="1" placeholder="0" required>
                        </div>
                    </div>

                    <div class="produto-form-actions">
                        <a href="index.php?route=dashboard" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
