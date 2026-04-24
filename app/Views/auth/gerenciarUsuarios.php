<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel | <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout-base.css">
    <link rel="stylesheet" href="assets/css/gerenciarUsuarios.css">
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
                        <a class="page-nav-child" href="index.php?route=dashboard">Acompanhar Estoque</a>
                        <a class="page-nav-child" href="index.php?route=cadastrarProduto">Cadastrar produto</a>
                    </div>
                </div>

                <div class="page-nav-group">
                    <button class="page-nav-parent" type="button" data-bs-toggle="collapse" data-bs-target="#usuariosMenu" aria-expanded="true" aria-controls="usuariosMenu">
                        Usuarios
                    </button>
                    <div class="collapse" id="usuariosMenu">
                        <a class="page-nav-child active" href="index.php?route=gerenciarUsuarios">Gerenciar Usuarios</a>
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
                    <h1>Gerenciamento de Usuarios</h1>
                    <p>Administre os usuarios do sistema.</p>
                </div>

                <div class="page-header-card">
                    <span>Usuarios</span>
                    <strong><?= count($users) ?></strong>
                    <small>usuario(s) cadastrado(s)</small>
                </div>
            </header>

            <section class="page-content-card usuarios-form-card" aria-labelledby="cadastro-usuario-title">
                <form id="formCadastrarUsuario" action="index.php?route=cadastrarUsuario" method="post" novalidate>
                    <div class="page-section-heading usuarios-create-grid">
                        <div>
                            <h2 id="cadastro-usuario-title">Cadastrar Usuario</h2>
                        </div>

                        <div>
                            <label for="nomeUsuario" class="form-label">Nome do usuario</label>
                            <input id="nomeUsuario" name="nome" type="text" class="form-control" placeholder="Nome do usuario" disabled required>
                        </div>

                        <div>
                            <label for="emailUsuario" class="form-label">Email do usuario</label>
                            <input id="emailUsuario" name="email" type="email" class="form-control" placeholder="Email do usuario" disabled required>
                        </div>

                        <div>
                            <label for="loginUsuario" class="form-label">Login do usuario</label>
                            <input id="loginUsuario" name="login" type="text" class="form-control" placeholder="Login do usuario" disabled required>
                        </div>
                    </div>

                    <div class="usuarios-create-actions">
                        <button id="btnIncluirUsuario" type="button" class="btn btn-primary" onclick="cadastrarUsuario()">Cadastrar Usuario</button>
                    </div>
                </form>
            </section>

            <section class="page-content-card" aria-labelledby="usuarios-title">
                <div class="page-section-heading">
                    <div>
                        <h2 id="usuarios-title">Usuarios</h2>
                    </div>
                </div>

                <?php if (!empty($usuariosFlash)): ?>
                    <div class="alert alert-<?= htmlspecialchars($usuariosFlash['type'], ENT_QUOTES, 'UTF-8') ?> usuarios-alert" role="alert">
                        <?= htmlspecialchars($usuariosFlash['message'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <?php if (count($users) > 0): ?>
                    <div class="table-responsive">
                        <table class="table page-table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Acoes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars((string) $user['USU_ID'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($user['USU_NOME'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($user['USU_EMAIL'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary js-editar-usuario"
                                                data-user-id="<?= htmlspecialchars((string) $user['USU_ID'], ENT_QUOTES, 'UTF-8') ?>"
                                                data-user-name="<?= htmlspecialchars($user['USU_NOME'], ENT_QUOTES, 'UTF-8') ?>"
                                                data-user-email="<?= htmlspecialchars($user['USU_EMAIL'], ENT_QUOTES, 'UTF-8') ?>"
                                            >
                                                Editar
                                            </button>
                                            <a href="index.php?route=excluirUsuario&id=<?= $user['USU_ID'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este usuario?')">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="page-empty-state usuarios-empty-state">
                        <strong>Nenhum usuario cadastrado.</strong>
                        <span>Cadastre um novo usuario para exibi-lo aqui.</span>
                    </div>
                <?php endif; ?>
                <div id="modalEditarUsuario" class="modal fade usuarios-modal" tabindex="-1" aria-labelledby="modalEditarUsuarioTitulo" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <span class="modal-kicker">Gerenciamento</span>
                                    <h5 class="modal-title" id="modalEditarUsuarioTitulo">Editar Usuario</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editarUsuarioForm" method="POST" action="index.php?route=editarUsuario">
                                    <input type="hidden" name="id" id="editarUsuarioId">
                                    <div class="mb-3">
                                        <label for="editarUsuarioNome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="editarUsuarioNome" name="nome" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editarUsuarioEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="editarUsuarioEmail" name="email" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/gerenciarUsuarios.js"></script>
</body>
</html>
