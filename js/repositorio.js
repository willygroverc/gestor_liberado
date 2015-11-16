function guardar_CT(){ 
new FormValidator('frm_mod', [{
    name: 'us',
    display: 'USUARIOS',    
    rules: 'required|etq_HTML'
},{	
	name: 'list2',
	display: 'COPIA DE TRABAJO',
	rules: 'required|etq_HTML'
}], function(errors, event) {
    var SELECTOR_ERRORS = $('.error_box'),
        SELECTOR_SUCCESS = $('.success_box');
        
    if (errors.length > 0) {
        SELECTOR_ERRORS.empty();
        
        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            SELECTOR_ERRORS.append(errors[i].message + '<br />');
        }
        
        SELECTOR_SUCCESS.css({ display: 'none' });
        SELECTOR_ERRORS.fadeIn(200);
    } else {
        SELECTOR_ERRORS.css({ display: 'none' });
        SELECTOR_SUCCESS.fadeIn(200);
    }
    
    if (event && event.preventDefault) {
        event.preventDefault();
    } else if (event) {
        event.returnValue = false;
    }
});
	
	if (document.forms[0].onsubmit()==true){
		if (confirm('Desea registrar los datos introducidos?')){
			var us=document.getElementById('us');
			//alert(us.value);
			var list1=document.getElementById('list1');
			//alert(list1.value);
			var list2=document.getElementById('list2');
			//alert(list2.value);
			ajax=NuevoAjax();
			ajax.open("POST","abm/guarda_repositorio.php",true);
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					r=ajax.responseText;
					if (r==0){
						alert('Los datos han sido registrados...');
						location.href="#";
					}
				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			ajax.send("us="+us.value+"&list1="+list1.value+"&list2="+list2.value);
		}
	}
}
function addItem(){	
	var list1=document.getElementById("list1");
	var list2=document.getElementById("list2");	
	if(list1.selectedIndex==-1)
	return;
	var option = document.createElement("option");
	var text= document.createTextNode(list1[list1.selectedIndex].text)
	list2.appendChild(option)
	option.appendChild(text)
	list1.removeChild(list1[list1.selectedIndex])
	//total1 = 2;
	total1++;
}
function rmItem(){	
	var list1=document.getElementById("list1");
	var list2=document.getElementById("list2");
	if(list2.selectedIndex==-1)
	return;
	var option = document.createElement("option");
	var text= document.createTextNode(list2[list2.selectedIndex].text);
	list1.appendChild(option);
	option.appendChild(text);
	list2.removeChild(list2[list2.selectedIndex]);
	total1--;
}
function retornar(opc){
	//history.back(0);
	if (opc==1){
		if (confirm('Desea salir? se perderan los cambios no guardados.'))
			location.href="lista_ubicacionr.php";
	}
}