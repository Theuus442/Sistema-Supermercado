<?php
$erroLogin = isset($_GET['erro']) && $_GET['erro'] == 1;
$titulo = "Login";
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Supermercado</title>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card shadow-lg" style="min-width: 380px;">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="bi bi-box-arrow-in-right"></i>Login - Sistema Supermercado</h4>
            </div>
            <div class="card-body">
                <?php if ($erroLogin): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> Usuário ou senha inválidos!
                    </div>
                <?php endif; ?>

                <form action="../login.php" method="post">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-door-open"></i> Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>


<?php
$conteudo = ob_get_clean();
require_once __DIR__ . '/layout.php';
