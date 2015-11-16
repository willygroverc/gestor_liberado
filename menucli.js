//----------DHTML Menu Created using AllWebMenus PRO ver 5.0-#706---------------
//C:\Gestor TI\menucli.awm
awmRelativeCorner=8;
var awmMenuName='menucli';
var awmLibraryBuild=706;
var awmLibraryPath='/awmdatateccli';
var awmImagesPath='/windowsvista-assetscli';
var awmSupported=(navigator.appName + navigator.appVersion.substring(0,1)=="Netscape5" || document.all || document.layers || navigator.userAgent.indexOf('Opera')>-1 || navigator.userAgent.indexOf('Konqueror')>-1)?1:0;
if (awmAltUrl!='' && !awmSupported) window.location.replace(awmAltUrl);
if (awmSupported){
//var nua=navigator.userAgent,scriptNo=(nua.indexOf('Safari')>-1)?7:(nua.indexOf('Gecko')>-1)?2:((document.layers)?3:((nua.indexOf('Opera')>-1)?4:((nua.indexOf('Mac')>-1)?5:1)));
var nua=navigator.userAgent,scriptNo=(nua.indexOf('Chrome')>-1)?2:((nua.indexOf('Safari')>-1)?7:(nua.indexOf('Gecko')>-1)?2:((document.layers)?3:((nua.indexOf('Opera')>-1)?4:((nua.indexOf('Mac')>-1)?5:1))));
var mpi=document.location,xt="";
var mpa=mpi.protocol+"//"+mpi.host;
var mpi=mpi.protocol+"//"+mpi.host+mpi.pathname;
if(scriptNo==1){oBC=document.all.tags("BASE");if(oBC && oBC.length) if(oBC[0].href) mpi=oBC[0].href;}
while (mpi.search(/\\/)>-1) mpi=mpi.replace("\\","/");
mpi=mpi.substring(0,mpi.lastIndexOf("/")+1);
var e=document.getElementsByTagName("SCRIPT");
for (var i=0;i<e.length;i++){if (e[i].src){if (e[i].src.indexOf(awmMenuName+".js")!=-1){xt=e[i].src.split("/");if (xt[xt.length-1]==awmMenuName+".js"){xt=e[i].src.substring(0,e[i].src.length-awmMenuName.length-3);if (e[i].src.indexOf("://")!=-1){mpi=xt;}else{if(xt.substring(0,1)=="/")mpi=mpa+xt; else mpi+=xt;}}}}}
while (mpi.search(/\/\.\//)>-1) {mpi=mpi.replace("/./","/");}
var awmMenuPath=mpi.substring(0,mpi.length-1);
while (awmMenuPath.search("'")>-1) {awmMenuPath=awmMenuPath.replace("'","&#39;");}
document.write("<SCRIPT SRC='"+awmMenuPath+awmLibraryPath+"/awmlib"+scriptNo+".js'><\/SCRIPT>");
var n=null;
awmzindex=1000;
}

var awmImageName='';
var awmPosID='';
var awmSubmenusFrame='';
var awmSubmenusFrameOffset;
var awmOptimize=0;
var awmUseTrs=0;
var awmSepr=["0","","",""];
function awmBuildMenu(){
if (awmSupported){
awmImagesColl=["main-header.jpg",4,32,"main-footer.jpg",4,32,"indicator.png",9,32,"main-button-tile.jpg",21,32,"main-buttonOver-tile.jpg",21,32,"main-buttonOver-left.jpg",21,32,"main-buttonOver-right.jpg",21,32,"anadir.gif",20,20,"hassubmenu.gif",4,7,"sub-button-tile.jpg",20,26,"sub-buttonOver-tile.jpg",20,26,"sub-button-left.jpg",34,26,"sub-buttonOver-left.jpg",34,26,"sub-button-right.jpg",34,26,"sub-buttonOver-right.jpg",34,26,"separator.jpg",227,2,"spacer.gif",1,1,"contrasena.gif",23,23,"listaus.gif",22,22];
awmCreateCSS(1,2,1,'#FFFFFF',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(0,2,1,'#FFFFFF',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(1,2,1,'#000000',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(0,1,0,n,n,n,n,n,'none',0,'#000000',0,0);
awmCreateCSS(1,2,1,'#FFFFFF',n,3,'bold 11px Tahoma',n,'none',0,'#000000','0px 15px 0px 25',1);
awmCreateCSS(0,2,1,'#FFFFFF',n,4,'bold 11px Tahoma',n,'none',0,'#000000','0px 15px 0px 25',1);
awmCreateCSS(0,1,0,n,n,n,n,n,'solid',1,'#808080',0,0);
awmCreateCSS(1,2,0,'#000000',n,9,'11px Tahoma',n,'none',0,'#000000','0px 10px 0px 4',1);
awmCreateCSS(0,2,0,'#000000',n,10,'11px Tahoma',n,'none',0,'#000000','0px 10px 0px 4',1);
awmCreateCSS(1,2,0,'#000000',n,15,'11px Tahoma',n,'none',0,'#000000','0px 0px 0px 0',1);
awmCreateCSS(0,2,0,'#000000',n,15,'11px Tahoma',n,'none',0,'#000000','0px 0px 0px 0',1);
var s0=awmCreateMenu(0,0,0,0,1,0,0,0,8,0,0,0,1,3,0,0,1,n,n,100,1,0,10,10,400,-1,1,200,200,0,0,0,"0,0");
it=s0.addItemWithImages(0,1,1,"","","","",0,0,0,3,3,3,n,n,n,"",n,n,n,n,n,0,0,0,n,n,n,n,n,n,0,0,0,0,0);
it=s0.addItemWithImages(4,5,5,"                 INICIO                 ",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,"pagina_inicio.php?Naveg=Inicio",n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"                DATOS USUARIO                  ",n,n,"",n,n,n,3,3,3,2,2,2,"",n,n,n,n,n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
var s1=it.addSubmenu(0,0,-1,0,0,0,0,6,0,1,0,n,n,100,0,5,0,-1,1,200,200,0,0);
it=s1.addItemWithImages(7,8,8,"    VER DATOS",n,n,"",7,7,7,3,3,3,n,n,n,"",n,n,n,"usuario_modi1.php?Naveg=Ver Datos&login_usr=brian",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    CAMBIAR CONTRASEÑA",n,n,"",17,17,17,3,3,3,n,n,n,"",n,n,n,"password.php?Naveg=Contrasena",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s1.addItemWithImages(9,10,10,"",n,n,"",16,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,2,2,n,n,n,n,n,n,0,0,0,0,0);
it=s1.addItemWithImages(7,8,8,"    LISTA DE DIRECTORIO",n,n,"",18,18,18,3,3,3,n,n,n,"",n,n,n,"usuarios_lista.php?Naveg=Directorio",n,0,0,2,11,12,12,13,14,14,1,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"            REGISTRAR ORDEN DE TRABAJO           ",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,"opt_clien.php?Naveg=Registrar Orden",n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"          ORDENES DE TRABAJO            ",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,"lista.php?Naveg=Ordenes de Trabajo",n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
it=s0.addItemWithImages(2,1,1,"","","","",1,1,1,3,3,3,n,n,n,"",n,n,n,n,n,0,0,0,n,n,n,n,n,n,0,0,0,0,0);
s0.pm.buildMenu();
}}
