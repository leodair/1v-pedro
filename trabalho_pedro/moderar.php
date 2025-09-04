<?php
include "conexao.php";

// Atualizar recado
if(isset($_POST['atualiza'])){
    $idatualiza = intval($_POST['id']);
    $nome       = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email      = mysqli_real_escape_string($conexao, $_POST['email']);
    $msg        = mysqli_real_escape_string($conexao, $_POST['msg']);

    $sql = "UPDATE trabalho_terceiro SET nome='$nome', email='$email', mensagem='$msg' WHERE id=$idatualiza";
    mysqli_query($conexao, $sql) or die("Erro ao atualizar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}

// Excluir recado
if(
   (isset($_GET['acao']) && $_GET['acao'] == 'excluir') || 
   (isset($_POST['acao']) && $_POST['acao'] == 'excluir')
){
    $id = isset($_POST['id']) ? intval($_POST['id']) : intval($_GET['id']);
    mysqli_query($conexao, "DELETE FROM trabalho_terceiro WHERE id=$id") or die("Erro ao deletar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}

// Editar recado
$editar_id = isset($_GET['acao']) && $_GET['acao'] == 'editar' ? intval($_GET['id']) : 0;
$recado_editar = null;
if($editar_id){
    $res = mysqli_query($conexao, "SELECT * FROM trabalho_terceiro WHERE id=$editar_id");
    $recado_editar = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>Moderar pedidos</title>
<link rel="stylesheet" href="leodair.css"/>
</head>
<body>
<div id="main">
<div id="geral">
<div id="header">
    <h1>Mural de pedidos</h1>
</div>

<?php if($recado_editar): ?>
<div id="formulario_mural">
<form method="post">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?php echo htmlspecialchars($recado_editar['nome']); ?>"/><br/>
    <label>Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($recado_editar['email']); ?>"/><br/>
    <label>Mensagem:</label>
    <textarea name="msg"><?php echo htmlspecialchars($recado_editar['mensagem']); ?></textarea><br/>
    <input type="hidden" name="id" value="<?php echo $recado_editar['id']; ?>"/>
    <input type="submit" name="atualiza" value="Modificar Recado" class="btn"/>
</form>
</div>
<?php endif; ?>

<?php
$seleciona = mysqli_query($conexao, "SELECT * FROM trabalho_terceiro ORDER BY id DESC");
if(mysqli_num_rows($seleciona) <= 0){
    echo "<p>Nenhum pedido no mural!</p>";
}else{
    while($res = mysqli_fetch_assoc($seleciona)){
        echo '<ul class="recados">';
        echo '<li><strong>ID:</strong> ' . $res['id'] . '</li>';
        echo '<li><strong>Nome:</strong> ' . htmlspecialchars($res['nome']) . '</li>';
        echo '<li><strong>Email:</strong> ' . htmlspecialchars($res['email']) . '</li>';
        echo '<li><strong>Mensagem:</strong> ' . nl2br(htmlspecialchars($res['mensagem'])) . '</li>';
        echo '<li>
                <form method="post" action="moderar.php" style="display:inline;">
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
}
?>

<div id="footer"></div>
</div>
</div>
</body>
</html>
