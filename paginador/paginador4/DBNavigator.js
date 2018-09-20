function evalJavascriptCode(html)
{
	var a=0;
	var b=0;

	do 
	{		
		a=html.indexOf('<script type="text/javascript">',b)+31;
		if (a==30) break;

		b=html.indexOf("</script>",a);
		javaScript=html.substring(a,b);
		
		javaScript=javaScript.replace('<!-','!-<'); //inverto (per xhtml non posso scrivere il commento)
		javaScript=javaScript.replace('->','>-'); //inverto (per xhtml non posso scrivere il commento)
		
		javaScript=javaScript.replace('->-','');
		javaScript=javaScript.replace('!-<-',''); 			

		javaScript=javaScript.replace('<!-','!-<'); //ripristino quelli erroneamente convertiti
		javaScript=javaScript.replace('>-','->'); //ripristino quelli erroneamente convertiti


		//alert(javaScript);
		eval(javaScript);
	}
	while (true)		

}

handlemousemove=function(e)
{	
	if (!document.getElementById('img_loading_dbn') )
	{
		//creazione immagine di caricamento
		img=document.createElement('img');
		img.src = imagesAndScriptsPath + 'loading.gif';

		img.id='img_loading_dbn';
		img.style.position='absolute';
		img.style.display='none';			
		img.style.border='3px solid #666';
		document.body.appendChild(img);
	}
	
	if (!e) var e = window.event;
	
			
	if (e.pageX || e.pageY) 	
	{
		document.getElementById('img_loading_dbn').style.left = (e.pageX - 55)+'px';
		document.getElementById('img_loading_dbn').style.top = (e.pageY - 55)+'px';
	}
	else if (e.clientX || e.clientY) 	
	{	
		document.getElementById('img_loading_dbn').style.left = (e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft-55)+'px';
		document.getElementById('img_loading_dbn').style.top = (e.clientY + document.body.scrollTop  + document.documentElement.scrollTop - 55)+'px';
	}
}	
	

function DBNavigator(instanceName,originalPrimaryTable)
{
	oThis=this;
	
	this.checkAvailability=0;	
	this.orderInfoGet='';
	this.searchInfoGet='';
	this.selectionInfoGet='';
	this.originalPrimaryTable=originalPrimaryTable;
	this.instanceName=instanceName;
	
	this.http=false; 
	this.zhttp=false; 
	
	this.defaultCallBackFunction=function()
							  	 {
									 document.getElementById(oThis.originalPrimaryTable+'_anchor').innerHTML=oThis.http.responseText;
								 };
	
	
	href=location.href;

	if (href.indexOf('#')!=-1)
	href=href.substr(0,href.indexOf('#'));
	
	if (href.indexOf('?')==-1) href=href+'?';


	this.location=href;

	commonRegExpString="((%5B|\\[)\\d*(\\]|%5D))?=?([^&?=])*($|&|#)";
	
	this.selectionInfoGet+= this.getInfoFromLocation(new RegExp("selected_"+this.originalPrimaryTable+commonRegExpString,"g"));
	this.selectionInfoGet+= this.getInfoFromLocation(new RegExp("sellen_"+this.originalPrimaryTable+commonRegExpString,"g"));
	this.selectionInfoGet+= this.getInfoFromLocation(new RegExp("action_"+this.originalPrimaryTable+commonRegExpString,"g"));
	this.selectionInfoGet+= this.getInfoFromLocation(new RegExp("del_"+this.originalPrimaryTable+"=(\\d+)","g"));
	this.selectionInfoGet+= this.getInfoFromLocation(new RegExp("edit_"+this.originalPrimaryTable+"=(\\d+)","g"));
	
	this.orderInfoGet+= this.getInfoFromLocation(new RegExp("ord_"+this.originalPrimaryTable+commonRegExpString,"g"));
	this.orderInfoGet+= this.getInfoFromLocation(new RegExp("desc_"+this.originalPrimaryTable+commonRegExpString,"g"));

	this.searchInfoGet+= this.getInfoFromLocation(new RegExp("([a-z]|[A-Z]|\\.|\\-|\\d|_)+_src_"+this.originalPrimaryTable+commonRegExpString,"g"));


}

DBNavigator.prototype.getInfoFromLocation = function (regexp) //toglie get dalla location e li passa per le variabili di istanza
{
	get='';
	
	arr=this.location.match(regexp);	
	if (arr!=null)
	for(i=0;i<arr.length;i++)
	{
		get+='&'+arr[i];
		//alert(arr[i]);
	}
	
	this.location=this.location.replace(regexp,'');
	
	return get;


}

DBNavigator.prototype.getAjaxUrl = function ()
{
	result=this.location;
	
	result+='&'+this.selectionInfoGet;
	result+='&'+this.orderInfoGet;
	result+='&'+this.searchInfoGet;
	
	result+='&ajaxCall_'+this.originalPrimaryTable; //aggiunge il get che identifica la chiamata ajax
	result=result.replace(/&&/g,'&');
	//alert(result);
	return result;
}

