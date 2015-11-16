<!-- AJAX AUTOSUGGEST SCRIPT -->
<script type="text/javascript" src="lib/ajax_framework.js"></script>

<style type="text/css">

/* ---------------------------- */

/* CUSTOMIZE AUTOSUGGEST STYLE */

#search-wrap input{width:500px; font-size:12px; color:#000000; padding:6px;border:solid 1px #999999;}

#results{width:260px; border:solid 1px #DEDEDE; display:none;}

#results ul, #results li{padding:0; margin:0; border:0; list-style:none;}

#results li {border-top:solid 1px #DEDEDE;}

#results li a{display:block; padding:4px; text-decoration:none;color:#000000; font-weight:bold;}

#results li a small{display:block; text-decoration:none; color:#999999;font-weight:normal;}

#results li a:hover{background:#0099FF;}

#results ul {padding:6px;}

</style>

<div id="search-wrap">

<h1></h1>

<input name="diagnos" id="diagnos" type="text" onkeyup="javascript:autosuggest()"/>

<div id="results"></div>

</div> 
