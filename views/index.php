<?php

require_once __DIR__ . '/../lib/configService.php';

SessionHelper::requerLogin();

$usuario = $_SESSION['usuario'];
$perfil = $_SESSION['perfil'];

ob_start();
?>

<div class="mb-4">
    <h2>Bem vindo, <?= htmlspecialchars($usuario) ?>!</h2>
    <p>Seu perfil: <strong><?= htmlspecialchars($perfil) ?> </strong></p>
    <hr>
</div>

<?php
switch ($perfil) {
    case 'caixa':
        include __DIR__ . '/painel/caixa.php';
        break;
    case 'estoque':
        include __DIR__ . '/painel/estoque.php';
        break;
    case 'admin':
        include __DIR__ . '/painel/admin.php';
        break;
    case 'financeiro':
        include __DIR__ . '/painel/financeiro.php';
        break;
    default:
        echo "<p>Perfil não reconhecido.</p>";
}

echo '<a href="logout.php" class="btn btn-outline-danger mt-4"><i class="bi bi-box-arrow-right"></i> Sair</a>';

$conteudo = ob_get_clean();

$titulo = "Sistema Supermercado";
require __DIR__ . '/layout.php';

?>