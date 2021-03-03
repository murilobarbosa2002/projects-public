<?php require('../config.php');
require(PATH_CLASS.'conn'.SEP.'Conexao.class.php');
$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
extract($_POST);
if (!empty($vals)): 
	foreach ($vals as $key => $val) {
		if ($key>0) {
			$sqlwhere .=' OR ';
		}
		$sqlwhere .= $select.'.'.$compare.' = '.$val;
	}
else:
	$sqlwhere = '';
endif; 

if (!empty($sqlwhere )) {
	$resultados = $Conexao->query('SELECT '.$where.'.'.$name.', '.$where.'.'.$primary.' FROM '.$where.' LEFT JOIN '.$select.' ON '.$where.'.id = '.$select.'.'.$banco.' WHERE '.$sqlwhere)->fetch();
	if ($Conexao->affected_rows > 0) {
	 	echo '<option value=""></option>';
	 	foreach ($resultados as $resultado) {
	 		echo '<option value="'.$resultado[$primary].'">'.$resultado[$name].'</option>';
	 	}
	}else{
	 	echo '<option value=""></option>';
	}
}else{
	echo '<option value=""></option>';
} ?>