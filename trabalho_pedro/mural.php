<?php
include "conexao.php";

// Inserir novo recado
if(isset($_POST['cadastra'])){
    $nome  = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $msg   = mysqli_real_escape_string($conexao, $_POST['msg']);

    $sql = "INSERT INTO trabalho_terceiro (nome, email, mensagem) VALUES ('$nome', '$email', '$msg')";
    mysqli_query($conexao, $sql) or die("Erro ao inserir dados: " . mysqli_error($conexao));
    header("Location: mural.php");
    exit;
}

// Excluir recado direto no mural
if(isset($_POST['acao']) && $_POST['acao'] == 'excluir'){
    $id = intval($_POST['id']);
    mysqli_query($conexao, "DELETE FROM trabalho_terceiro WHERE id=$id") or die("Erro ao deletar: " . mysqli_error($conexao));
    header("Location: mural.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>Mural de pedidos</title>
<link rel="stylesheet" href="leodair.css"/>



<script src="scripts/jquery.js"></script>
<script src="scripts/jquery.validate.js"></script>
<script>
$(document).ready(function() {
    $("#mural").validate({
        rules: {
            nome: { required: true, minlength: 4 },
            email: { required: true, email: true },
            msg: { required: true, minlength: 10 }
        },
        messages: {
            nome: { required: "Digite o seu nome", minlength: "O nome deve ter no mínimo 4 caracteres" },
            email: { required: "Digite o seu e-mail", email: "Digite um e-mail válido" },
            msg: { required: "Digite sua mensagem", minlength: "A mensagem deve ter no mínimo 10 caracteres" }
        }
    });
});
</script>
</head>
<body>
<div id="main">
<div id="geral">
<div id="header">
    <h1>Mural de pedidos</h1>
</div>

<div id="formulario_mural">
<form id="mural" method="post">
    <label>Nome:</label>
    <input type="text" name="nome"/><br/>
    <label>Email:</label>
    <input type="text" name="email"/><br/>
    <label>Mensagem:</label>
    <textarea name="msg"></textarea><br/>
    <input type="submit" value="Publicar no Mural" name="cadastra" class="btn"/>
</form>
</div>

<?php
$seleciona = mysqli_query($conexao, "SELECT * FROM trabalho_terceiro ORDER BY id DESC");
while($res = mysqli_fetch_assoc($seleciona)){
    echo '<ul class="recados">';
    echo '<li><strong>ID:</strong> ' . $res['id'] . '</li>';
    echo '<li><strong>Nome:</strong> ' . htmlspecialchars($res['nome']) . '</li>';
    echo '<li><strong>Email:</strong> ' . htmlspecialchars($res['email']) . '</li>';
    echo '<li><strong>Mensagem:</strong> ' . nl2br(htmlspecialchars($res['mensagem'])) . '</li>';

    // Botões de ação
    echo '<li>
            <form method="post" action="mural.php" style="display:inline;">
                <input type="hidden" name="id" value="' . $res['id'] . '"/>
                <input type="hidden" name="acao" value="excluir"/>
                <button type="submit" onclick="return confirm(\'Tem certeza que deseja excluir este recado?\')" class="btn-excluir">
                    Excluir
                </button>
            </form>

            <a href="moderar.php?acao=editar&id=' . $res['id'] . '" class="btn-editar">Editar</a>
          </li>';

    echo '</ul>';
}
?>
<div id="footer"></div>
</div>
</div>
</body>
</html>

