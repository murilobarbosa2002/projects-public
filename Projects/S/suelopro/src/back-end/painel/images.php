<?php include(PATH_CLASS.'crud'.SEP.'Images.class.php');
$Images = new Images(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$url = explode('/', $Images->getUrl());
if(empty($_SESSION['admin'])){ $Administradores->redirect(URL_PAINEL); exit(); }
if (!isset($url[1])) {  ?>
    <div class="col-xs-12"><div class="page-header"><h1>Imagens para editor</h1></div></div>
    <div class="col-xs-12"> 
        <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') { echo $Images->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']); $_SESSION['SYSTEM_MENSSAGE'] = ''; } ?>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Propriedades da Imagem</h4>
                <p>Os formatos válidos de imagem são: jpg, png, gif e jpeg.</p>
                <p>Dica: Coloque imagens com menos de 1mb para um carregamento mais ágil.</p>
                <p>Dica: Utilize imagens de boa qualidade.</p>
            </div>
            <div class="panel-footer">
                <form action="<?=URL_PAINEL?>images/cadastrar" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nome" class="col-sm-3 control-label">Nome:</label>
                        <div class="col-sm-9"><input type="text" class="col-xs-12 col-sm-7" name="nome" id="nome"></div>
                    </div>
                    <div class="form-group">
                        <label for="imagem" class="col-sm-3 control-label">Imagem:</label>
                        <div class="col-sm-9"><input type="file" id="imagem" name="imagem"></div>
                    </div>
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12"><h4 class="header smaller lighter blue">Clique nas imagens para alterar seus dados</h4></div>
    <div class="col-xs-12 form-group">
        <ul class="ace-thumbnails">
            <?php $resultados = $Images->select('url, nome, imagem')->from(PREFIX.'images')->fetch();
            if ($Images->affected_rows > 0) {
                foreach($resultados as $resultado){
                    extract($resultado);
                    $path_image_config = URL_UPLOAD_IMAGE.'editor/';
                    $real_path_image_config = PATH_IMAGES.'editor'.SEP; ?>
                    <li>
                        <a data-rel="colorbox">
                            <i class="miniatura" style="background-image: url(<?=$Images->image($imagem,220,220,$real_path_image_config,'cortar',100,$path_image_config)?>); background-size:100% auto;"></i>
                            <div class="text"><div class="inner"><?=$nome?></div></div>
                        </a>
                        <div class="tools tools-top"><input type="text" class="col-xs-12" value="<?=URL_UPLOAD_IMAGE?>editor/<?=$imagem?>" readonly></div>
                        <div class="tools tools-bottom">
                            <a href="<?=URL_PAINEL?>images/atualizar/<?=$url;?>"><i class="icon-pencil"></i></a>
                            <a href="<?=URL_PAINEL?>images/excluir/<?=$url;?>"><i class="icon-remove red"></i></a>
                        </div>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>
<?php }elseif ($url[1]=='cadastrar') {

    if (!empty($_POST)) {

        $nome = $_POST['nome'];
        $imagem = $_FILES['imagem'];

        $Images->setNome($nome);
        $Images->setUrl($nome);
        $Images->setImagem($imagem);

        $Images->cadastrar();

    }

    $this->redirect(URL_PAINEL.'images');
    exit();

}elseif ($url[1]=='atualizar') {
    if (!empty($_POST)) {

        $resultado = $Images->select('id')->from(PREFIX.'images')->where(array('url' => $url[2] ))->fetch_first();
        if ($Images->affected_rows > 0) {

            $id = $resultado['id'];
            $Images->setId($id);

        }else{
            $Images->redirect(URL_PAINEL.'images');
            exit();
        }

        $nome = $_POST['nome'];
        $imagem = $_FILES['imagem'];

        $Images->setNome($nome);
        $Images->setUrl($nome);
        $Images->setImagem($imagem);

        $Images->atualizar();

    }else{
        $resultado = $Images->select('nome, imagem')->from(PREFIX.'images')->where(array('url' => $url[2] ))->fetch_first();
        if ($Images->affected_rows > 0) {

            $nome = $resultado['nome'];
            $imagem = $resultado['imagem'];

            $path_image_config = URL_UPLOAD_IMAGE.'editor/'; 
            $real_path_image_config = PATH_IMAGES.'editor'.SEP;
        }else{
            $Images->redirect(URL_PAINEL.'images');
            exit();
        }
    } ?>
    <div class="col-xs-12"><div class="page-header"><h1>Atualizar imagem</h1></div></div>
    <div class="col-xs-12 form-group"><a href="<?=URL_PAINEL?>images" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a></div>
    <div class="col-xs-12">
        <form class="form-horizontal panel panel-default" method="post" enctype="multipart/form-data">
            <div class="panel-body">
                <div class="form-group">
                    <label for="img" class="col-sm-3 control-label">Imagem:</label>
                    <div class="col-sm-9"><img src="<?=$Images->image($imagem,350,350,$real_path_image_config,'redimencionar',100,$path_image_config)?>"></div>
                </div>
                <div class="form-group">
                    <label for="nome" class="col-sm-3 control-label">Nome:</label>
                    <div class="col-sm-9"><input type="text" class="col-xs-12 col-sm-7" name="nome" id="nome" value="<?php echo $nome;?>"></div>
                </div>
                <div class="form-group">
                    <label for="imagem" class="col-sm-3 control-label">Imagem:</label>
                    <div class="col-sm-9"> <input type="file" id="imagem" name="imagem"> <p>(Ou deixe em branco caso não queira atualizar o arquivo da imagem)</p> </div>
                </div>
            </div>

            <div class="clearfix panel-footer"><div class="col-sm-offset-3 col-sm-9"><button type="submit" class="btn btn-success btn-sm">Atualizar</button></div></div>
        </form>
    </div>
    <div class="col-xs-12 form-group"><a href="<?=URL_PAINEL?>images" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a></div>
<?php }elseif ($url[1]=='excluir') {

    if (isset($url[2])) {

        $rows = $Images->select('imagem')->from(PREFIX.'images')->where(array('url' => $url[2]))->fetch_first();
        if ($Images->affected_rows > 0) {
            $Images->delete_images_from_path(PATH_IMAGES.'editor'.SEP,$rows['imagem']); 
        }

        $Images->delete()->from(PREFIX.'images')->where('url', $url[2])->limit(1)->execute();

        $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro excluído com sucesso !';
        $_SESSION['SYSTEM_STATUS'] = 'success';

    }

    $this->redirect(URL_PAINEL.'images');
    exit();

}elseif ($url[1]=='instalar') {

    $Images->instalar();

} ?>
