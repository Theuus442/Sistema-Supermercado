<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Supermercado</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == 1):?>
        <p style="color: red;">Usuário ou senha inválidos!</p>
        <?php endif;?>

        <form action="../login.php" method="post">
            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" id="usuario" required><br><br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required><br><br>
            <button type="submit">Entrar</button>
        </form>
</body>
</html>