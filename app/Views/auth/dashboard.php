<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel | <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout-base.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
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
                    <div class="collapse" id="produtosMenu">
                        <a class="page-nav-child active" href="index.php?route=dashboard">Acompanhar Estoque</a>
                        <a class="page-nav-child" href="index.php?route=cadastrarProduto">Cadastrar produto</a>
                    </div>
                </div>

                <div class="page-nav-group">
                    <button class="page-nav-parent" type="button" data-bs-toggle="collapse" data-bs-target="#usuariosMenu" aria-expanded="true" aria-controls="usuariosMenu">
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
                    <span class="page-eyebrow">Tela inicial</span>
                    <h1>Dashboard do mercado</h1>
                    <p>Acompanhe produtos que precisam de atencao no estoque.</p>
                </div>

                <div class="page-header-card">
                    <span>Estoque baixo</span>
                    <strong><?= count($lowStockProducts) ?></strong>
                    <small>produtos com menos de 20 unidades</small>
                </div>
            </header>

            <section class="page-content-card" aria-labelledby="low-stock-title">
                <div class="page-section-heading">
                    <div>
                        <h2 id="low-stock-title">Produtos com estoque baixo</h2>
                    </div>
                </div>

                <?php if (count($lowStockProducts) > 0): ?>
                    <div class="table-responsive">
                        <table class="table page-table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Preco</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lowStockProducts as $product): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars((string) $product['PDT_ID'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($product['PDT_DESCRICAO'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>R$ <?= number_format((float) $product['PDT_PRECO'], 2, ',', '.') ?></td>
                                        <td>
                                            <span class="quantity-pill"><?= htmlspecialchars((string) $product['PDT_QUANTIDADE'], ENT_QUOTES, 'UTF-8') ?></span>
                                        </td>
                                        <td><span class="status-badge">Repor estoque</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="page-empty-state">
                        <strong>Nenhum produto com estoque baixo.</strong>
                        <span>Todos os produtos estao com 20 unidades ou mais.</span>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
