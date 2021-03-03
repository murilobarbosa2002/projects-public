<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title><?php echo $titulo_do_site ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- manifest-->
    <link rel="manifest" href="<?php echo URL_SITE_TEMPLATE; ?>assets/application/manifest.json" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $Conexao->generate_image_src('configuracoes',35,35,$favicon,'redimencionar'); ?>" />
    <!-- add to home screen (ios)-->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="<?php echo $titulo_do_site ?>" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#9E4A98" />
    <link rel="apple-touch-icon" href="<?php echo $Conexao->generate_image_src('configuracoes',152,152,$favicon,'redimencionar'); ?>" />
    <!-- add to home screen (chrome)-->
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="application-name" content="<?php echo $titulo_do_site ?>" />
    <meta name="theme-color" content="#9E4A98" />
    <link rel="icon" sizes="192x192" href="assets/application/icon-192x192.png" />
    <!-- Tile icon for Win8 (144x144 + tile color)-->
    <meta name="msapplication-TileImage" content="assets/application/icon-144x144.png" />
    <meta name="msapplication-TileColor" content="#9E4A98" />
    <!-- ICONS-->
    <link rel="icon" sizes="72x72" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',72,72,$favicon,'redimencionar'); ?>">
    <link rel="icon" sizes="96x96" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',96,96,$favicon,'redimencionar'); ?>">
    <link rel="icon" sizes="128x128" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',128,128,$favicon,'redimencionar'); ?>">
    <link rel="icon" sizes="144x144" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',144,144,$favicon,'redimencionar'); ?>">
    <link rel="icon" sizes="152x152" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',152,152,$favicon,'redimencionar'); ?>">
    <link rel="icon" sizes="192x192" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',192,192,$favicon,'redimencionar'); ?>">
    <link rel="icon" sizes="384x384" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',384,384,$favicon,'redimencionar'); ?>">
    <link rel="icon" sizes="512x512" type="image/png" href="<?php echo $Conexao->generate_image_src('configuracoes',512,512,$favicon,'redimencionar'); ?>">
    <link rel="preload" as="script" href="<?php echo URL_SITE_TEMPLATE; ?>assets/js/jquery.min.js">
    <link rel="preload" as="script" href="<?php echo URL_SITE_TEMPLATE; ?>assets/js/bootstrap.min.js">
    <link rel="preload" as="script" href="<?php echo URL_SITE_TEMPLATE; ?>assets/js/scripts.min.js">
    <!-- CSS-->
    <link rel="stylesheet" href="<?php echo URL_SITE; ?>assets/css/estilos.css" />
    <!---->

    <link rel="canonical" href="<?php echo URL_SITE; ?>">

    <!--||-->
    <?php $routes = [];
    $routes['home'] = array( 'table' => 'configuracoes');
    $routes['home'] = array( 'table' => 'configuracoes','title' => 'title_1', 'meta' => 'metadescription', 'keys' => 'keywords');
    $routes['quem-somos'] = array('table' => 'paginas', 'title' => 'title_1', 'meta' => 'metadescription', 'keys' => 'keywords');
    $routes['catalogos'] = array('table' => 'paginas', 'title' => 'title', 'meta' => 'metadescription', 'keys' => 'keywords');
    $routes['catalogos/page/{number}'] = array('table' => 'paginas', 'title' => 'title', 'meta' => 'metadescription', 'keys' => 'keywords');
    $routes[''] = array('table' => 'paginas', 'title' => 'title', 'meta' => 'metadescription', 'keys' => 'keywords');
    $Conexao->get_headers($configuracoes, $routes); ?>
    <!--||-->

    <!--||-->
    <link rel="stylesheet" type="text/css" href="<?php echo URL_PAINEL_TEMPLATE?>assets/css/stylesbackend.css">
    <!--||-->


    <!-- Variaveis CSS-->
    <style>:root{

            --theme: #FF8F2D;
            --dark-theme: #FF8F2D;
            --light-theme: #004770;
            /*topo*/
            --bg-mobile-controls: var(--theme);
            --color-mobile-controls: #9e4a98;
            --bg-btn-mobile-controls: var(--theme);
            --color-btn-mobile-controls: #9e4a98;
            --bg-btn-mobile-controls-hover: var(--dark-theme);
            --color-btn-mobile-controls-hover: #9e4a98;
            --bg-faixa-topo: #FF8F2D;
            --color-faixa-topo: #FFF;
            --bg-main-topo: #004770;
            --bg-btn-search: #004770;
            --color-btn-search: #FFF;
            --bg-btn-search-hover: #FF8F2D;
            --color-btn-search-hover: #FFF;--borda-menu-active: var(--theme);
            --color-menu-active: #FFF;--bg-menu-active-mobile: var(--theme);
            --color-menu-active-mobile: #FFF;
            /*Rodape*/
            --border-top-rodape: 3px solid #FF8F2D;
            --bg-rodape: #004770;
            --color-rodape: #FFF;
            --color-rodape-link-hover: var(--theme);
            --bg-creditos: #004770;--color-creditos: #FFF;
            --border-creditos: 3px solid #FF8F2D;
            /*Home*/
            --color-h1-title-section: #000;
            --color-h2-title-section: #000;
            --color-h1-title-section-ultimas-noticias: #000;
            --color-h2-title-section-ultimas-noticias: #000;
            /*post-thumbnail*/
            --color-title-post-thumbnail-hover: #004770;
            --color-link-post-thumbnail: var(--theme);
            --box-shadow-post-thumbnail: none;
            /*fim post-thumbnail*/
            --bg-posts-importantes: #e4e4e4;
            --bg-btn-newsletter: var(--theme);
            --color-btn-newsletter: #FFF;
            --bg-btn-newsletter-hover: var(--dark-theme);
            --color-btn-newsletter-hover: #fff;
            --bg-page-header: #f0f0f0;
            --color-page-header: #000;
            --page-header-span-color: #777;
            --page-header-a-hover: var(--theme);
            --bg-btn-voltar: var(--theme);
            --color-btn-voltar: #FFF;
            --bg-btn-voltar-hover: var(--dark-theme);
            --color-btn-voltar-hover: #FFF;

        }
            .topo input::-webkit-input-placeholder { /* Edge */
            color: #fff !important;
            }

            .topo input:-ms-input-placeholder { /* Internet Explorer */
            color: #fff !important;
            }

            .topo input::placeholder {
            color: #fff !important;
            }

            .main-topo .form-control, .select-custom input[name="filtro"]{
                color: #FFF;
            }

            @media(min-width:992px){

                body .topo .menu a {
                    color: #fff;
                }
            }
        </style>
