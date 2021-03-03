<?php $url_page = explode('/',$Conexao->getUrl());
$url_servico = end($url_page);
$where = array('status' => 1, 'url' => $url_servico );
$resultado = $Conexao->select('id,nome,descricao,data,imagem,categoria')->from(PREFIX.$_SESSION['LANG'].'noticias')->where($where)->fetch_first();
if ($Conexao->affected_rows > 0) {
    extract($resultado);
} ?>




<?php $query = $Conexao->select('nome,id')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('id = '.$categoria)->fetch_first();
if (isset($query)) {
extract($query, EXTR_PREFIX_ALL, 'cat'); ?>
<main class="wrapper">
    <div class="internas">
        <div class="page-header">
            <div class="container">
                <h1><?php echo mb_convert_case($cat_nome, MB_CASE_UPPER, "UTF-8"); ?></h1>
                <ol class="breadcrumbs">
                    <li>
                        <a href="<?php echo URL_SITE.'home' ?>">HOME</a>
                    </li>
                    <li>
                        <span><?php echo mb_convert_case($cat_nome, MB_CASE_UPPER, "UTF-8"); ?></span>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <section class="col-lg-8 mgb-30">
                    <div class="post">
                        <figure class="foto-principal">


                            <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',730,487,$imagem,'cortar'); ?>" alt="<?=$nome;?>" style="--width: 730;--height: 487;"></lazy-image>

                        </figure>
                        <div class="details">
                            <div class="data"><?=$data;?></div>
                            <div class="tags">
                                <span><?=$nome;?></span>
                            </div>
                        </div>
                        <div class="clearfix mgb-30">
                            <?=$descricao;?>
                        </div>
                        <div class="text-right">
                            <a class="btn btn-voltar" href="javascript:history.back()">VOLTAR</a>
                        </div>
                    </div>
                </section>
                <div class="col-lg-4 mgb-30">
                    <aside class="sidebar">



                        <div class="block">
                            <div class="block-head"><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'titulo-categorias'))?></div>


                            <div class="block-body">
                                <ol class="categorias">

                                    <?php $resultados = $Conexao->query("SELECT $_SESSION[LANG]cadastrar_categoria.nome, $_SESSION[LANG]cadastrar_categoria.url, count($_SESSION[LANG]cadastrar_categoria.id) as quantidade FROM $_SESSION[LANG]cadastrar_categoria, $_SESSION[LANG]noticias WHERE $_SESSION[LANG]cadastrar_categoria.status = 1 AND $_SESSION[LANG]cadastrar_categoria.id = $_SESSION[LANG]noticias.categoria AND $_SESSION[LANG]noticias.status = 1 GROUP BY $_SESSION[LANG]cadastrar_categoria.id")->fetch();
                                    if($Conexao->affected_rows>0){
                                        foreach($resultados as $resultado){
                                            extract($resultado);?>
                                            <li>
                                                <a href="<?php echo URL_SITE.'categoria/'.$url; ?>">
                                                    <span class="badge"><?=$quantidade;?></span><?=$nome;?></a>
                                            </li>
                                        <?php }
                                    }?>
                                </ol>
                            </div>


                        </div>




                        <div class="block newsletter">
                            <div class="block-head"><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'titulo-newsletter'))?></div>
                            <div class="block-body">

                                <form id="newsletters" method="post" action="<?php echo URL_SITE.'ajax/newsletter.php' ?>">
                                    <p><?=$Conexao->get_custom_by('descritivo','paginas',array('url' => 'titulo-newsletter'))?></p>
                                    <label class="sr-only" for="newsletter">Seu email</label>
                                    <div class="input-group">
                                        <input class="form-control" type="email" name="email" id="email" placeholder="Seu email..." />
                                        <button class="btn btn-newsletter" role="button" aria-label="Cadastrar">
                                            <span class="sr-only">Cadastrar</span>
                                            <svg class="svg-icon">
                                                <use xlink:href="#send-button"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </form>


                            </div>
                        </div>



                        <?php $resultados = $Conexao->query("SELECT ano,id FROM $_SESSION[LANG]noticias WHERE status = 1 GROUP BY ano ORDER BY ano ASC")->fetch();
                        if($Conexao->affected_rows>0){?>
                            <div class="block">
                                <div class="block-head"><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'titulo-arquivos'))?></div>
                                <div class="block-body">
                                    <ol class="categorias">


                                        <?php foreach($resultados as $key => $resultado){
                                            extract($resultado);?>
                                            <li>
                                                <a role="button" data-toggle="collapse" data-target="#arquivos-<?=$key;?>" aria-expanded="false" aria-label="Arquivos de <?=$ano;?>"><?=$ano;?></a>
                                                <ol class="collapse" id="arquivos-<?=$key;?>">


                                                    <?php
                                                    $where = 'ano='.$ano.' AND YEAR(data) <= DATE(NOW())';
                                                    $resultados = $Conexao->select('data,COUNT(id) AS total')->from(PREFIX.$_SESSION['LANG'].'noticias')->where($where)->group_by('MONTH(data)')->order_by('data','DESC')->fetch();
                                                    if ($Conexao->affected_rows > 0) : ?>
                                                        <?php foreach ($resultados as $key => $resultado) {
                                                            extract($resultado);
                                                            $nome = utf8_encode(strftime("%B", strtotime($data))); ?>
                                                            <li>
                                                                <a href="<?php echo URL_SITE.'arquivos'.'/'.$ano.'/'.strtolower($nome); ?>">
                                                                    <span class="badge"><?=$total;?></span><?php echo ucfirst($nome); ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    <?php endif; ?>
                                                </ol>
                                            </li>
                                        <?php }?>


                                    </ol>
                                </div>
                            </div>
                        <?php }?>




                    </aside>


                    <div class="banner">
                        <?php $query_paginas = $Conexao->select('imagem_dois,href')->from(PREFIX.$_SESSION['LANG'].'paginas')->where('url = "publicidade"')->fetch();
                        if (isset($query_paginas[0])):
                            extract($query_paginas[0],EXTR_OVERWRITE);   ?>
                            <?php if (!empty($href)):?>
                            <a href="<?=$href;?>">
                                <lazy-image src="<?php echo $Conexao->generate_image_src('paginas',350,206,$imagem_dois,'redimencionar'); ?>" style="--width: 350;--height: 206;"></lazy-image>
                            </a>
                        <?php endif;?>
                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
</main>
<?php } ?>