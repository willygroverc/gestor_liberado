<?php
    if(isset($_FILES['archivo'])){        
        if(move_uploaded_file($_FILES['archivo']['tmp_name'], 'Archivos Adjuntos/' . $_FILES['archivo']['name'])){
            $arhivo_subido = true;
        }else{
            $arhivo_subido = false;
        }
?>
<!DOCTYPE html>
<html>
  <head>
  </head>
    <body>
        <?php if($arhivo_subido): ?>
        <script type="text/javascript">
            parent.resultadoOk();
        </script>
        <?php else: ?>
        <script type="text/javascript">
            parent.resultadoErroneo();
        </script>
        <?php endif; ?>
    </body>
</html>
<?php
    }
?>