</head>
<body data-path="<?php echo URL_SITE; ?>">
<?php $Conexao->get_code_body($configuracoes);
$lang = $_SESSION['LANG']; ?>
<!-- SPRITES EM SVG-->
<div class="sprite-svg-area">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <linearGradient id="b">
                <stop offset="0"></stop>
                <stop offset="1" stop-opacity="0"></stop>
            </linearGradient>
            <linearGradient id="a">
                <stop offset="0"></stop>
                <stop offset="1" stop-opacity="0"></stop>
            </linearGradient>
            <linearGradient xlink:href="#a" id="d" x1="209.089" y1="214.86" x2="229.402" y2="227.715" gradientUnits="userSpaceOnUse" gradientTransform="translate(-126.195 -179.291)"></linearGradient>
            <linearGradient xlink:href="#b" id="c" x1="258.482" y1="216.75" x2="274.463" y2="228.764" gradientUnits="userSpaceOnUse" gradientTransform="translate(-126.195 -179.291)"></linearGradient>
        </defs>
        <symbol id="gv8" viewBox="0 0 53.303 29.502">
            <path d="M3.207 15.09A3.207 3.207 0 0 0 0 18.296v.002a3.207 3.207 0 0 0 3.21 3.205 3.207 3.207 0 0 0 3.204-3.209 3.207 3.207 0 0 0-3.207-3.205zm0 .744a2.463 2.463 0 0 1 2.463 2.461 2.463 2.463 0 0 1-2.461 2.464A2.463 2.463 0 0 1 .744 18.3v-.003a2.463 2.463 0 0 1 2.463-2.462zm2.767 5.538a2.932 2.932 0 0 0-2.93 2.931v.003a2.932 2.932 0 0 0 2.932 2.929 2.932 2.932 0 0 0 2.93-2.933 2.932 2.932 0 0 0-2.932-2.93zm0 .669a2.262 2.262 0 0 1 2.263 2.261 2.262 2.262 0 0 1-2.261 2.264 2.262 2.262 0 0 1-2.263-2.26v-.003a2.262 2.262 0 0 1 2.261-2.262zm5.145 2.433a2.514 2.514 0 0 0-2.513 2.514v.002a2.514 2.514 0 0 0 2.515 2.512 2.514 2.514 0 0 0 2.512-2.515 2.514 2.514 0 0 0-2.514-2.513zm0 .624a1.89 1.89 0 0 1 1.89 1.889 1.89 1.89 0 0 1-1.888 1.89A1.89 1.89 0 0 1 9.23 26.99v-.002a1.89 1.89 0 0 1 1.89-1.89zm5.001-.568a2.18 2.18 0 0 0-2.179 2.18v.002a2.18 2.18 0 0 0 2.18 2.177 2.18 2.18 0 0 0 2.179-2.18 2.18 2.18 0 0 0-2.18-2.179zm0 .555a1.624 1.624 0 0 1 1.625 1.624 1.624 1.624 0 0 1-1.623 1.625 1.624 1.624 0 0 1-1.626-1.623v-.002a1.624 1.624 0 0 1 1.624-1.624zm3.596-.86a1.27 1.27 0 0 0-1.27 1.27v.001a1.27 1.27 0 0 0 1.27 1.269 1.27 1.27 0 0 0 1.27-1.27 1.27 1.27 0 0 0-1.27-1.27zm0 .597a.674.674 0 0 1 .673.673.674.674 0 0 1-.673.674.674.674 0 0 1-.674-.673v-.001a.674.674 0 0 1 .674-.673zm1.836-1.915a.784.784 0 0 0-.784.784.784.784 0 0 0 .784.784.784.784 0 0 0 .784-.784.784.784 0 0 0-.784-.784zm0 .42a.363.363 0 0 1 .364.364.363.363 0 0 1-.364.364.363.363 0 0 1-.364-.363v-.001a.363.363 0 0 1 .364-.363zM8.606 2.514A2.514 2.514 0 0 1 11.119 0a2.514 2.514 0 0 1 2.515 2.513 2.514 2.514 0 0 1-2.513 2.515 2.514 2.514 0 0 1-2.515-2.512m9.761 1.495a1.27 1.27 0 0 1 1.269-1.27 1.27 1.27 0 0 1 1.27 1.27 1.27 1.27 0 0 1-1.269 1.27 1.27 1.27 0 0 1-1.27-1.269m2.401 1.82a.784.784 0 0 1 .784-.784.784.784 0 0 1 .784.783.784.784 0 0 1-.784.785.784.784 0 0 1-.784-.784m-6.8-3.014a2.18 2.18 0 0 1 2.178-2.18 2.18 2.18 0 0 1 2.18 2.179 2.18 2.18 0 0 1-2.178 2.18 2.18 2.18 0 0 1-2.18-2.178M3.043 5.253a2.932 2.932 0 0 1 2.931-2.931 2.932 2.932 0 0 1 2.932 2.93 2.932 2.932 0 0 1-2.93 2.933 2.932 2.932 0 0 1-2.933-2.93M0 11.232a3.207 3.207 0 0 1 3.206-3.207 3.207 3.207 0 0 1 3.208 3.206 3.207 3.207 0 0 1-3.205 3.208A3.207 3.207 0 0 1 0 11.235" fill="currentcolor"></path>
            <path d="M12.854.698a2.514 2.514 0 0 1 .328 1.236 2.514 2.514 0 0 1-2.512 2.515 2.514 2.514 0 0 1-1.736-.698 2.514 2.514 0 0 0 2.187 1.277 2.514 2.514 0 0 0 2.512-2.515 2.514 2.514 0 0 0-.78-1.815zm5.29 1.254a2.315 2.723 0 0 1-2.287 2.332 2.315 2.723 0 0 1-1.858-1.1 2.18 2.18 0 0 0 2.15 1.813 2.18 2.18 0 0 0 2.177-2.18 2.18 2.18 0 0 0-.183-.865zm-10.377.986a2.932 2.932 0 0 1 .61 1.785 2.932 2.932 0 0 1-2.93 2.933 2.932 2.932 0 0 1-1.795-.618 2.932 2.932 0 0 0 2.324 1.147 2.932 2.932 0 0 0 2.93-2.933 2.932 2.932 0 0 0-1.139-2.314zm13.052.611a1.73 1.795 0 0 1-1.542.988 1.73 1.795 0 0 1-.88-.251 1.27 1.27 0 0 0 1.24.995 1.27 1.27 0 0 0 1.269-1.27 1.27 1.27 0 0 0-.087-.462zm1.21 1.663a1.004 1.098 0 0 1-.98.87 1.004 1.098 0 0 1-.251-.037.784.784 0 0 0 .754.57.784.784 0 0 0 .783-.783.784.784 0 0 0-.306-.62zM5.201 8.725a3.207 3.207 0 0 1 .684 1.977A3.207 3.207 0 0 1 2.68 13.91a3.207 3.207 0 0 1-1.996-.699 3.207 3.207 0 0 0 2.525 1.228 3.207 3.207 0 0 0 3.205-3.208A3.207 3.207 0 0 0 5.2 8.725zm0 7.064a3.207 3.207 0 0 1 .684 1.977 3.207 3.207 0 0 1-.763 2.076 2.463 2.463 0 0 1-.41.403 3.207 3.207 0 0 1-2.032.73 3.207 3.207 0 0 1-1.996-.7 3.207 3.207 0 0 0 2.525 1.229 3.207 3.207 0 0 0 3.205-3.209A3.207 3.207 0 0 0 5.2 15.789zm2.566 6.2a2.932 2.932 0 0 1 .61 1.784 2.932 2.932 0 0 1-.216 1.1 2.262 2.262 0 0 1-1.621 1.619 2.932 2.932 0 0 1-1.093.214 2.932 2.932 0 0 1-1.795-.618 2.932 2.932 0 0 0 2.324 1.147 2.932 2.932 0 0 0 2.93-2.933 2.932 2.932 0 0 0-1.139-2.314zM22.03 23.07a1.004 1.098 0 0 1-.173.422.363.363 0 0 1 .06.198.363.363 0 0 1-.364.364.363.363 0 0 1-.288-.142 1.004 1.098 0 0 1-.215.028 1.004 1.098 0 0 1-.251-.037.784.784 0 0 0 .754.571.784.784 0 0 0 .783-.784.784.784 0 0 0-.306-.62zm-1.131 1.962a1.73 1.795 0 0 1-.536.649.674.674 0 0 1-.646.487.674.674 0 0 1-.426-.152 1.73 1.795 0 0 1-.813-.247 1.27 1.27 0 0 0 1.239.995 1.27 1.27 0 0 0 1.27-1.27 1.27 1.27 0 0 0-.088-.462zm-8.044.14a2.514 2.514 0 0 1 .328 1.235 2.514 2.514 0 0 1-.237 1.062 1.89 1.89 0 0 1-1.809 1.407 2.514 2.514 0 0 1-.466.046 2.514 2.514 0 0 1-1.736-.698 2.514 2.514 0 0 0 2.187 1.277 2.514 2.514 0 0 0 2.512-2.515 2.514 2.514 0 0 0-.78-1.815zm5.263.67a2.315 2.723 0 0 1-.404 1.182 1.624 1.624 0 0 1-1.592 1.31 1.624 1.624 0 0 1-.852-.244 2.315 2.723 0 0 1-1.296-1.016 2.18 2.18 0 0 0 2.149 1.814 2.18 2.18 0 0 0 2.177-2.18 2.18 2.18 0 0 0-.182-.866z" opacity=".2" fill-opacity=".997"></path>
            <path d="M37.89 9.924a2.295 2.295 0 0 0-2.299 2.3v.394c0 1.074.729 1.968 1.72 2.225a2.292 2.292 0 0 0-1.72 2.223v.394c0 1.275 1.026 2.3 2.3 2.3h9.092c1.274 0 2.3-1.025 2.3-2.3v-.394a2.292 2.292 0 0 0-1.72-2.223 2.293 2.293 0 0 0 1.72-2.225v-.393c0-1.275-1.026-2.3-2.3-2.3zm2.07 2.24h4.877c.684 0 1.234.367 1.234.824 0 .457-.55.825-1.234.825H39.96c-.683 0-1.234-.368-1.234-.825 0-.457.55-.824 1.234-.824zm-.33 3.714h5.454c.498 0 .9.328.9.735 0 .408-.402.736-.9.736h-5.455c-.498 0-.9-.328-.9-.736 0-.407.402-.735.9-.735z" fill="currentcolor"></path>
            <path transform="scale(.26458)" d="M143.209 37.51a8.673 8.673 0 0 0-8.691 8.693v1.488a8.666 8.666 0 0 0 6.5 8.407 8.663 8.663 0 0 0-6.5 8.404v1.49a8.673 8.673 0 0 0 8.691 8.694h20.541v-9.114h-13.97c-1.885 0-3.401-1.24-3.401-2.781 0-1.54 1.516-2.781 3.4-2.781h13.971v-7.803h-12.719c-2.584 0-4.664-1.39-4.664-3.117 0-1.728 2.08-3.117 4.664-3.117h12.719V37.51h-20.541z" fill="url(#c)"></path>
            <path d="M23.897 9.924l5.835 9.899h3.166l5.836-9.899L35 9.971l-3.686 6.349-3.686-6.349z" fill="currentcolor"></path>
            <path transform="translate(0 .06) scale(.26458)" d="M90.318 37.281l22.055 37.41h6.502V60.56l-.52.894-13.93-23.994z" fill="url(#d)"></path>
            <path d="M14.913 9.924a3.093 3.093 0 0 0-3.1 3.1v3.857c0 1.717 1.382 3.1 3.1 3.1H25.31v-5.546h-6.18v2.572h2.952v.485h-5.44a1.619 1.619 0 0 1-1.622-1.622v-2.018c0-.899.723-1.622 1.622-1.622h5.441v.005h.296c.028-.002.055-.005.084-.005h2.847V9.924z" fill="currentcolor"></path>
            <g style="line-height:1.25">
                <path d="M51.133 2.915q-.354 0-.658.128-.305.126-.56.381-.255.255-.383.56-.126.301-.126.658 0 .355.126.66.128.3.383.556.252.251.557.377.307.126.661.126.36 0 .662-.123.302-.126.557-.38.254-.255.38-.557.13-.304.13-.659 0-.357-.13-.659-.126-.304-.38-.559-.258-.258-.563-.383-.301-.126-.656-.126zm-.167.864h-.102v.606h.102q.229 0 .343-.076.117-.08.117-.232 0-.152-.114-.225-.111-.073-.346-.073zm.109-.405q.515 0 .77.176.255.173.255.527 0 .252-.155.416-.153.164-.434.214.12.064.223.181.105.117.19.287l.325.647h-.67l-.314-.623q-.111-.229-.196-.322-.085-.097-.17-.097h-.035v1.042h-.624V3.374zm.058-.91q.446 0 .83.16.386.162.705.481.32.32.477.703.158.383.158.834 0 .445-.158.83-.158.38-.477.699-.32.32-.706.48-.383.161-.829.161-.445 0-.831-.16-.384-.162-.703-.481-.32-.32-.477-.7-.158-.384-.158-.829 0-.45.158-.834.158-.384.477-.703.32-.32.703-.48.386-.161.831-.161z" style="-inkscape-font-specification:'sans-serif Bold'" font-weight="700" font-size="5.997" aria-label="®" font-family="sans-serif" letter-spacing="0" word-spacing="0" fill="currentcolor" stroke-width=".265"></path>
            </g>
            <g style="line-height:1.25">
                <path style="-inkscape-font-specification:'Segoe UI Historic'" d="M30.444 23.57a.888.888 0 0 0-.221.029.618.618 0 0 0-.192.084.442.442 0 0 0-.136.144.393.393 0 0 0-.052.206c0 .064.011.12.033.169.022.047.053.09.092.127a.729.729 0 0 0 .136.104c.052.031.108.062.169.093.057.029.11.056.159.083.05.026.093.053.129.082a.33.33 0 0 1 .084.094.231.231 0 0 1 .032.122.235.235 0 0 1-.093.2c-.061.046-.154.069-.279.069a1.051 1.051 0 0 1-.246-.04.88.88 0 0 1-.12-.05.47.47 0 0 1-.098-.066v.239a.37.37 0 0 0 .089.042 1.139 1.139 0 0 0 .578.031.574.574 0 0 0 .195-.08.404.404 0 0 0 .186-.36.38.38 0 0 0-.038-.171.486.486 0 0 0-.098-.136.807.807 0 0 0-.147-.112 2.267 2.267 0 0 0-.175-.097 5.629 5.629 0 0 1-.16-.082.735.735 0 0 1-.118-.077.287.287 0 0 1-.073-.088.254.254 0 0 1-.024-.114c0-.048.01-.088.032-.12a.262.262 0 0 1 .084-.082.365.365 0 0 1 .119-.044.621.621 0 0 1 .133-.015c.16 0 .29.035.392.106v-.228c-.078-.04-.202-.061-.372-.061zm-6.15.014a.888.888 0 0 0-.221.027.62.62 0 0 0-.192.085.442.442 0 0 0-.136.144.391.391 0 0 0-.052.205c0 .064.011.12.033.169.022.047.053.09.092.128a.73.73 0 0 0 .136.104c.052.03.108.062.169.093.057.028.11.056.159.083.05.025.093.052.129.081a.33.33 0 0 1 .084.094.234.234 0 0 1 .032.122.235.235 0 0 1-.093.2c-.061.046-.154.07-.279.07a1.046 1.046 0 0 1-.246-.04.882.882 0 0 1-.12-.051.47.47 0 0 1-.098-.065v.238a.384.384 0 0 0 .089.043 1.139 1.139 0 0 0 .578.032.574.574 0 0 0 .195-.08.405.405 0 0 0 .186-.361.377.377 0 0 0-.038-.171.488.488 0 0 0-.098-.136.807.807 0 0 0-.147-.113 2.268 2.268 0 0 0-.175-.096 5.716 5.716 0 0 1-.16-.082.736.736 0 0 1-.118-.077.287.287 0 0 1-.073-.088.254.254 0 0 1-.024-.115c0-.047.01-.087.032-.12a.26.26 0 0 1 .084-.081.366.366 0 0 1 .119-.045.621.621 0 0 1 .133-.014c.16 0 .29.035.392.106v-.228c-.078-.04-.202-.061-.372-.061zm11.742 0a.888.888 0 0 0-.221.027.62.62 0 0 0-.192.085.442.442 0 0 0-.136.144.391.391 0 0 0-.052.205c0 .064.011.12.033.169.022.047.053.09.092.128a.73.73 0 0 0 .136.104c.052.03.108.062.169.093.057.028.11.056.159.083.05.025.093.052.129.081a.33.33 0 0 1 .084.094.234.234 0 0 1 .032.122.235.235 0 0 1-.093.2c-.061.046-.154.07-.279.07a1.047 1.047 0 0 1-.246-.04.882.882 0 0 1-.12-.051.47.47 0 0 1-.098-.065v.238a.384.384 0 0 0 .089.043 1.139 1.139 0 0 0 .578.032.574.574 0 0 0 .195-.08.405.405 0 0 0 .186-.361.377.377 0 0 0-.038-.171.488.488 0 0 0-.098-.136.807.807 0 0 0-.147-.113 2.266 2.266 0 0 0-.175-.096 5.713 5.713 0 0 1-.161-.082.736.736 0 0 1-.117-.077.287.287 0 0 1-.073-.088.254.254 0 0 1-.024-.115c0-.047.01-.087.032-.12a.26.26 0 0 1 .084-.081.366.366 0 0 1 .119-.045.621.621 0 0 1 .132-.014c.16 0 .291.035.393.106v-.228c-.078-.04-.202-.061-.372-.061zm2.58 0a.888.888 0 0 0-.22.027.62.62 0 0 0-.192.085.444.444 0 0 0-.136.144.39.39 0 0 0-.052.205c0 .064.01.12.032.169.023.047.053.09.092.128a.733.733 0 0 0 .136.104c.053.03.108.062.169.093.057.028.11.056.159.083.05.025.093.052.13.081.035.029.063.06.083.094a.234.234 0 0 1 .032.122c0 .087-.03.154-.093.2-.06.046-.154.07-.278.07a1.046 1.046 0 0 1-.246-.04.89.89 0 0 1-.121-.051.469.469 0 0 1-.098-.065v.238a.388.388 0 0 0 .09.043 1.138 1.138 0 0 0 .577.032.574.574 0 0 0 .195-.08.406.406 0 0 0 .186-.361.377.377 0 0 0-.037-.171.488.488 0 0 0-.1-.136.803.803 0 0 0-.145-.113 2.291 2.291 0 0 0-.176-.096 5.568 5.568 0 0 1-.16-.082.74.74 0 0 1-.118-.077.288.288 0 0 1-.073-.088.254.254 0 0 1-.024-.115c0-.047.01-.087.032-.12a.262.262 0 0 1 .085-.081.363.363 0 0 1 .118-.045.622.622 0 0 1 .133-.014c.16 0 .29.035.393.106v-.228c-.078-.04-.202-.061-.373-.061zm9.79 0a.888.888 0 0 0-.22.027.62.62 0 0 0-.191.085.444.444 0 0 0-.137.144.39.39 0 0 0-.052.205c0 .064.011.12.033.169.022.047.053.09.091.128a.733.733 0 0 0 .137.104c.052.03.108.062.168.093.057.028.11.056.16.083.05.025.093.052.129.081a.35.35 0 0 1 .084.094c.02.035.031.076.031.122a.235.235 0 0 1-.093.2c-.06.046-.153.07-.278.07a1.054 1.054 0 0 1-.246-.04.884.884 0 0 1-.12-.051.469.469 0 0 1-.098-.065v.238a.388.388 0 0 0 .09.043 1.138 1.138 0 0 0 .578.032.571.571 0 0 0 .194-.08.406.406 0 0 0 .186-.361.377.377 0 0 0-.038-.171.488.488 0 0 0-.099-.136.803.803 0 0 0-.145-.113 2.29 2.29 0 0 0-.176-.096 5.568 5.568 0 0 1-.16-.082.74.74 0 0 1-.118-.077.288.288 0 0 1-.073-.088.254.254 0 0 1-.025-.115.22.22 0 0 1 .033-.12.26.26 0 0 1 .085-.081.366.366 0 0 1 .118-.045.617.617 0 0 1 .132-.014c.16 0 .291.035.394.106v-.228c-.078-.04-.203-.061-.373-.061zm-20.177.007v1.729h.916v-.184h-.714v-.605h.625v-.182h-.625v-.575h.675v-.183zm4.473 0v1.729h.917v-.184h-.714v-.605h.625v-.182h-.625v-.575h.675v-.183zm8.889 0v1.729h.917v-.184h-.715v-.605h.625v-.182h-.625v-.575h.676v-.183zm1.581 0v1.729h.195v-1.158c0-.156-.003-.27-.01-.339h.006c.018.08.035.139.051.178l.59 1.319h.099l.591-1.33c.015-.033.032-.089.052-.167h.005a4.085 4.085 0 0 0-.017.337v1.16h.201v-1.73h-.253l-.541 1.202c-.021.046-.05.117-.084.212h-.007a1.544 1.544 0 0 0-.08-.208l-.53-1.205zm3.091 0L45.6 25.32h.226l.172-.485h.733l.184.485h.224l-.666-1.73zm-19.93.012v.184h.498v1.545h.203v-1.545h.499v-.184zm13.393 0v.184h.498v1.545h.203v-1.545h.499v-.184zm-14.291.013v1.73h.202v-1.73zm11.71 0v1.73h.203v-1.73zm9.217.185h.005a.704.704 0 0 0 .027.115l.27.737h-.599l.27-.737a.658.658 0 0 0 .027-.115z" font-size="2.469" font-family="Segoe UI Historic" aria-label="S" font-weight="400" letter-spacing="0" word-spacing="0" fill="currentcolor" stroke-width=".265"></path>
            </g>
        </symbol>
        <symbol id="left-arrow" viewBox="0 0 492 492">
            <path d="M464.344 207.418l.768.168H135.888l103.496-103.724c5.068-5.064 7.848-11.924 7.848-19.124 0-7.2-2.78-14.012-7.848-19.088L223.28 49.538c-5.064-5.064-11.812-7.864-19.008-7.864-7.2 0-13.952 2.78-19.016 7.844L7.844 226.914C2.76 231.998-.02 238.77 0 245.974c-.02 7.244 2.76 14.02 7.844 19.096l177.412 177.412c5.064 5.06 11.812 7.844 19.016 7.844 7.196 0 13.944-2.788 19.008-7.844l16.104-16.112c5.068-5.056 7.848-11.808 7.848-19.008 0-7.196-2.78-13.592-7.848-18.652L134.72 284.406h329.992c14.828 0 27.288-12.78 27.288-27.6v-22.788c0-14.82-12.828-26.6-27.656-26.6z"></path>
        </symbol>
        <symbol id="search" viewBox="0 0 485.213 485.213">
            <path d="M363.909 181.955C363.909 81.473 282.44 0 181.956 0 81.474 0 .001 81.473.001 181.955s81.473 181.951 181.955 181.951c100.484 0 181.953-81.469 181.953-181.951zM181.956 318.416c-75.252 0-136.465-61.208-136.465-136.46 0-75.252 61.213-136.465 136.465-136.465 75.25 0 136.468 61.213 136.468 136.465 0 75.252-61.218 136.46-136.468 136.46zm289.926 89.151L360.567 296.243a214.267 214.267 0 0 1-64.331 64.321L407.56 471.888c17.772 17.768 46.587 17.768 64.321 0 17.773-17.739 17.773-46.554.001-64.321z" fill="currentcolor"></path>
        </symbol>
        <symbol id="send-button" viewBox="0 0 535.5 535.5">
            <path fill="currentcolor" d="M0 497.25l535.5-229.5L0 38.25v178.5l382.5 51-382.5 51z" id="send"></path>
        </symbol>
    </svg>
