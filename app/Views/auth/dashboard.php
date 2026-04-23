<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel | <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-mark">JVC</div>
                <div>
                    <strong>JVC DEVWEB</strong>
                    <span>Mercado</span>
                </div>
            </div>

            <nav class="sidebar-nav" aria-label="Menu principal">
                <div class="nav-group">
                    <button class="nav-parent" type="button" data-bs-toggle="collapse" data-bs-target="#produtosMenu" aria-expanded="true" aria-controls="produtosMenu">
                        Produtos
                    </button>
                    <div class="collapse show" id="produtosMenu">
                        <a class="nav-child active" href="index.php?route=dashboard">Acompanhar Estoque</a>
                    </div>
                </div>

                <div class="nav-group">
                    <button class="nav-parent" type="button" data-bs-toggle="collapse" data-bs-target="#usuariosMenu" aria-expanded="true" aria-controls="usuariosMenu">
                        Usuarios
                    </button>
                    <div class="collapse show" id="usuariosMenu">
                        <a class="nav-child" href="index.php?route=cadastrarUsuario">Cadastrar Usuario</a>
                        <a class="nav-child" href="index.php?route=gerenciarUsuarios">Listar Usuarios</a>
                    </div>
                </div>
            </nav>

            <div class="sidebar-user">
                <span>Logado como</span>
                <strong><?= htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8') ?></strong>
                <a href="index.php?route=logout">Sair do sistema</a>
            </div>
        </aside>

        <main class="dashboard-main">
            <header class="dashboard-header">
                <div>
                    <span class="eyebrow">Tela inicial</span>
                    <h1>Dashboard do mercado</h1>
                    <p>Acompanhe produtos que precisam de atenção no estoque.</p>
                </div>

                <div class="header-card">
                    <span>Estoque baixo</span>
                    <strong><?= count($lowStockProducts) ?></strong>
                    <small>produtos com menos de 20 unidades</small>
                </div>
            </header>

            <section class="content-card" aria-labelledby="low-stock-title">
                <div class="section-heading">
                    <div>
                        <h2 id="low-stock-title">Produtos com estoque baixo</h2>
                    </div>
                </div>

                <?php if (count($lowStockProducts) > 0): ?>
                    <div class="table-responsive">
                        <table class="table dashboard-table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Preço</th>
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
                    <div class="empty-state">
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
