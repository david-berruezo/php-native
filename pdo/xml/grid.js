var selecionado;

function seleciona(el)
{
selecionado=el.id;
}

function butonaction(el)
{
if(!selecionado)
 {
  alert('Por favor, selecione um registro clicando com o botão do mouse.');
  return false;
  }
el.value=el.value+'&selecionado='+selecionado;
location = el.value;
}