<?php require('../config.php');
require(PATH_CLASS.'conn'.SEP.'Conexao.class.php');
$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$bd	= $_POST['bd'];
$name = $_POST['name'];
$id	= $_POST['id'];
$where	= $_POST['where'];
$valor	= $_POST['valor'];
$valor = intval($valor);

$resultados = $Conexao->select($id.', '.$name)->from(PREFIX.$bd)->where(array($where => $valor ))->order_by($name,'ASC')->fetch();
if ($Conexao->affected_rows > 0) {
	echo '<option value=""></option>';
	foreach ($resultados as $resultado) {
		echo '<option value="'.$resultado[$id].'">'.$resultado[$name].'</option>';
	}
}else{
	echo '<option value=""></option>';
} ?>
