<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" href="<?=URL?>css/jquery/jquery.css" rel="stylesheet" />
<link href="<?=URL?>css/instalar/css.css" rel="stylesheet" type="text/css" />	
<script type="text/javascript" src="<?=URL?>js/jquery.js"></script>
<script type="text/javascript" src="<?=URL?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?=URL?>js/instalar/instalar.js"></script>	

<title>SIMPLE | Manual</title>
</head>

<body>
<div class="smvc_conteudo">

<div id="logo"><img src="<?=URL?>img/instalar/simplem.png"/><div>PHP model-view-controller framework</div></div>

<div id="conteudo">
<h1>Como funciona</h1>
<p align="center"><img src="<?=URL?>img/instalar/grafico.png" width="600" height="300" /></p>
<p>No gr&aacute;fico acima podemos ver a simplicidade deste sistema. O arquivo index.php &eacute; a &uacute;nica porta de entrada e referencia para todos os controllers.</p>
<p>O Core do sistema &eacute; carregado a partir deste arquivo (index) assim como o arquivo de configura&ccedil;&otilde;es &eacute; lido usando as fun&ccedil;&otilde;es de manipula&ccedil;&atilde;o de extruturas xml do Php.</p>
<p>Em seguida o controller solicitado pela url ou default &eacute; carregado. Este controller (criado pelo usu&aacute;rio - voc&ecirc;!) 'extends' a super-classe SMVC atrav&eacute;s da qual todos os recursos necess&aacute;rios ser&atilde;o 'montados' e disponibilizado ao controller do usu&aacute;rio.</p>
<p>Qualquer classe, driver, model ou mesmo outro controller podem ser chamados e ser&atilde;o carregados autom&aacute;ticamente pelo sistema sem a necessidade de includes, requares, etc. Tudo funciona de forma autom&aacute;tica e transparente facilitando a vida do programador. Qualquer classe que voc&ecirc; queira adicionar ao sistema basta coloca-la numa das pastas do sistema (por default &quot;_lbr&quot; ou &quot;_drv&quot;) e o smvc caregar&aacute; autom&aacute;ticamente.</p>
<p>Se voc&ecirc; gostou da id&eacute;ia ajude a desenvolver >>> <a href="http://smvc.tk">http://smvc.tk</a> | <a href="mailto:prbr@ymail.com">prbr@ymail.com</a></p>

<div class="top_menu">
<ul class="menu">
            <li class="top"><a class="top_link" href="<?=URL?>"><span>Inicio</span></a></li>
            <li class="top"><a class="top_link"><span>Manual</span></a>
                <ul class="sub">
                    <li><a href="<?=URL?>instalar/manual">Como Funciona</a></li>			
                    <li><a href="<?=URL?>instalar/manual">O que &eacute; MVC</a></li>
                    <li><a href="<?=URL?>instalar/manual">Controllers, models e views</a></li>
                    <li><a href="<?=URL?>instalar/manual">Tudo &eacute; Orientado a Objeto?</a></li>
                    <li><a href="<?=URL?>instalar/manual">Banco de Dados</a></li>
                    <li><a href="<?=URL?>instalar/manual">Funções de Apoio</a></li>
                    <li><a href="<?=URL?>instalar/manual">Classes disponíveis</a></li>
                    <li><a class="sep"></a></li>
                    <li><a href="<?=URL?>instalar/manual">Ajuda no Site</a></li>
                </ul>
            </li>
            <li class="top"><a class="top_link" href="<?=URL?>instalar/criar"><span>Criar</span></a></li>
            <li class="top"><a class="top_link" href="<?=URL?>instalar/configurar"><span>Configurar</span></a></li>
        </ul>
</div>

</div>
</body>
</html>