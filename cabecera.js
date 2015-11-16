//----------DHTML Menu Created using AllWebMenus PRO ver 5.0-#706---------------
//C:\Documents and Settings\Leo\Mis documentos\menu\Menus\cabecera.awm
awmRelativeCorner=8;
var awmMenuName='cabecera';
var awmLibraryBuild=706;
var awmLibraryPath='/awmdatacab';
var awmImagesPath='/windowsvista-assetscab';
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
awmImagesColl=["main-header.jpg",4,32,"main-footer.jpg",4,32,"indicator.png",9,32,"main-button-tile.jpg",21,32,"main-buttonOver-tile.jpg",21,32,"main-buttonOver-left.jpg",21,32,"main-buttonOver-right.jpg",21,32];
awmCreateCSS(1,2,1,'#FFFFFF',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(0,2,1,'#FFFFFF',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(1,2,1,'#000000',n,n,'14px sans-serif',n,'none',0,'#000000','0px 0px 0px 0',0);
awmCreateCSS(0,1,0,n,n,n,n,n,'none',0,'#000000',0,0);
awmCreateCSS(1,2,1,'#FFFFFF',n,3,'bold 11px Tahoma',n,'none',0,'#000000','0px 15px 0px 25',1);
awmCreateCSS(0,2,1,'#FFFFFF',n,4,'bold 11px Tahoma',n,'none',0,'#000000','0px 15px 0px 25',1);
var s0=awmCreateMenu(0,0,0,0,1,0,0,0,8,0,0,0,1,3,0,0,1,n,n,100,1,0,10,10,150,-1,1,200,200,0,0,0,"0,0");
it=s0.addItemWithImages(0,1,1,"","","","",0,0,0,3,3,3,n,n,n,"",n,n,n,n,n,0,0,0,n,n,n,n,n,n,0,0,0,0,0);
it=s0.addItemWithImages(4,5,5,"AYUDA",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,"ayuda.php?Naveg=Ayuda","new",5,0,2,n,5,5,n,6,6,0,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"ACERCA DE",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,"acercade.php",n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
it=s0.addItemWithImages(4,5,5,"SALIR",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,"salir.php",n,0,0,2,n,5,5,n,6,6,0,1,1,0,0);
it=s0.addItemWithImages(2,1,1,"","","","",1,1,1,3,3,3,n,n,n,"",n,n,n,n,n,0,0,0,n,n,n,n,n,n,0,0,0,0,0);
s0.pm.buildMenu();
}}
