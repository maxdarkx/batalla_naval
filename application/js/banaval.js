var base_url="/banaval";
var numpos=0;
var MAXPOS=6;
var posiciones=[];

$( document ).ready(inicializar);

function inicializar()
{
	$("#tblpos").on('click','.tdpos',guardarPosicion);
	$("#frmpos").on('submit',continuar);
}


function guardarPosicion(event)
{
	var pos=event.target.id.substring(3);
	posiciones.push(pos);
	$("#td_"+pos).css('background','yellow');
	numpos++;
	if(numpos==MAXPOS){
		$("#btnseguir").prop('disabled',false);		
	}
	//parametros={url:base_url+'/posiciones/guardar/'+pos,method:'get',data:'',type:'json',processRpta:procesarGuardarPosicion};
	//enviarSolicitudAjax(parametros);
}

function continuar()
{
	for(i in posiciones){
		$("#frmpos").append("<input type='hidden' name='posiciones["+i+"]' value='"+posiciones[i]+"'>");
	}
	return true;
}

/*function procesarGuardarPosicion(data)
{
	if(data.status=='OK'){
		
		
	}
}

function enviarSolicitudAjax(parametros)
{
	var request = $.ajax({
  							url: parametros.url,
  							type: parametros.method,
  							data: parametros.data,
  							dataType: parametros.type
					});
	request.done(parametros.processRpta);
	request.fail(function( jqXHR, textStatus ) {
  					alert( "Request failed: " + textStatus );
				});

}*/