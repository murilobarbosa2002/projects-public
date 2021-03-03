<?php include(PATH_CLASS.'crud'.SEP.'Funcoes.class.php');
$Funcoes = new Funcoes(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sistema = array(
    'titulo' => 'E-mails',
    'titulo_cadastro' => 'Cadastro',
    'titulo_atualizar' => 'Atualizar',
    'titulo_atualizar_galeria' => 'Atualizar galeria',
    'bd' => $_SESSION['LANG'].'contatos',
    'url' => 'contatos',
    'order_by' => 'created',
    'ordem' => 'DESC',
    'mostrar_excluir' => true, 
    'limitar' => false, 
    'url_amigavel_por' => 'nome',
    'quatidade_limite' => 0,
    'limitar_where' => '',
    'mostrar_clone' => false,
    'mostrar_alterar' => true,
    'mostar_voltar' => true,
    'mostar_incluir' => true,
    'list' => array(
        array(
            'nome' => 'Nome',
            'bd' => 'nome',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        ), array(
            'nome' => 'E-mail',
            'bd' => 'email',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        ), array(
            'nome' => 'Telefone',
            'bd' => 'telefone',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        ), array(
            'nome' => 'Estado',
            'bd' => 'estado',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        ), array(
            'nome' => 'Cidade',
            'bd' => 'cidade',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        )
    ),
    'serch' => array( 'nome' ),
    'search_custom' => false,
    'export_func' => true,
    'export' => array( 
        array('Nome' => 'nome'), 
        array('E-mail' => 'email'),  
        array('Telefone' => 'telefone'),  
        array('Estado' => 'estado'), 
        array('Cidade' => 'cidade'), 
        array('Mensagem' => 'mensagem'), 
    ),
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
            'amount' => '200',
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
            'name' => 'nome',
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
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros'=> '',
            'required' => true,
            'tipo_validacao' => array('vazio'),
            'div' => array('abertura' => true, 'fechamento' => true)
        ),  array(
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
            'input' => 'text',
            'category' => '',
            'parametros'=> '',
            'required' => true,
            'tipo_validacao' => array('vazio'),
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
            'input' => 'text',
            'category' => '',
            'parametros'=> '',
            'required' => true,
            'tipo_validacao' => array('vazio'),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'estado',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Estado :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros'=> '',
            'required' => true,
            'tipo_validacao' => array('vazio'),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'cidade',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Cidade :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'text',
            'category' => '',
            'parametros'=> '',
            'required' => true,
            'tipo_validacao' => array('vazio'),
            'div' => array('abertura' => true, 'fechamento' => true)
        ), array(
            'name' => 'mensagem',
            'type' => 'text',
            'amount' => '',
            'colation' => ' CHARACTER SET utf8 COLLATE utf8_general_ci',
            'null' => '',
            'default' => '',
            'pre_select_logado' => '',
            'mostrar_campo' => true,
            'swap_change' => false,
            'swap_reference' => '',
            'titulo' => 'Mensagem :',
            'class_titulo' => 'col-xs-4 align-r',
            'class' => 'col-xs-5',
            'input' => 'textarea',
            'category' => '',
            'parametros'=> '',
            'required' => true,
            'tipo_validacao' => array('vazio'),
            'div' => array('abertura' => true, 'fechamento' => true)
        ) 
    ),
    'engine' => 'ENGINE=InnoDB',
    'primary' => 'id',
    'start_autoincrement' => 'AUTO_INCREMENT=1', 
);

require(PATH_PAINEL.'_require.php'); ?>