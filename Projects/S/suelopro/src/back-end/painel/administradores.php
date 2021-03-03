<?php $Administradores = new Administradores(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$url = explode('/', $Administradores->getUrl());
if(empty($_SESSION['admin'])){
    $Administradores->redirect(URL_PAINEL);
    exit();
}
if (!isset($url[1])||$url[1]=='page') {

    if (!empty($_POST)) {

        if (isset($_POST['busca'])) {

            $_SESSION['busca'] = $_POST['busca'];
        }

        if (isset($_POST['acao'])) {

            foreach ($_POST['acao'] as $url) {

                $Administradores->delete()->from(PREFIX.'administradores')->where('url', $url)->limit(1)->execute();

            }

                $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro[s] excluído[s] com sucesso !';
            $_SESSION['SYSTEM_STATUS'] = 'success';

            $Administradores->redirect(URL_PAINEL.'administradores');
            exit();

        }

    }

    if (empty($_SESSION['busca'])) {

        $_SESSION['busca'] = '';
        $like = '';

    }else{

        $like = array('nome' => $_SESSION['busca'], 'email' => $_SESSION['busca'], 'usuario' => $_SESSION['busca']);

    } ?>
    <div class="page-content">
    	<div class="row">
    		<div class="col-xs-12">
    			<div class="page-header"><h1> Administradores </h1></div>
                <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {
                    echo $Administradores->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);
                    $_SESSION['SYSTEM_MENSSAGE'] = '';
                } ?>
                <form id="busca" class="form-horizontal panel panel-default" method="POST">
                    <div class="panel-body">
                        <div class="col-xs-4"><input type="search" class="form-control" placeholder="Buscar cadastros" name="busca" value="<?=$_SESSION['busca']?>"></div>
                        <div class="col-xs-offset-1 col-xs-4">
                            <button type="submit" class="btn btn-default btn-sm"><i class="icon-search"></i> Buscar</button>
                            <?php if (!empty($_SESSION['busca'])) { ?>
                                <a href="<?=URL_PAINEL.$sistema['url']?>/limpar" class="btn btn-sm btn-primary"><i class="icon-asterisk"></i>Limpar</a>
                            <?php } ?>
                        </div>
                        <a href="<?=URL_PAINEL?>administradores/cadastrar" class="btn btn-sm btn-success pull-right"><i class="icon-asterisk"></i>Incluir</a>
                    </div>
    			</form>
                <div class="table-responsive">

                    <form action="<?=URL_PAINEL?>administradores" method="POST" name="lista">

                        <button type="submit" class="btn btn-danger btn-sm pull-right" onclick=" return confirm('Deseja realmente excluir esse(s) administrador(es)?')">
                            <i class="icon-trash"></i>
                            Excluir cadastros selecionados
                        </button>

        				<table id="sample-table-2" class="table table-striped table-bordered table-hover">

        					<thead>
        						<tr>
        							<th class="center">
                                        <label>
                                            <input type="checkbox" class="ace" name="checkall" id="checkall" onclick="check(document.getElementsByName('acao[]'),document.lista.checkall);" />
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
        							<th>Nome</th>
        							<th>Email</th>
        							<th>Usuario</th>
        							<th>Status</th>
                                    <th>Nivel de acesso</th>
        							<th></th>
        						</tr>
        					</thead>

        					<tbody id="conteudo_body">
                                <?php if (empty($like)) {

                                    $Administradores->select('id')->from(PREFIX.'administradores')->fetch();

                                }else{

                                    $Administradores->select('id')->from(PREFIX.'administradores')->or_like($like)->fetch();

                                }

                                $num_row = $Administradores->affected_rows;

                                $total_pages = round($num_row / NUM_PAGENATION);

                                $page_actual = 1;

                                if (isset($url[2]) && is_numeric($url[2])) $page_actual = intval($url[2]);

                                $begin = ($page_actual-1) * NUM_PAGENATION;

                                if (empty($like)) {

                                    $resultados = $Administradores->select('url, nome, email, usuario, status, nivel_acesso')->from(PREFIX.'administradores')->limit(NUM_PAGENATION,$begin)->fetch();

                                }else{

                                    $resultados = $Administradores->select('url, nome, email, usuario, status, nivel_acesso')->from(PREFIX.'administradores')->or_like($like)->limit(NUM_PAGENATION,$begin)->fetch();

                                }

                                if ($Administradores->affected_rows > 0) {
                                    foreach($resultados as $resultado){ ?>
                						<tr>
                                            <td class="center">
                                                <?php if ($resultado['nivel_acesso']==1) {
                                                    if ($_SESSION['admin_nivel_acesso'] == 1) { ?>
                                                        <label>
                                                            <input type="checkbox" class="ace" id="acao-<?=$resultado['url'];?>" name="acao[]" value="<?=$resultado['url'];?>" />
                                                            <span class="lbl"></span>
                                                        </label>
                                                    <?php }
                                                }else{ ?>
                                                    <label>
                                                        <input type="checkbox" class="ace" id="acao-<?=$resultado['url'];?>" name="acao[]" value="<?=$resultado['url'];?>" />
                                                        <span class="lbl"></span>
                                                    </label>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $resultado['nome']; ?></td>
                                            <td><?php echo $resultado['email']; ?></td>
                                            <td><?php echo $resultado['usuario']; ?></td>
                                            <td>
                                                <?php if ($resultado['status']==1) {
                                                    $update = 0;
                                                    ?><span class="label label-sm label-success">Liberado</span><?php
                                                }elseif($resultado['status']==0){
                                                    $update = 1;
                                                    ?><span class="label label-sm label-danger">Bloqueado</span><?php
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($resultado['nivel_acesso']==1) {
                                                    ?><span class="label label-sm label-primary">Desenvolvedor</span><?php
                                                }elseif($resultado['nivel_acesso']==2){
                                                    ?><span class="label label-sm label-success">Administrador</span><?php
                                                }elseif($resultado['nivel_acesso']==3){
                                                    ?><span class="label label-sm label-warming">Usuário</span><?php
                                                } ?>
                                            </td>
                                            <td>
                                            	<?php if (!empty($resultado['status'])==1) { ?>
                                                    <a class="red" href="<?=URL_PAINEL?>administradores/permissao/<?=$resultado['url'];?>/<?=$update;?>" title="Bloquear">
                                                        <i class="icon-lock bigger-130"></i>
                                                    </a>
                                                <?php }else{ ?>
                                                    <a class="yellow" href="<?=URL_PAINEL?>administradores/permissao/<?=$resultado['url'];?>/<?=$update;?>" title="Desbloquear">
                                                        <i class="icon-unlock bigger-130"></i>
                                                    </a>
                                                <?php } ?>

                                                <a class="green" href="<?=URL_PAINEL?>administradores/atualizar/<?=$resultado['url'];?>"><i class="icon-pencil bigger-130"></i></a>
                                                <?php if ($resultado['nivel_acesso']==1) {
                                                    if ($_SESSION['admin_nivel_acesso'] == 1) { ?>
                                                        <a class="red" href="<?=URL_PAINEL?>administradores/excluir/<?=$resultado['url'];?>" onclick="return confirm('Deseja excluir esse administrador?')">
                                                            <i class="icon-trash bigger-130"></i>
                                                        </a>
                                                    <?php }
                                                }else{ ?>
                                                    <a class="red" href="<?=URL_PAINEL?>administradores/excluir/<?=$resultado['url'];?>" onclick="return confirm('Deseja excluir esse administrador?')">
                                                        <i class="icon-trash bigger-130"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                }else{ ?>
                                    <tr>
                                        <td colspan="6" class="center">
                                            Nenhum cadastro no momento
                                        </td>
                                    </tr>
                                <?php } ?>
        					</tbody>
                            <?php if ($total_pages>=1) { ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="center">
                                            <?php $Administradores->pagination_painel(URL_PAINEL.'administradores/',$num_row,$page_actual); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            <?php } ?>
        				</table>
                    </form>
    			</div>
    		</div>
    	</div>
    </div>
    <script type="text/javascript">
        function check(check_list,check){
            if (check.checked==true) {

                for (i = 0; i < check_list.length; i++)
                    check_list[i].checked = true ;

            }else{

                for (i = 0; i < check_list.length; i++)
                    check_list[i].checked = false ;

            }
        }
    </script>
<?php }elseif ($url[1]=='cadastrar') {
    if (!empty($_POST)) {

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $nivel_acesso = $_POST['nivel_acesso'];

        $Administradores->setNome($nome);
        $Administradores->setEmail($email);
        $Administradores->setUsuario($usuario);
        $Administradores->setSenha($senha);
        $Administradores->setNivelAcesso($nivel_acesso);

        $Administradores->cadastrar();
    }else{
        $nome = '';
        $email = '';
        $usuario = '';
        $senha = '';
        $nivel_acesso = '';
    }

    ?>
    <div class="page-header">
        <h1> Cadastro de administradores </h1>
    </div>
    <div class="col-xs-12 form-group">
        <a href="<?=URL_PAINEL?>administradores" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>
    </div>
    <div class="col-xs-12 form-group">
        <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {
            echo $Administradores->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);
            $_SESSION['SYSTEM_MENSSAGE'] = '';
        }?>
    </div>
    <form method="post">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Nome:</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="nome" class="full-width" value="<?php echo $nome;?>" maxlength="150">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Email:</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="email" class="full-width" value="<?php echo $email;?>" maxlength="150">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Usuario:</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="usuario" class="full-width" value="<?php echo $usuario;?>" maxlength="20" autocomplete="off">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Senha:</label>
                </div>
                <div class="col-xs-5">
                    <input type="password" name="senha" class="full-width" value="<?php echo $senha;?>" maxlength="12" autocomplete="off">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r"><label>Nivel acesso:</label></div>
                <div class="col-xs-1">
                    <div>
                        <select name="nivel_acesso">
                            <option value="2"<?php if ($nivel_acesso==2) { echo 'selected'; } ?>> Administrador </option>
                            <option value="3"<?php if ($nivel_acesso==3) { echo 'selected'; } ?>> Usuário </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="col-xs-12 form-group">
        <a href="<?=URL_PAINEL?>administradores" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>
    </div>
<?php }elseif ($url[1]=='atualizar') {
    if (!empty($_POST)) {

        $resultado = $Administradores->select('id')->from(PREFIX.'administradores')->where(array('url' => $url[2] ))->fetch_first();
        if ($Administradores->affected_rows > 0) {

            $id = $resultado['id'];
            $Administradores->setId($id);

        }else{
            $Administradores->redirect(URL_PAINEL.'administradores');
            exit();
        }

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $nivel_acesso = ($_SESSION['admin_nivel_acesso']==1 && $id == $_SESSION['admin_id'] ?1:$_POST['nivel_acesso']);

        $Administradores->setNome($nome);
        $Administradores->setEmail($email);
        $Administradores->setUsuario($usuario);
        $Administradores->setSenha($senha);
        $Administradores->setNivelAcesso($nivel_acesso);
        $Administradores->atualizar();

    }else{
        $resultado = $Administradores->select('nome, email, usuario, senha, nivel_acesso')->from(PREFIX.'administradores')->where(array('url' => $url[2] ))->fetch_first();
        if ($Administradores->affected_rows > 0) {

            $nome = $resultado['nome'];
            $email = $resultado['email'];
            $usuario = $resultado['usuario'];
            $senha = '';
            $nivel_acesso = $resultado['nivel_acesso'];

        }else{
            $Administradores->redirect(URL_PAINEL.'administradores');
            exit();
        }
    }

    ?>
    <div class="page-header">
        <h1> Atualizar administrador </h1>
    </div>
    <div class="col-xs-12 form-group">
        <a href="<?=URL_PAINEL?>administradores" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>
    </div>
    <div class="col-xs-12 form-group">
        <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {
            echo $Administradores->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);
            $_SESSION['SYSTEM_MENSSAGE'] = '';
        }?>
    </div>
    <form method="post">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Nome:</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="nome" class="full-width" value="<?php echo $nome;?>" maxlength="150">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Email:</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="email" class="full-width" value="<?php echo $email;?>" maxlength="150">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Usuario:</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="usuario" class="full-width" value="<?php echo $usuario;?>" maxlength="20">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r">
                    <label>Senha:</label>
                </div>
                <div class="col-xs-5">
                    <input type="password" name="senha" class="full-width" value="<?php echo $senha;?>" maxlength="12" autocomplete="off">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-3 align-r"><label>Nivel acesso:</label></div>
                <div class="col-xs-1">
                    <div>
                        <select name="nivel_acesso">
                            <option value="2"<?php if ($nivel_acesso==2) { echo 'selected'; } ?>> Administrador </option>
                            <option value="3"<?php if ($nivel_acesso==3) { echo 'selected'; } ?>> Usuário </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-success btn-sm">Atualizar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="col-xs-12 form-group">
        <a href="<?=URL_PAINEL?>administradores" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>
    </div>
<?php }elseif ($url[1]=='excluir') {
    if (!empty($url[2])) {

        $Administradores->delete()->from(PREFIX.'administradores')->where('url', $url[2])->limit(1)->execute();

        $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro excluído com sucesso !';
        $_SESSION['SYSTEM_STATUS'] = 'success';

    }else{

        $_SESSION['SYSTEM_MENSSAGE'] = 'Opssss ! Algo deu errado. ';
        $_SESSION['SYSTEM_STATUS'] = 'danger';
    }

    $Administradores->redirect(URL_PAINEL.'administradores');
    exit();

}elseif ($url[1]=='permissao') {

    if (!empty($url[2])) {

        $where = array('url' => $url[2]);

        $data = array('status' => intval($url[3]));

        $Administradores->where($where)->update(PREFIX.'administradores', $data);

        $_SESSION['SYSTEM_MENSSAGE'] = 'A permissão foi alterada com sucesso ! ';
        $_SESSION['SYSTEM_STATUS'] = 'success';

    }else{

        $_SESSION['SYSTEM_MENSSAGE'] = 'Opssss ! Algo deu errado. ';
        $_SESSION['SYSTEM_STATUS'] = 'danger';
    }

    $Administradores->redirect(URL_PAINEL.'administradores');
    exit();

}elseif ($url[1]=='limpar') {

    $_SESSION['busca'] = '';
    $Administradores->redirect(URL_PAINEL.'administradores');
    exit();

}else{
    $Administradores->not_found();
} ?>
