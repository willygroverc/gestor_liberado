// JavaScript Document

function ventanaModal(url) {
window.open(url,'name','height=650,width=900,toolbar=no,directories=no,status=no, linemenubar=yes,scrollbars=yes,resizable=no ,modal=yes');
/*
if (window.showModalDialog) {
window.showModalDialog(url,'',
"dialogWidth:900px;dialogHeight:600px;resizable:off");
} else {
//window.open(url,'name','height=600,width=900,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
window.open(url,'name','height=600,width=900,toolbar=no,directories=no,status=no, linemenubar=no,scrollbars=no,resizable=no ,modal=no');
}
*/
}

function cerrarOrdenesDeTrabajo() {

      var tr = document.getElementById('tblOrdenes').rows;
      var td = null;
      //a partir de la fila 3
      var j=1;

	  
      for (var i = 3; i < tr.length; ++i) {
        // Do whatever you want with each ROW here.
        td = tr[i].cells;

        if(document.getElementById("ch_"+j).checked)
            {
                llamarAjax(td[0].innerHTML);

                //alert("ch_"+j);
            }
        j=j+1;



        //alert(td[0].innerHTML);
        //for (var j = 0; j < td.length; ++j) {
          // Do whatever you want for each CELL here.
          //alert(td[j].innerHTML);
        //}
      }
     window.location.reload(false); //refresh
    }
function invitarComite(id_agenda) {

                
                var id_comite=document.getElementById('idcomite').value;
                
                ejecutarInvitacion(id_agenda,id_comite);
                window.location.reload(false); //refresh
    }
function ejecutarInvitacion(id_agenda,id_comite)
{

    try{
        

	var url="agregar_invitados_comite.php?id_agenda="+id_agenda+"&id_comite="+id_comite; //arcivo php y el paar de dato
        url= url + "&rando=" + parseInt(Math.random()*999999999999999);
	miPeticion.open("GET",url,true);//metodo, el archivo , modo asincronico
	//+new Date.getTime() fecha y hora
	miPeticion.onreadystatechange=respuestaAjax; //cuando el estatus del servidor vaya cambiando
	//funcion que se llamara cuando la conversacion con elk servidor baya teniendo cambios
	miPeticion.send(null);//envio del contenido de datos
	//envio de la peticion null:l a informacion va en el url
	}catch(error)
	{
	   alert(error);
    }
}


function getXMLHTTPRequest()
{
	var req=false;
	try
	{
		req=new XMLHttpRequest(); //p.e. Firefox
	}
	catch(err01)
	{
		try
		{
			req=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(err02)
		{
			try
			{
				req=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(err03)
			{
				req=false;
			}

		}
	}
	return req; //retornamos el objeto HTTPRequest
}
var miPeticion=getXMLHTTPRequest(); //creamos el objeto XMLHTTPRequest
//inicio de conversacion
function llamarAjax(idOrden)
{

    try{

	var url="cerrar_ordenes.php?idOrden="+idOrden; //arcivo php y el paar de dato
        url= url + "&rando=" + parseInt(Math.random()*999999999999999) ;
	miPeticion.onreadystatechange=respuestaAjax; //cuando el estatus del servidor vaya cambiando
	miPeticion.open("GET",url,true);//metodo, el archivo , modo asincronico
	//+new Date.getTime() fecha y hora
	
	//funcion que se llamara cuando la conversacion con elk servidor baya teniendo cambios
	miPeticion.send(null);//envio del contenido de datos
	//envio de la peticion null:l a informacion va en el url
	}catch(error)
	{
	   alert(error);
    }
}
function respuestaAjax() //funcion que monitorea el status de la conversacion
{		 
	if(miPeticion.readyState==4) //estado de la conversacion
	{
	    // document.getElementById("esperando").innerHTML="";
		if(miPeticion.status==200) //estado vlido de pagina
		{
			/*
                        var nodohora=miPeticion.responseXML.getElementsByTagName("hora")[0];
			var Textohora=nodohora.childNodes[0].nodeValue;
                        document.getElementById("hora").innerHTML=Textohora;
                        */

		}
		else
		{
		alert("el error status " + miPeticion.status);

		}
	}
	else
    {
       // document.getElementById("esperando").innerHTML="<img src='anim.gif'>";
    }
}
function navegar_url(url)
{
    window.location.href=url;
}
function checkAll() {

          var nodoCheck = document.getElementsByTagName("input");

          var varCheck = document.getElementById("all").checked;

          for (i=0; i<nodoCheck.length; i++){

              if (nodoCheck[i].type == "checkbox" && nodoCheck[i].name != "all" && nodoCheck[i].disabled == false) {

                  nodoCheck[i].checked = varCheck;

              }

          }

      }
