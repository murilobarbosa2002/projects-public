<?php $id = 10;
if ($menus[$id]):
    $query_paginas = $Conexao->select('nome_do_menu,titulo,url')->from(PREFIX.$_SESSION['LANG'].'paginas')->where('id='.$id)->order_by('id','ASC')->fetch_first();
    if ($Conexao->affected_rows > 0): 
        extract($query_paginas);
        $urlpagination = URL_SITE.$url;
        if (count($url_atual)==1||in_array('page', $url_atual)):
            $urlpagination .= '/'; ?> 
            <main class="galeria-fotos" id="modelo-3"> 
                <div class="page-header"> 
                    <div class="container"> 
                        <h1><?php echo $titulo; ?></h1> 
                        <ol class="breadcrumb"> 
                            <li><a href="<?php echo URL_SITE.'home' ?>">Home</a></li> 
                            <li class="active"><span><?php echo mb_convert_case($nome_do_menu, MB_CASE_TITLE, "UTF-8"); ?></span></li> 
                        </ol> 
                    </div> 
                </div> 
                <?php $where = ''; 
                $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'fotos')->where('status=1'.$where)->fetch();
                $num_row = $Conexao->affected_rows;
                $numero_items = 9;
                $total_pages = round($num_row / $numero_items);
                $page_actual = 1;
                $page = $final_url;
                if (isset($page) && is_numeric($page)) $page_actual = intval($page);
                $begin = ($page_actual-1) * $numero_items;

                $query_imagem = ',(SELECT '.$_SESSION['LANG'].'galeriafotos.image FROM '.$_SESSION['LANG'].'galeriafotos WHERE '.$_SESSION['LANG'].'galeriafotos.'.$_SESSION['LANG'].'fotos='.$_SESSION['LANG'].'fotos.id ORDER BY ABS('.$_SESSION['LANG'].'galeriafotos.ordem) ASC LIMIT 1) AS imagem';
                $query_string = 'SELECT '.$_SESSION['LANG'].'fotos.nome, '.$_SESSION['LANG'].'fotos.id, '.$_SESSION['LANG'].'fotos.url'.$query_imagem.'
                FROM '.$_SESSION['LANG'].'fotos 
                WHERE '.$_SESSION['LANG'].'fotos.status = 1 '.$where.' ORDER BY '.$_SESSION['LANG'].'fotos.nome ASC LIMIT '.$begin.','.$numero_items; 
                $query = $Conexao->query($query_string)->fetch(); 
                if ($Conexao->affected_rows > 0) : ?>
                    <div class="container"> 
                        <div class="row"> 
                            <?php foreach ($query as $data): 
                                extract($data); ?>
                                <div class="col-md-4 col-sm-6"> 
                                    <div class="album-fotografia">
                                        <a href="<?php echo $urlpagination.$url; ?>"> 
                                            <?php if (!empty($imagem)): ?>
                                                <div class="foto"> 
                                                    <?php echo $Conexao->generate_lazy_image('fotos',350,220,$imagem,'cortar',$nome); ?>
                                                </div> 
                                            <?php endif; ?>
                                            <div class="album-caption"> 
                                                <div class="nome"><?php echo $nome ?></div> 
                                                <div class="description">VISUALIZAR ÁLBUM [+]</div> 
                                            </div> 
                                        </a>
                                    </div> 
                                </div> 
                            <?php endforeach; ?>
                        </div> 
                        <?php if ($total_pages>=1): ?>
                            <div class="paginacao">
                                <?php $inicio = 1;
                                $fim = 10;
                                $ultima = ceil($num_row / $numero_items);
                                if($page_actual > 4):
                                    $inicio = $page_actual - 3;
                                    $fim = $page_actual + 3;
                                endif;
                                if($fim>$ultima) $fim = $ultima;
                                if($fim > 7 && $inicio > ($fim-6)) $inicio = $fim - 6;
                                if($inicio < $fim):
                                    for ($i=$inicio; $i<=$fim; $i++) {
                                        if ($page_actual==$i){
                                            echo '<span class="active">'.$i.'</span>';
                                        }else{ 
                                            echo '<a href="'.$urlpagination.'page/'.$i.'">'.$i.'</a>';
                                        }
                                    }
                                endif; ?>  
                            </div> 
                        <?php endif; ?>

                    </div> 
                <?php else: ?>
                    <div class="text-center">Nenhum cadastrado encontrado no momento</div>
                <?php endif; ?> 
            </main>
        <?php else:  
            $query = $Conexao->select('id,url,nome')->from(PREFIX.$_SESSION['LANG'].'fotos')->where('url = \''.$final_url.'\' AND status = 1')->order_by('id','ASC')->fetch_first();
            if (isset($query)) {
                extract($query,EXTR_OVERWRITE);
                require(PATH_TEMPLATE.'fotos-detalhes.php');
            }else{
                require(PATH_TEMPLATE.'404.php');
            }
        endif;
    else:
        require_once(PATH_TEMPLATE.'404.php');
    endif; 
else:
        require_once(PATH_TEMPLATE.'404.php');
endif; ?>