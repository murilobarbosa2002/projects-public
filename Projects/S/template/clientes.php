<?php $id = 11;
if ($menus[$id]):
    $query_paginas = $Conexao->select('nome_do_menu,titulo,url')->from(PREFIX.$_SESSION['LANG'].'paginas')->where('id='.$id)->order_by('id','ASC')->fetch_first();
    if ($Conexao->affected_rows > 0): 
        extract($query_paginas);
        $urlpagination = URL_SITE.$url;
        if (count($url_atual)==1||in_array('page', $url_atual)):
            $urlpagination .= '/'; ?> 
            <main class="clientes-e-parceiros" id="clientes-e-parceiros-mod-2"> 
                <header class="page-header"> 
                    <div class="container"> 
                        <h1><?php echo $titulo; ?></h1> 
                        <ol class="breadcrumb"> 
                            <li><a href="<?php echo URL_SITE.'home' ?>">Home</a></li> 
                            <li class="active"><span><?php echo mb_convert_case($nome_do_menu, MB_CASE_TITLE, "UTF-8"); ?></span></li> 
                        </ol> 
                    </div> 
                </header> 
                <?php $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'clientes')->where('status=1')->fetch();
                $num_row = $Conexao->affected_rows;
                $numero_items = 12;
                $total_pages = round($num_row / $numero_items);
                $page_actual = 1;
                $page = $final_url;
                if (isset($page) && is_numeric($page)) $page_actual = intval($page);
                $begin = ($page_actual-1) * $numero_items;

                $query_string = 'SELECT nome,href,target,imagem FROM '.$_SESSION['LANG'].'clientes WHERE status = 1 LIMIT '.$begin.','.$numero_items;
                $query = $Conexao->query($query_string)->fetch(); 
                if ($Conexao->affected_rows > 0) : ?> 
                    <div class="container"> 
                        <div class="row clientes mgb-60">
                            <?php foreach ($query as $data): 
                                extract($data);
                                if (!empty($imagem)):
                                    if (!empty($href)): 
                                        $href = ' href="'.$href.'"'; 
                                        if (!empty($target)) { 
                                            $href .= ' target="'.$target.'"'; 
                                        } ?>
                                        <div class="col-lg-2 col-sm-3"> 
                                            <div class="cliente">
                                                <a<?php echo $href; ?>> 
                                                    <?php echo $Conexao->generate_lazy_image('clientes',180,180,$imagem,'redimencionar',$nome); ?> 
                                                    <figcaption class="nome"><?php echo $nome; ?></figcaption> 
                                                </a>
                                            </div> 
                                        </div>
                                    <?php else: ?>
                                        <div class="col-lg-2 col-sm-3"> 
                                            <div class="cliente"> 
                                                <?php echo $Conexao->generate_lazy_image('clientes',180,180,$imagem,'redimencionar',$nome); ?>
                                                <figcaption class="nome"><?php echo $nome; ?></figcaption> 
                                            </div>
                                        </div> 
                                    <?php endif;
                                endif; ?> 
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
            require_once(PATH_TEMPLATE.'404.php');
        endif;
    else:
        require_once(PATH_TEMPLATE.'404.php');
    endif; 
else:
        require_once(PATH_TEMPLATE.'404.php');
endif; ?>