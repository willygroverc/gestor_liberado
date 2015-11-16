// Creado:		23/Oct/2012 
// Autor: 		Cesar Cuenca
// Tipo: 		Libreria de Utilidad -Validadion y Formularios
//_____________________________________________________________________________________

function TelcaPulsada( e ) {  
  
   if ( window.event != null)               //IE4+  
      tecla = window.event.keyCode;  
   else if ( e != null )                //N4+ o W3C compatibles  
      tecla = e.which;  
   else  
      return;  
      
   if (tecla == 13) {                   //se pulso enter  
      if ( siguienteCampo == 'fin' ) {          //fin de la secuencia, hace el submit  
         alert('Envio del formulario.')         //eliminar este alert para uso normal  
         return false                   //sustituir por return true para hacer el submit  
      } else {                      //da el foco al siguiente campo  
         eval('document.' + nombreForm + '.' + siguienteCampo + '.focus()')  
         return false  
      }  
   }  
}  
  
  
  
