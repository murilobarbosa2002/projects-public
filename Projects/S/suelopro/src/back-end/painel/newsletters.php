<?php include(PATH_CLASS.'crud'.SEP.'Funcoes.class.php');
$Funcoes = new Funcoes(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sistema = array(
    'titulo' => 'Newsletters',
    'titulo_cadastro' => 'Cadastro',
    'titulo_atualizar' => 'Atualizar',
    'titulo_atualizar_galeria' => 'Atualizar galeria',
    'bd' => $_SESSION['LANG'].'newsletters',
    'url' => 'newsletters',
    'order_by' => 'created',
    'ordem' => 'DESC',
    'mostrar_excluir' => true, 
    'limitar' => false, 
    'url_amigavel_por' => 'email',
    'quatidade_limite' => 0,
    'limitar_where' => '',
    'mostrar_clone' => false,
    'mostrar_alterar' => true,
    'mostar_voltar' => true,
    'mostar_incluir' => true,
    'list' => array(
        array(
            'nome' => 'E-mail',
            'bd' => 'email',
            'type' => 'text',
            'category' => '',
            'nivel_de_acesso' => array(1,2,3),
        )
    ),
    'serch' => array( 'nome' ),
    'search_custom' => false,
    'export_func' => true,
    'export' => array(  
        array('Data do cadastro' => 'created'),   
        array('E-mail' => 'email'),   
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
        )
    ),
    'engine' => 'ENGINE=InnoDB',
    'primary' => 'id',
    'start_autoincrement' => 'AUTO_INCREMENT=1', 
);

require(PATH_PAINEL.'_require.php'); ?>