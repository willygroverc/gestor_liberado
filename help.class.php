<?php

/**
 * Clase para generar los mensajes emergentes de ayuda.
 *
 * @version $Id$
 * @copyright 2003 
 **/

/** 
 * 
 *
 **/
class Help {
	/**
     * Constructor
     * @access protected
     */
	 var $helps = array();
	 var $outPut;
	 var $width;
	 var $heigth;
	 var $border;
	 var $color;
	 var $background;
	 var $front;
	 var $msgYanapti;
	 var $delay=500;
	 var $image;
	function Help (){
		$this->image="images/dibu.jpg";
		$this->width=150;
		$this->heigth=100;
		$this->border="1px solid #336699";
		$this->color="#0066CC";	
		$this->background="#AAAAAA";
		$this->front="#ffeeff";
		$this->msgYanapti="";//"\n\nMensaje generado por GesTor F1.";
	}
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	 function AddJsFunction () {
	 		$this->outPut="<SCRIPT LANGUAGE=\"JavaScript\">
					<!-- Original:  Donnie Brewer (brewsky@home.com) -->
					<!-- Web Site:  http://www.brewskynet.com/javatest/popup.html -->
					<!-- This script and many more are available free online at -->
					<!-- The JavaScript Source!! http://javascript.internet.com -->
					<!-- Begin
					
					function ViewData(user,ValueShow, x, y) {				
					if (ValueShow==\"hidden\"){
						clearTimeout(timer);
					}
					//alert (position);					
					
					user.style.left = x + 5;       // place popup at the mouse X (left) location
					user.style.top = y;            // place popup at the mouse Y (top) location
					}
					//  End -->
					</script>";
	 }
	function AddHelp($id, $msg, $width=0, $height=0){
	if (empty($width)) {
	    $width=$this->width;
	}
	if (empty($height)) {
	    $height=$this->heigth;
	}
	$this->helps[]=array(
				"id"=>$id,
				"msg"=>$msg,
				"width"=>$width,
				"height"=>$height,
		);
	}
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	function ToHtml(){
		foreach($this->helps as $tmp){
			$this->outPut.="
			<div id=\"$tmp[id]\" style=\"position:absolute; background-color:$this->background; visibility:hidden;\">
					<table border=\"0\" background=\"$this->image\" cellspacing=\"0\" cellpadding=\"4\" align=\"left\">
					<tr valign=\"middle\">
					<td style=\"font-family: verdana, arial, sans-serif; font-size: 11px; font-weight: normal; text-align: left; color:#000000; border: $this->border;weight:bold; margin: 0px; padding: 4px;\">
					$tmp[msg]
					</td></tr></table>
					</div>
			";
		}
		return $this->outPut;
	}
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	function AddLink($id, $text, $url="", $class="", $position=""){
		$link="<a ";
		if ($url) $link.="href=\"$url\" class=\"$class\" ";
		if ($position=="left") $link.="onmouseover=\"timer=setTimeout ('ViewData( $id , \'visible\', ' + (window.event.x-155) + ', ' + window.event.y + ');', 500);\" onmouseout=\"ViewData($id,'hidden', 100, 100)\"><div style=\" cursor: hand;\">$text</div></a>";
		else $link.="onmouseover=\"timer=setTimeout ('ViewData( $id , \'visible\', ' + window.event.x + ', ' + window.event.y + ');', 500);\" onmouseout=\"ViewData($id,'hidden', 100, 100)\"><div style=\" cursor: hand;\">$text</div></a>";
//		else $link.="onmouseover=\"timer=setTimeout ('ViewData( $id , \'visible\', ' + event.screenX + ', ' + event.clientY + ');', 500);\" onmouseout=\"ViewData($id,'hidden', 100, 100)\"><div style=\" cursor: hand;\">$text</div></a>";
		return $link;
	}
}
?>