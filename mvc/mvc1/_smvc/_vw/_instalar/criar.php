<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SIMPLE | Criar Arquivo</title>
<link type="text/css" href="<?=URL?>css/jquery/jquery.css" rel="stylesheet" />
<link href="<?=URL?>css/instalar/css.css" rel="stylesheet" type="text/css" />	
<script type="text/javascript" src="<?=URL?>js/jquery.js"></script>
<script type="text/javascript" src="<?=URL?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?=URL?>js/instalar/instalar.js"></script>		
</head>					   
<body>
<div class="smvc_conteudo">
<div id="logo"><img src="<?=URL?>img/instalar/simplem.png"/><div>PHP model-view-controller framework</div></div>
<h1>Criar Arquivo</h1>
<p>No quadro abaixo voc&ecirc; pode criar um novo controller, model e at&eacute; view. </p>
<p>Neste &uacute;ltimo caso (view) existem alguns recursos a mais. </p>
<p>O Smvc criar&aacute; autom&aacute;ticamente os links para o Jquery, Jquery-UI al&eacute;m de 'linkar' e criar os arquivos CSS e JavaScript, nas respectivas pastas e com o mesmo nome do view. Al&eacute;m disso voc&ecirc; pode especificar um tamanho e tipo de alinhamento para a sua view e o Smvc criar&aacute; os par&acirc;metros necess&aacute;rios no CSS e na view. E n&atilde;o esque&ccedil;a de indicar algumas 'meta tags' e 'descri&ccedil;&atilde;o' para que os servi&ccedil;os de busca achem sua p&aacute;gina com mais facilidade.</p>
<form action="<?=URL?>instalar/index" method="post">
  <div id="tabs">
	<ul>
		<li><a href="#controller">Controller</a></li>
		<li><a href="#model">Model</a></li>
		<li><a href="#view">View</a></li>
	</ul>
<div id="controller">
<label><input name="c_controller" type="checkbox" value="" checked class="check" /> Criar Controller </label><br />
  <br />
<label>Nome (sem a extensão)</label><br />
<input name="c_nome" type="text" value="inicial" size="50" /><br />
<label>Funções (separadas por vírgula)</label><br />
<textarea name="c_funcoes" cols="47" rows="3">index(),</textarea>
<br />
  <p>O nome n&atilde;o deve conter a extens&atilde;o ('.php', '.html', etc) pois o Smvc colocar&aacute; a extens&atilde;o autom&aacute;ticamente.</p>
  <p>As fun&ccedil;&otilde;es devem ser separadas por v&iacute;rgulas e seus argumentos podem ser digitados tamb&eacute;m:</p>
  <p>&nbsp;</p>
  <blockquote>
    <p>Ex.: index($arg1=&quot;&quot;, $arg2= array()), outra_funcao(), </p>
  </blockquote>
  <p>&nbsp;</p>
</div>    
<div id="model">
<label><input name="m_model" type="checkbox" value="" checked class="check" /> Criar Model </label><br />
  <br />
<label>Nome (sem a extensão)</label><br />
<input name="m_nome" type="text" value="inicial" size="50" /><br />
<label>Funções (separadas por vírgula)</label><br />
<textarea name="m_funcoes" cols="47" rows="3">index(), select(), delete(), insert(), update()</textarea>
<br />
  <p>O NOME n&atilde;o deve conter a extens&atilde;o ('.php', '.html', etc) pois o Smvc colocar&aacute; a extens&atilde;o autom&aacute;ticamente.</p>
  <p>As FUN&Ccedil;&Otilde;ES devem ser separadas por v&iacute;rgulas e seus argumentos podem ser digitados tamb&eacute;m:</p>
  <p>&nbsp;</p>
  <blockquote>
    <p>Ex.: index($arg1=&quot;&quot;, $arg2= array()), outra_funcao(), </p>
  </blockquote>
  <p>&nbsp;</p>
</div>
<div id="view">
<div class="smvc_esquerdo">
<label><input name="v_view" type="checkbox" value="" checked class="check" /> Criar View </label><br />
  <br />
<label>Nome (sem a extensão)</label><br />
<input name="v_nome" type="text" value="inicial" size="50" /><br />
<label>Título da Página</label><br />
<input name="v_titulo" type="text" value="Título" size="50" /><br />
<label>Descrição</label><br />
<textarea name="v_descricao" cols="47" rows="2">Criado com o Simple MVC - http:\\www.smvc.tk</textarea><br />
<label>Meta Tags (key words)</label><br />
<textarea name="v_metatags" cols="47" rows="2">smvc, php, simple, model, controller, view, etc...</textarea><br />
  </div>
  
  <div class="smvc_direito">
  <h2>Outros Recursos</h2>
  <label><input name="v_jquery" type="checkbox" value="" checked class="check"> 
  Jquery </label>
  <br />
  <label><input name="v_jquery-ui" type="checkbox" value="" checked class="check" /> Jquery-UI </label><br />
  <label><input name="v_javascript" type="checkbox" value="" checked class="check" /> JavaScript </label><br />
  <label><input name="v_css" type="checkbox" value="" checked class="check" /> CSS </label><br />
  <br />
    
    Alinhamento da página <select name="v_alinhamento" class="check">
  <option value="0">n&atilde;o alinhar</option>
  <option value="1">direita</option>
  <option value="2">esquerda</option>
  <option value="3" selected="selected">centro</option>
</select><br /><br />
Tamanho da página 
<input name="v_tamanho_valor" type="text" class="check" value="800" size="5" maxlength="5" />  
  <select name="v_tamanho" class="check">
  <option value="0">não</option>
  <option value="1">%</option>
  <option value="2" selected="selected">px</option>
</select><br />
  </div><!--Fim smvc_direito-->
  </div><!--Fim tab View-->
    
  </div><!--Fim Tabs-->

<div class="smvc_botoes"><input name="" type="submit" value="Criar"  class="ui-state-default ui-corner-all" /> <- clique para criar os arquivos (controller, model e view que estiverem marcados).</div>
</form>

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