DBNavigator.prototype.createHttpRequest = function (getAppend,callBackFunction) ///crea una richiesta http con immagine che segue il mouse
{
	oThis=this;
	
	if (this.http!==false) //non la prima volta
	{
		this.http.onreadystatechange=function(){}; //vanifica (ma non abortisce) la richiesta impostandola per non eseguire nessuna azione al completamento
		this.http.abort(); //non funziona bene
	}
	
	this.http=zXmlHttp.createRequest();


	href=this.getAjaxUrl()+getAppend;
	
	//alert(href);
	
	if (document.getElementById('img_loading_dbn'))
	document.getElementById('img_loading_dbn').style.display='block';			
	else
	document.body.style.cursor='wait';
	
	this.http.open('get',href); 
	
	//http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	this.http.onreadystatechange=function()
							{
								if (oThis.http.readyState==4) 
								{
									//if (oThis.http.status == 200) 
									//{
										//alert(oThis.http.statusText);
										if (document.getElementById('img_loading_dbn')) 
										document.getElementById('img_loading_dbn').style.display='none';
										document.body.style.cursor='auto';
									
										callBackFunction();
										evalJavascriptCode(oThis.http.responseText);     
										
									//}
									//else oThis.createHttpRequest(getAppend,callBackFunction);										
								}
							};			
	this.http.send(null);
}
	
DBNavigator.prototype.createHttpRequest2 = function (getAppend,callBackFunction) //richiesta http senza immagine
{
	oThis=this;

	if (this.zhttp!==false) //non la prima volta
	{
		this.zhttp.onreadystatechange=function(){}; //vanifica (ma non abortisce) la richiesta impostandola per non eseguire nessuna azione al completamento
		this.zhttp.abort(); //non funziona bene
	}
	
	this.zhttp=zXmlHttp.createRequest();

	href=this.getAjaxUrl()+getAppend;
			
	this.zhttp.open('get',href); 
	//zhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	this.zhttp.onreadystatechange=function()
							{
								if (oThis.zhttp.readyState==4) 
								{
									//if (zhttp.status == 200) 
									//{
										callBackFunction(); 
									//}
									//else oThis.createHttpRequest2(getAppend,callBackFunction);										
								}
							};
		
	this.zhttp.send(null);		

}	


////////////////////

DBNavigator.prototype.reloadPage = function ()	
{
	this.createHttpRequest('',this.defaultCallBackFunction);
}

	
DBNavigator.prototype.manage_record_availability_for_editing = function (id,isFree)		
{
	oThis=this;
	
	if (typeof(id)=='object') //array
	{
		getAppend='&bookRecord&rand='+Math.floor(Math.random()*20);
		for (i=0;i<id.length;i++)
		getAppend+='&manage_record_availability[]='+id[i];
	}
	else if (typeof(id)=='number') getAppend='&manage_record_availability='+id+'&bookRecord&rand='+Math.floor(Math.random()*20);
	
	if (!isFree)
	callBackFunction=function()
					 {
						var reply=oThis.zhttp.responseText.substr(oThis.zhttp.responseText.length-6,oThis.zhttp.responseText.length);	
						
						if (reply=='!!!!!!') 	// se il record si e' liberato 
						{
							clearInterval(oThis.checkAvailability);
							
							oThis.reloadPage(); // aggiorna la pagina (ed entra in modifica) non funge l'ancora....		
						}

					 };
	else callBackFunction=function(){};	


	this.createHttpRequest2(getAppend,callBackFunction);
				
}	

////////////////////

DBNavigator.prototype.buildForm = function (id)	
{
	oThis=this;
	
	this.selectionInfoGet='&edit_'+this.originalPrimaryTable+'='+id;
	
	this.createHttpRequest('',this.defaultCallBackFunction);

}

DBNavigator.prototype.delete_ = function (id)
{
	oThis=this;
	this.selectionInfoGet='&del_'+this.originalPrimaryTable+'='+id;

	this.createHttpRequest('',this.defaultCallBackFunction);
}	



DBNavigator.prototype.set_order = function (field,asc)
{	
	oThis=this;	
	this.orderInfoGet='&ord_'+this.originalPrimaryTable+'='+field+'&desc_'+this.originalPrimaryTable+'='+(asc?'':'DESC');
	
	this.createHttpRequest('',this.defaultCallBackFunction);			
}

DBNavigator.prototype.getMultipleOperationParams = function (data)
{
	param='&sellen_'+this.originalPrimaryTable+'='+data.selected.length
	   +'&action_'+this.originalPrimaryTable+'='+data.action;
	
	for(i=0;i<data.selected.length;i++)
	param+='&selected_'+this.originalPrimaryTable+'[]='+data.selected[i];

	return param;

}

DBNavigator.prototype.multipleOperation = function (data)	
{
	oThis=this;
	this.selectionInfoGet=this.getMultipleOperationParams(data);

	this.createHttpRequest('',this.defaultCallBackFunction);
}



DBNavigator.prototype.printTable = function ()	
{
	oThis=this;	
	clearInterval(this.checkAvailability);
	
	this.selectionInfoGet='';

	
	this.createHttpRequest('',this.defaultCallBackFunction);
				
}

DBNavigator.prototype.search_ = function ()	
{

	oThis=this;	
	srcForm=document.getElementById('src_'+this.originalPrimaryTable);
	
	this.searchInfoGet='';
	this.orderInfoGet=''; //resetta l'ordinamento per le ricerche fulltext che si ordinano da sole
	this.selectionInfoGet='';

	for(i=0;i<srcForm.elements.length;i++)	
	{
		if (srcForm.elements[i].type=='select-multiple')
		{
			for(j=0;j<srcForm.elements[i].length;j++)
			{
				if (srcForm.elements[i].options[j].selected) 
				this.searchInfoGet+='&'+srcForm.elements[i].name+'='+encodeURIComponent(srcForm.elements[i].options[j].value);
				
			}
		}
		else			
		if (srcForm.elements[i].value!='') this.searchInfoGet+='&'+srcForm.elements[i].name+'='+encodeURIComponent(srcForm.elements[i].value);
	}

	this.createHttpRequest('',this.defaultCallBackFunction);
	
	return false;
				
}			
					