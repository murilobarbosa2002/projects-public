<?php include(PATH_CLASS.'crud'.SEP.'Funcoes.class.php');
$Funcoes = new Funcoes(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sistema = array(
    'titulo' => 'Páginas',
    'titulo_cadastro' => 'Cadastro',
    'titulo_atualizar' => 'Atualizar',
    'titulo_atualizar_galeria' => 'Atualizar galeria',
    'bd' => $_SESSION['LANG'].'paginas',
    'url' => 'paginas',
    'order_by' => 'id',
    'ordem' => 'ASC',
    'mostrar_excluir' => false,
    'limitar' => false,
    'quatidade_limite' => 0,
    'limitar_where' => '',
    'enviar_dados_por_email' => '',
    'url_amigavel_por' => 'nome_do_menu',
    'mostrar_clone' => false,
    'mostrar_alterar' => true,
    'mostar_voltar' => false,
    'mostar_incluir' => false,
    'list' => array(
        array(
            'nome' => 'ID',
            'bd' => 'id',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        ), array(
            'nome' => 'URL',
            'bd' => 'url',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        ), array(
            'nome' => 'Nome do menu',
            'bd' => 'nome_do_menu',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        )
    ),
    'search_custom' => false,
    'serch' => array( 'nome' ),
    'export_func' => false,
    'export' => array( array('Nome' => 'nome'), array('Id' => 'id') ),
    'campos' => array(
        array(
            'name' => 'id',
            'type' => 'int',
            'amount' => '11',
            'colation' => '',
            'null' => 'NOT NULL',
            'default' => 'AUTO_INCREMENT',
            'pre_select_logado' => '',
            'mostrar_campo' => false,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '',
            'class_titulo' => '',
            'class' => '',
            'input' => '',
            'category' => '',
            'parametros'=> '',
            'required' => '',
            'tipo_validacao' => '',
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'created',
            'type' => 'datetime',
            'amount' => '',
            'colation' => '',
            'null' => 'NOT NULL',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => false,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '',
            'class_titulo' => '',
            'class' => '',
            'input' => '',
            'category' => '',
            'parametros'=> '',
            'required' => '',
            'tipo_validacao' => '',
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'url',
            'type' => 'varchar',
            'amount' => '100',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => false,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '',
            'class_titulo' => '',
            'class' => '',
            'input' => '',
            'category' => '',
            'parametros'=> '',
            'required' => '',
            'tipo_validacao' => '',
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'metadescription',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Pequena descrição para o google :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'textarea',
            'category' => '',
            'parametros'=> array(
                array('only' =>
                    array(

                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ), array(
            'name' => 'keywords',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Palavras chaves para a pesquisa do google :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(

                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => false, 'fechamento' => true)
        ), array(
            'name' => 'nome_do_menu',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Nome do menu :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'maps',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Cod. Iframe do Maps :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_topo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título topo:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                      'contato','empresa','texto-1-home','texto-2-home','texto-3-home','titulo-categorias','titulo-newsletter','titulo-arquivos'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'endereco',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Endereço :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'horario_atendimento',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Hórario de Atendimento :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'frase_contato',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Frase no formulário Contato :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'titulo_categoria_home',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título categoria :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_mais_lidas_home',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título mais lidas :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'titulo-newsletter'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_sobre_nos_home',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'titulo_missao_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título Valor 1  :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'subtitulo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Subtítulo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_home',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_valor_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '<small class="red">Titulo Conceito um : </small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'descritivo_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'titulo_valor_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '<small class="red">Titulo Conceito dois : </small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_valor_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '<small class="red">Titulo Conceito três : </small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'descritivo_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'subtitulo_3',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Subtítulo:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'subtitulo_4',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Subtitulo  :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_solucoes_detalhes',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_recomendacoes',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título Recomendação :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_abaixo_servico',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Titulo de recomendação :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                     ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_recomendacoes',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'nome_do_botao_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Nome do botão um :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'href_botao_um',
            'type' => 'varchar',
            'amount' => 200,
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Link botão um:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array(
                    'only' => array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ),array(
            'name' => 'nome_do_botao_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Nome do botão dois :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'href_botao_dois',
            'type' => 'varchar',
            'amount' => 200,
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Link botão dois :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array(
                    'only' => array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ),array(
            'name' => 'title_1',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Titulo 1 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ), array(
            'name' => 'title_2',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Titulo 2:',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => false, 'fechamento' => true)
        ), array(
            'name' => 'quote_1',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo 1 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ), array(
            'name' => 'quote_2',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo 2 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => false, 'fechamento' => true)
        ),  array(
            'name' => 'imagem_quem_somos',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Imagem: <br><small class="red"></small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_editor',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                    ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descricao',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descrição :',
            'class_titulo' => 'col-xs-3 align-r',
            'class' => 'col-xs-8',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                     ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descricao_sobre_nos',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descrição :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-8',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'empresa'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'imagem',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Imagem :<br><small class="red">(Tamanho 436x464)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' =>
                    array(
                        'empresa'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_dois_empresa',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Segundo título :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'empresa','texto-1-home','texto-2-home','texto-3-home'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descricao_dois_sobre',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descrição 2 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-7',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'empresa'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'palavra_destaque',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Palavra Destaque:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-3',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'primeiro_icone',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Primeiro Ícone :<br><small class="red">(Tamanho máximo 61x58)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descrtivo_icone_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo ícone um:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'segundo_icone',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Segundo Ícone :<br><small class="red">(Tamanho máximo 61x58)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_icone_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo ícone dois:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descricao_paragrafo_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Parágrafo Um :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-7',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                     ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'descricao_paragrafo_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Parágrafo dois :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-7',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                       ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'descricao_paragrafo_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Parágrafo Três :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-7',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'imagem_dois',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Imagem Publicidade :<br><small class="red">(Tamanho máximo 350x206)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' =>
                    array(
                        'publicidade'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'titulo_trajetoria_destaque',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Titulo fonte menor:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_detalhe',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título fonte maior:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'data',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Ano:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descritivo_trajetoria',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'icone_valores',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Ícone Valores :<br><small class="red">(Tamanho 82x82)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros'=> array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_conceito',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Titulo dos Valores:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'descritivo_conceito',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo valores:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'editor_porcentagem_barra_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Editor porcentagem Barra 1 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ),array(
            'name' => 'nome_feedback_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título feedback 1 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'editor_porcentagem_barra_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Editor porcentagem Barra 2 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ),array(
            'name' => 'nome_feedback_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título feedback 2 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'editor_porcentagem_barra_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Editor porcentagem Barra 3 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ),array(
            'name' => 'nome_feedback_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título feedback 3 :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'valor_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '1°Valor :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' =>  array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'descricao_valor_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descrição um :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'valor_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '2°Valor :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'descricao_valor_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descrição dois :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'valor_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => '3°Valor :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' =>  array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'descricao_valor_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descrição três :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'valor_um_home',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Primeiro Valor :',
            'class_titulo' => 'col-xs-3 align-r',
            'class' => 'col-xs-3',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ),array(
            'name' => 'descritivo_do_valor_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo primeiro valor :',
            'class_titulo' => 'col-xs-1 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => false, 'fechamento' => true)
        ), array(
            'name' => 'valor_dois_home',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Segundo Valor :',
            'class_titulo' => 'col-xs-3 align-r',
            'class' => 'col-xs-3',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ),array(
            'name' => 'descritivo_do_valor_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descritivo segundo valor :',
            'class_titulo' => 'col-xs-1 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => false, 'fechamento' => true)
        ), array(
            'name' => 'imagem_home',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Imagem :<br><small class="red">(Tamanho 228x156)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' =>
                    array(
                       ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'primeiro_plano_nome',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Primeiro plano nome :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'descritivo_plano_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'PrimeiroPlano.Descritivo:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                 ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'valor_plano_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'PrimeiroPlano.Valor :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                       ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'segundo_plano_nome',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Segundo plano nome :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'descritivo_plano_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'SegundoPlano.Descritivo:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'valor_plano_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'SegundoPlano.Valor :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'terceiro_plano_nome',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Terceiro plano nome :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
            'name' => 'descritivo_plano_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'TerceiroPlano.Descritivo:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                      ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'valor_plano_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'TerceiroPlano.Valor :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                 ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'segundo_titulo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Segundo título :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'descricao_dois_home',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Descrição 2:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-7',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'nome_do_botao',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Nome do botão :',
            'class_titulo' => 'col-xs-2 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        'contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'href',
            'type' => 'varchar',
            'amount' => 200,
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Link:',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array(
                    'only' => array(
                       'publicidade'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ), array(
            'name' => 'frase_sucesso',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Frase de Sucesso :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'nome_autor',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Nome :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'cargo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Cargo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-6',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'foto',
            'type' => 'varchar',
            'amount' => '200',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Foto :<br><small class="red">(Tamanho maximo 80x80)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'titulo_numero_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título Numero 1 :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'numero_um',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Número 1 :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'titulo_numero_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título Numero 2 :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'numero_dois',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Número 2 :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'titulo_numero_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Título Número 3 :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'numero_tres',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Número 3 :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' =>
                    array(
                        ''
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),array(
            'name' => 'target',
            'type' => 'varchar',
            'amount' => 7,
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Abrir em :',
            'class_titulo' => 'col-xs-1 align-r',
            'class' => 'col-xs-1',
            'input' => 'select',
            'category' => '',
            'parametros'=> array(
                array(
                    'only' => array(
                        ''
                    ),
                    'conteudo' => array('_blank' => 'Nova aba', '_self' => 'Na mesma aba'),
                ),
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => false, 'fechamento' => true)
        )
    ),
    'engine' => 'ENGINE=InnoDB',
    'primary' => 'id',
    'start_autoincrement' => 'AUTO_INCREMENT=1',
);

require(PATH_PAINEL.'_require.php'); ?>