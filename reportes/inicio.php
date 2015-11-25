<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>PANEL DE MANDO INTEGRAL</title>
<script type='text/javascript'>
function res() {
  var fs = document.getElementById('frameset1');
  if (fs) {
    fs.rows = '*';
    fs.cols = '*,85%';
  }
}
function min(n) {
  var fs = document.getElementById('frameset1');
  if (fs) {
    switch(n) {
      case 1:
      fs.cols = '3%,97%';
      break;
      case 2:
      fs.cols = '*,85%';
      break;
    }  
  }
}
function set(r, c) {
  var fs = document.getElementById('frameset1');
  if (fs) {
    fs.rows = r;
    fs.cols = c;
  }
}
function f1Onload() {
  var f1 = window.frames['mainFrame'];
  var ele = f1.document.getElementById('hideMe');
  ele.style.display = 'none';
}
</script>
<?php
$login_usr=$_REQUEST['login_usr'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset id='frameset1' rows="*" cols="*,85%" framespacing="0" frameborder="NO" border="0">
  <frame src="tree.php?login_usr=<?php echo $login_usr;?>" name="mainFrame">
  <frame src="panel.php?login_usr=<?php echo $login_usr;?>" name="rightFrame" scrolling="auto" noresize>
</frameset>
<noframes><body>
</body></noframes>
</html>
