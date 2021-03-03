<?php if (!empty($_POST)) {
    $_SESSION['POST'] = $_POST;
}
$post = $_SESSION['POST'];
$urlpagination = URL_SITE.'buscar/'; ?>




<main class="wrapper">
    <div class="internas">
        <div class="page-header">
            <div class="container">
                <h1>BUSCA</h1>
                <ol class="breadcrumbs">
                    <li>
                        <a href="<?php echo URL_SITE.'home' ?>">HOME</a>
                    </li>
                    <li>
                        <span>Buscando: <?=$post['pesquisa']?></span>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container">
            <div class="row">




                <section class="col-lg-8 mgb-30">

                    <?php $where = '';
                    $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'noticias')->where('status=1 AND nome LIKE \'%'.$post['pesquisa'].'%\' ')->fetch();
                    $num_row = $Conexao->affected_rows;
                    $numero_items = 4;
                    $total_pages = round($num_row / $numero_items);
                    $page_actual = 1;
                    $page = $final_url;
                    if (isset($page) && is_numeric($page)) $page_actual = intval($page);
                    $begin = ($page_actual-1) * $numero_items;
                    $query_string = 'SELECT nome,url, descritivo,categoria,data, imagem, CONCAT("'.URL_SITE.'cateogria/",url) AS link FROM '.$_SESSION['LANG'].'noticias WHERE status = 1 AND nome LIKE \'%'.$post['pesquisa'].'%\'  ORDER BY RAND() LIMIT '.$begin.','.$numero_items;
                    $query = $Conexao->query($query_string)->fetch();
                    if ($Conexao->affected_rows > 0) :   ?>
                        <div class="row">

                            <?php foreach ($query as $data){
                            extract($data); ?>


                                <?php $query = $Conexao->select('nome')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('id = '.$categoria)->order_by('id','ASC')->fetch_first();
                                if (isset($query)) {
                                    extract($query, EXTR_PREFIX_ALL, 'cat');
                                } ?>


                                <div class="col-md-6 mgb-30">
                                    <article class="post-thumbnail">
                                        <div class="foto">
                                            <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',350,350,$imagem,'cortar'); ?>" alt="Titulo da noticia" style="--width: 350;--height: 350;"></lazy-image>
                                        </div>
                                        <div class="content">
                                            <h3 class="nome"><?=$nome;?></h3>
                                            <div class="details">
                                                <div class="data">
                                                    <time datatime="07-10-2019"><?=$data;?></time>
                                                </div>
                                                <div class="tags">
                                                    <span aria-label="categoria post"><?=$cat_nome;?></span>
                                                </div>
                                            </div>
                                            <div class="desc"><?=$descritivo;?></div>
                                            <a class="ver-detalhes" href="<?php echo URL_SITE.'categoria-detalhe/'.$url; ?>">LEIA MAIS
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            <?php } ?>

                        </div>


                        <?php if ($total_pages>=1) {
                            $inicio = 1;
                            $fim = 10;
                            $ultima = ceil($num_row / $numero_items);
                            if($page_actual > 4) {
                                $inicio = $page_actual - 3;
                                $fim = $page_actual + 3;
                            }
                            if($fim>$ultima) $fim = $ultima;
                            if($fim > 7 && $inicio > ($fim-6)) $inicio = $fim - 6;
                            if($inicio < $fim) {?>
                                <paginacao>
                                    <?php if($page_actual-1<1){
                                        $prev=1;
                                    }else{
                                        $prev=$page_actual-1;
                                    }?>
                                    <?php if($page_actual+1>$ultima){
                                        $next=$ultima;
                                    }else{
                                        $next=$page_actual+1;
                                    }?>
                                    <page-item><a href="<?=$urlpagination.$prev;?>" class="fas fa-chevron-left"></a></page-item>
                                    <?php for ($i=$inicio; $i<=$fim; $i++) {
                                        if ($page_actual==$i){
                                            $class = ' active';
                                        }else{
                                            $class = '';
                                        }?>
                                        <page-item <?=$class;?>><a href="<?=$urlpagination.$i;?>"><?=$i;?></a></page-item>
                                    <?php }?>
                                    <page-item><a href="<?=$urlpagination.$next;?>" class="fas fa-chevron-right"></a></page-item>
                                </paginacao>
                            <?php }?>
                        <?php } ?>


                    <?php else: ?>
                        <div class="text-center">Nenhum cadastro no momento.</div>
                    <?php endif; ?>
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
