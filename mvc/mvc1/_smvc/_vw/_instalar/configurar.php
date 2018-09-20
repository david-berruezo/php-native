<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SIMPLE | Configurações</title>
<link type="text/css" href="<?=URL?>css/jquery/jquery.css" rel="stylesheet" />
<link href="<?=URL?>css/instalar/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=URL?>js/jquery.js"></script>
<script type="text/javascript" src="<?=URL?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?=URL?>js/instalar/instalar.js"></script>
</head>
<body>
<div class="smvc_conteudo">
<div id="logo"><img src="<?=URL?>img/instalar/simplem.png"/>
  <div>PHP model-view-controller framework</div>
</div>

<h1>Configurações</h1>
<p>Aqui est&atilde;o as configura&ccedil;&otilde;es 'default' do Simple que voc&ecirc; pode modificar utilizando o formul&aacute;rio abaixo ou editando diretamente o arquivo <b>config.xml</b> que se encontra na mesma pasta do core do Simple ( normalmente em: _smvc/config.xml ).</p>
<p>Na aba &quot;Banco de Dados&quot; voc&ecirc; pode criar e configurar as classes de conex&atilde;o e controle de acesso aos bancos de dados. N&atilde;o esque&ccedil;a de criar as classes respectivas para os conectores (drivers) criados.</p>
<p>Veja o manual para mais detalhes (se&ccedil;&atilde;o &quot;banco de dados&quot;).</p>
<form action="<?=URL?>instalar/index" method="post">
  <div id="tabs">
  <ul>
    <li><a href="#basico">Básico</a></li>
    <li><a href="#bancodedados">Banco de Dados</a></li>
  </ul>
  <div id="basico"  style="height:320px">
    <div class="smvc_esquerdo">
      <label>* Url do site</label>
      <br />
      <input name="url" type="text" id="url" value="<?=URL?>" size="39" />
      <br />
      <label>Sub-pasta (se não estiver na raiz do site)</label>
      <br />
      <input name="noway" type="text" id="noway" value="<?=$this->cfg->no_uri?>" size="39" />
      <br />
      <label>* Pasta do site no servidor</label>
      <br />
      <input name="path" type="text" id="path" value="<?=$this->cfg->path?>" size="39" />
      <br />
      <label>Pasta do Simple</label>
      <br />
      <input name="pasta_simple" type="text" id="pasta_simple" value="<?=$this->cfg->core_path?>" size="39" />
      <br />
      <label>Core do Simple</label>
      <br />
      <input name="core" type="text" id="core" value="<?=$this->cfg->core?>" size="39" />
      <p>* Estes campos n&atilde;o precisam ser preenchidos. Ser&atilde;o definidos pelo pr&oacute;prio Simple durante a inicializa&ccedil;&atilde;o.</p>
    </div>
    
    <div class="smvc_direito">
      <label>Controller default</label>
      <br />
      <input name="controller" type="text" id="controller" value="<?=$this->cfg->default->ctrl?>" size="39" />
      <br />
      <label>Função default</label>
      <br />
      <input name="function" type="text" id="function" value="<?=$this->cfg->default->func?>" size="39" />
      <br />
      <label>Pasta dos VIEWS</label>
      <br />
      <input name="views" type="text" id="views" value="<?=$this->cfg->view?>" />
      <br />
      <label>Pasta dos CONTROLLERS</label>
      <br />
      <input name="controllers" type="text" id="controllers" value="<?=$this->cfg->ctrl?>" />
      <br />
      <label>Pasta dos MODELS</label>
      <br />
      <input name="models" type="text" id="models" value="<?=$this->cfg->model?>" />
      <br />
      <label>Pasta LIBRARY (Biblioteca de Classes)</label>
      <br />
      <input name="library" type="text" id="library" value="<?=$this->cfg->library?>" />
      <br />
      <label>Pasta dos 'drivers' de Banco de Dados</label>
      <br />
      <input name="bd" type="text" id="bd" value="<?=$this->cfg->db->drv?>" />
    </div>
    <br />
    <div class="smvc_botoes"><input name="" type="submit" value=" Salvar "  class="ui-state-default ui-corner-all" /></div>
  </div>
    
    <div id="bancodedados" style="height:300px">
      
      <div class="smvc_esquerdo">
      <label>Driver do Banco de Dados</label>
      <br />
      <select name="drive_bd" id="drive_bd">
        <option value="mysql" selected="selected">MySql</option>
        <option value="oracle">Oracle</option>
      </select>
      <br />
      <label>
        <input name="db_active" type="checkbox" value="" class="check" />
        Carregar automáticamente</label>
      <br />
      <br />
      <label>Host </label>
      <br />
      <p>algo como: &quot;localhost&quot; ou a string de conex&atilde;o [oracle]</p>
      <textarea name="db_host" cols="40" rows="2">localhost</textarea>
      <br />
      <label>Usu&aacute;rio</label>
      <br />
      <input name="user_bd" type="text" id="user_bd" value="root" size="40" />
      <br />
      <label>Senha</label>
      <br />
      <input name="senha_bd" type="text" id="senha_bd" value="123456" size="40" />
      <br />
      <label>CharSet</label>
      <br />
      <input name="charset_bd" type="text" id="charset_bd" value="ISO-8859-1" size="40" />
      <br />
      <div class="smvc_botoes"><input name="" type="submit" value=" Salvar "  class="ui-state-default ui-corner-all" /></div>
    </div>
    
    <div class="smvc_direito">
    <h2>Novo Driver</h2>
    <br />
      <label>Nome</label>
      <br />
      <input name="db_novo_nome" type="text" id="db_novo_nome" value="" size="40" />
      <br />
      <label>Host </label>
      <br />
      <p>algo como: &quot;localhost&quot; ou a string de conex&atilde;o [oracle]</p>
      <textarea name="db_host" cols="40" rows="2">localhost</textarea>
      <br />
      <label>Usu&aacute;rio</label>
      <br />
      <input name="user_bd" type="text" id="user_bd" value="" size="40" />
      <br />
      <label>Senha</label>
      <br />
      <input name="senha_bd" type="text" id="senha_bd" value="" size="40" />
      <br />
      <label>CharSet</label>
      <br />
      <input name="charset_bd" type="text" id="charset_bd" value="" size="40" />
      <div class="smvc_botoes"><input name="" type="submit" value=" Criar "  class="ui-state-default ui-corner-all" /></div>
    </div>
  </div>
</div>
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