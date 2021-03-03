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
                        'empresa','produtos','servicos','fotos','clientes','contato'
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
                        'empresa','produtos','servicos','fotos','clientes','contato'
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
            'mostrar_campo' => false,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Nome do menu :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => '',
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
            'titulo' => 'Titulo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-1','texto-2','texto-3','texto-4','texto-5','texto-6','empresa','produtos','servicos','fotos','clientes','contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'google_maps',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Google maps :',
            'class_titulo' => 'col-xs-4 align-r',
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
            'titulo' => 'Subtitulo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-2','texto-3','texto-4','texto-5','texto-6','empresa','contato'
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
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6','contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'telefone',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Telefone :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6','contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'email',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'E-mail :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6','contato'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'atendimento',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Horário de Atendimento :',
            'class_titulo' => 'col-xs-4 align-r',
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
            'name' => 'facebook',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Facebook :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'twitter',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Twitter :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'instagram',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Instagram :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'pinterest',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Pinterest :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'mail',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Mail :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-6'
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
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-1'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'resumo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Resumo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
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
            'titulo' => 'Imagem :<br><small class="red">(Tamanho 536x511)</small>',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-4',
            'input' => 'image',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-2'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array( ),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'outro_titulo',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Outro Titulo :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
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
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'editor',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-2','empresa','contato'
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
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros' => array(
                array('only' => 
                    array(
                        'texto-2','texto-3','texto-4'
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
            'titulo' => 'Link :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros'=> array(
                array(
                    'only' => array(
                        'texto-2','texto-3','texto-4'
                    )
                )
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => false)
        ), array(
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
                        'texto-2','texto-3','texto-4'
                    ),
                    'conteudo' => array('_blank' => 'Nova aba', '_self' => 'Na mesma aba'),
                ),
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => false, 'fechamento' => true)
        ), array(
            'name' => 'sistema',
            'type' => 'varchar',
            'amount' => 10,
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Mostrar os :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-1',
            'input' => 'select',
            'category' => '',
            'parametros'=> array(
                array(
                    'only' => array(
                        'texto-3'
                    ),
                    'conteudo' => array('produtos' => 'Produtos', 'servicos' => 'Serviços'),
                ),
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'sessao',
            'type' => 'varchar',
            'amount' => 7,
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => 'NOT NULL',
            'default' => 'DEFAULT 0',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Esconder esta sessão :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-1',
            'input' => 'select',
            'category' => '',
            'parametros'=> array(
                array(
                    'only' => array(
                        'texto-1','texto-2','texto-3','texto-4','texto-5'
                    ),
                    'conteudo' => array(1 => 'Sim', 0 => 'Não'),
                ),
            ),
            'required' => false,
            'tipo_validacao' => array(),
            'div' => array('abertura' => true, 'fechamento' => true)
        )
    ),
    'engine' => 'ENGINE=InnoDB',
    'primary' => 'id',
    'start_autoincrement' => 'AUTO_INCREMENT=1',  
);

require(PATH_PAINEL.'_require.php'); ?>