</div>
<!-- FIM SPRITES EM SVG-->
<noscript>
    <style>.noscript{position: sticky;top:0;z-index: 1200;background: #D32F2F;color: #FFF;padding: 20px;text-align: center}</style>
    <div class="noscript">
        <p class="h1">(&gt;_&lt;) Ops....</p>
        <p>Seu navegador está com os scripts desabilitados! Para ter uma melhor experiencia com o nosso site, por favor, habiliete-os.</p>
    </div>
</noscript>
<!--  [if lt IE 10]><style>.ie-message{position: sticky;top: 0;z-index: 1200;background: #FF9800;color: #FFF}</style><div class="ie-message"><p class="h1"><em>Atenção!!!</em></p><p>Seu navegador está desatualizado! Para ter uma melhor experiência com o nosso site, por favor atualize-o para a última versão do Microsoft Edge.</p></div><![endif]-->
<div id="app">
    <header class="topo">
        <div class="mobile-controls">
            <button class="btn" type="button" role="button" aria-label="MENU" data-toggle="menu">
                <i class="fas fa-bars"></i>
                <span class="sr-only">MENU</span>
            </button>


            <div class="brand">
                <?php if (!empty($logo)): ?>
                <a href="<?php echo URL_SITE.'home' ?>">
                    <img class="img-fluid" src="<?php echo $Conexao->generate_image_src('configuracoes',186,108,$logo,'redimencionar'); ?>" alt="Logo MaritatiKids" />
                </a>
                <?php endif; ?>
            </div>


            <button class="btn" type="button" role="button" aria-label="BUSCAS" data-toggle="search">
                <svg class="svg-icon">
                    <use xlink:href="#search"></use>
                </svg>
                <span class="sr-only">BUSCAS</span>
            </button>
        </div>
        <div class="main-topo">
            <div class="faixa-topo">
                <div class="content">
                    <div class="boas-vindas"><?=$frase_topo_site;?></div>
                    <ul class="dados-contato">

                        <?php if (!empty($primeira_opcao_de_telefone)): ?>
                        <li>
                            <a href="tel:<?php echo preg_replace('/\D/', '', $primeira_opcao_de_telefone) ?>">
                                <i class="fas fa-phone fa-flip-horizontal"></i>
                                <?=$primeira_opcao_de_telefone;?>
                            </a>
                        </li>
                        <?php endif; ?>


                        <?php if (!empty($e_mail)): ?>
                        <li>
                            <a href="mainto:<?=$e_mail;?>">
                                <i class="fas fa-envelope"></i>
                                <?=$e_mail;?>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                    <div class="redes-sociais">

                        <?php if (!empty($link_facebook||$id_do_instagram||$link_pinterest||$link_do_twitter)): ?>
                        <div class="title">Siga-nos:</div>
                        <?php endif; ?>

                        <div class="content">

                            <?php if (!empty($link_facebook)): ?>
                            <a class="fab fa-facebook-f" href="<?php echo $link_facebook ?>" target="_blank" title="Facebook"></a>
                            <?php endif; ?>
                            <?php if (!empty($id_do_instagram)): ?>
                            <a class="fab fa-instagram" href="http://instagram.com/<?php echo preg_replace('/[@]/ui', '', $id_do_instagram); ?>" target="_blank" title="Instagram"></a>
                            <?php endif; ?>
                            <?php if (!empty($link_pinterest)): ?>
                            <a class="fab fa-pinterest-p" href="<?php echo $link_pinterest ?>" target="_blank" title="Pinterest"></a>
                            <?php endif; ?>
                            <?php if (!empty($link_do_twitter)): ?>
                            <a class="fab fa-twitter" href="<?php echo $link_do_twitter ?>" target="_blank" title="Twitter"></a>
                            <?php endif; ?>

                        </div>


                    </div>



                </div>
            </div>
            <div class="nav-content">
                <div class="content">



                    <div class="brand">
                        <?php if (!empty($logo)): ?>
                        <a href="<?php echo URL_SITE.'home' ?>">
                            <img class="img-fluid" src="<?php echo $Conexao->generate_image_src('configuracoes',186,108,$logo,'redimencionar'); ?>" alt="Seu Logo" />
                        </a>
                        <?php endif; ?>
                    </div>



                    <ul class="menu">
                        <li <?php echo ($sistema=='home')?' class="active" ':'' ?>>
                            <a href="<?php echo URL_SITE.'home' ?>">HOME</a>
                        </li>
                        <?php $query = $Conexao->query('SELECT nome_do_menu,url FROM '.$_SESSION['LANG'].'paginas WHERE id IN (1,2,3)')->fetch();
                        if ($Conexao->affected_rows > 0):
                        foreach ($query as $index => $data):
                        extract($data);
                        if($index==0): ?>
                            <li <?php echo ($sistema==$url)?' class="active" ':'' ?>>
                                <a href="<?php echo URL_SITE.$url; ?>"><?php echo mb_convert_case($nome_do_menu, MB_CASE_UPPER, "UTF-8"); ?></a>
                            </li>
                        <?php else: ?>
                        <li <?php echo ($sistema==$url)?' class="active" ':'' ?>>
                            <a href="<?php echo URL_SITE.$url; ?>"><?php echo mb_convert_case($nome_do_menu, MB_CASE_UPPER, "UTF-8"); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php endforeach;
                        endif; ?>
                    </ul>



                    <div class="search">


                        <form action="<?php echo(URL_SITE).'buscar' ?>" method="POST">
                            <label class="sr-only" for="search"></label>
                            <div class="input-group">
                                <input class="form-control" type="search" name="pesquisa" id="pesquisa" placeholder="Buscar..." aria-label="Campo de busca" />
                                <button class="btn-search btn btn-search" aria-label="Botão Procurar">
                                    <span class="sr-only">Procurar</span>
                                    <svg class="svg-icon">
                                        <use xlink:href="#search"></use>
                                    </svg>
                                </button>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
        <div class="search-mobile">
            <form>
                <label for="search-mobile">O que está procurando?</label>
                <div class="input-group">
                    <input class="form-control" type="search" name="search" id="search-mobile" aria-label="Campo de Busca" />
                    <button class="btn-search btn btn-search" aria-label="Botão Procurar">
                        <span class="sr-only">Procurar</span>
                        <svg class="svg-icon">
                            <use xlink:href="#search"></use>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </header>