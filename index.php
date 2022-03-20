<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CRUD PHP CON LIBRERIA PDO</title>
<link rel="stylesheet" type="text/css" href="hoja.css">


</head>

<body>

<?php
  
  require_once "conexion.php";//INCLUYENDO EL ARCHIVO DE CONEXION.

  //---------------------------------------PAGINACIÓN--------------------------------//

  $tamagno_paginas=3; //CANTIDAD DE REGISTRO QUE MOSTRARÁ EN LA PAGINACIÓN

    //Entra aqui cuando se declara la variable global PAG.
    if(isset($_GET['pag'])){

      //Si la variable global PAG es igual a 1 manda a la Pagina Principal
      if($_GET['pag']==1){

        header("Location: index.php");//Dirige a la pagina Principal.

      }else{//Sino es igual a 1 entonces la variable PAGINA toma el valor de la variable global PAG. Para que 

        $pagina=$_GET['pag'];

      }
    
    }else{//Si no se ha declarado la variable PAG entra a la Pagina 1 o Principal.

      $pagina=1;

    }

    $empezar_desde=($pagina-1)*$tamagno_paginas; //CALCULO QUE SE HACE PARA EMPEZAR DESDE UNA POSICION (ANTERIOR Y DESPUES) EN LA PAGINACIÓN. EJEMPLO (1-1)*3=0, (2-1)*3=3, (3-1)*3=6.

    $sql_total="SELECT * FROM datos_usuario";//PEDIR TODOS LOS REGISTROS Y TODOS LOS CAMPOS 

    $resultado=$base->prepare($sql_total);//SE PREPARA LA CONSULTA PARA EVITAR FILTRACIONES.

    $resultado->execute(array());//SE EJECUTA LA CONSULTA PREPARADA Y SE VUELVE UN ARRAY.

    $num_filas=$resultado->rowCount();//SE CUENTAN TODOS LOS RESULTADOS QUE ESTEN EN EL ARRAY.

    $total_paginas=ceil($num_filas/$tamagno_paginas);//CALCULO QUE SE REALIZA PARA SACAR EL CONTROL DE LA CANTIDAD DE PAGINAS QUE SALDRAN EN LA PAGINACIÓN. EJEMPLO: redondea(28/3)= 9. SALDRAN NUEVE LINKS DEL 1 2 3 4 5 6 7 8 9. A LA FINAL DE LA PAGINA.

  //--------------------------------------FIN DE PAGINACIÓN-------------------------//

  $registros=$base->query("SELECT * FROM datos_usuario LIMIT $empezar_desde,$tamagno_paginas")->fetchAll(PDO::FETCH_OBJ);//CONSULTA LOS REGISTROS Y TODOS SUS CAMPOS CON LOS LIMITES ANTERIORMENTE CALCULADO Y LO COLOCA EN ARRAY PARA IDENTIFICAR COMO UN OBJETO.

  if(isset($_POST["cr"])){//SI PRESIONA EL BOTON DE INSERTAR REGISTRO ENTRA AQUI.
    
    //GUARDA LAS VARIABLES GLOBALES DEL FORMULARIO EN OTRAS VARIABLES NORMALES.
    $cedula=$_POST["Ced"];
    $nombre=$_POST["Nom"];
    $apellido=$_POST["Ape"];
    $direccion=$_POST["Dir"];
    $telefono=$_POST["Tel"];
    $correo=$_POST["Email"];

    //INSERCIÓN DE LOS DATOS DEL FORMULARIO CON UN FILTRO EN CADA CAMPO.
    $sql="INSERT INTO datos_usuario (cedula,nombre,apellido,direccion,telefono,correo) VALUES (:ced,:nom,:ape,:dir,:tel,:email)";

    $resultado=$base->prepare($sql);//SE PREPARA LA CONSULTA.

    $resultado->execute(array(":ced"=>$cedula,":nom"=>$nombre, ":ape"=>$apellido, ":dir"=>$direccion, ":tel"=>$telefono, ":email"=>$correo));//SE EJECUTA LA CONSULTA CON CADA FILTRO SU VALOR RESPECTIVO.

    header("Location: index.php ");//DESPUES DE TODO SE REDIRECCIONA DE NUEVO A LA PAGINA PRINCIPAL.
  }

?>

<!-- titulo de la pagina principal -->

<h1>SISTEMA DE CREATE READ UPDATE DELETE<span class="subtitulo"></span></h1>

<!-- formulario con metodo POST que llama a la misma pagina al enviar los datos. -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

  <table width="50%" border="0" align="center">
    
    <!-- fila que contiene todos los titulos de cada campo -->
    <tr >
      <td class="primera_fila">Id</td>
      <td class="primera_fila">Cedula</td>
      <td class="primera_fila">Nombre</td>
      <td class="primera_fila">Apellido</td>
      <td class="primera_fila">Dirección</td>
      <td class="primera_fila">No. Telefono</td>
      <td class="primera_fila">Correo Electronico</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
      
    </tr> 
   
   <!-- Bucle foreach que imprimira a todos los registros limitados, el cual cada campo se identifica como la variable PERSONA y cada campo se trata como un OBJETO. -->
	<?php foreach ($registros as $persona): ?>
   	
    <!-- Filas que se repetiran con el Bucle y se encuentran los botones de Borrar y Actualizar -->
    <tr>
      <td><?php echo $persona->id; ?></td>
      <td><?php echo $persona->cedula; ?></td>
      <td><?php echo $persona->nombre; ?></td>
      <td><?php echo $persona->apellido; ?></td>
      <td><?php echo $persona->direccion; ?></td>
      <td><?php echo $persona->telefono; ?></td>
      <td><?php echo $persona->correo; ?></td>
 
      <!-- Boton de BORRAR. Se pasa el "id" de la persona a borrar y se redirecciona al documento borrar.php -->
      <td class="bot"><a href="borrar.php?id=<?php echo $persona->id; ?>"><input type='button' name='del' id='del' value='Borrar'></a></td>

      <!-- Boton ACTUALIZAR el cual se le pasan todos los campos y sus valores y se redirecciona a la pagina de editar.php -->
      <td class='bot'><a href="editar.php?id=<?php echo $persona->id; ?>&ced=<?php echo $persona->cedula; ?>&nom=<?php echo $persona->nombre; ?>&apell=<?php echo $persona->apellido; ?>&dire=<?php echo $persona->direccion; ?>&tel=<?php echo $persona->telefono; ?>&email=<?php echo $persona->correo; ?>"><input type='button' name='up' id='up' value='Actualizar'></a></td>
.
    </tr>

  <?php endforeach; ?>
  <!-- FIN DEL BUCLE QUE REPITE LOS REGISTROS LIMITADOS -->
  

  <!-- Campos para INSERTAR los registros y su respectivo Boton de Insertar. Esta información se maneja en esta misma pagina en una sección arriba. -->
	<tr>
	  <td></td>
      <td><input type='text' name='Ced' size='10' class='centrado'></td>
      <td><input type='text' name='Nom' size='10' class='centrado'></td>
      <td><input type='text' name='Ape' size='10' class='centrado'></td>
      <td><input type='text' name='Dir' size='10' class='centrado'></td>
      <td><input type='text' name='Tel' size='10' class='centrado'></td>
      <td><input type='text' name='Email' size='10' class='centrado'></td>
      <td class='bot'><input type='submit' name='cr' id='cr' value='+ Insertar'></td>
  	   <td class="sin">&nbsp;</td>
  </tr>
  

  <!-- FILA COMPLETA QUE SACA TODOS LOS LINK'S QUE TIENE LA PAGINACIÓN DEPENDIENDO DE LOS REGISTROS QUE HAYAN -->
  <tr>
    <td colspan="7">
      <?php

  //--------------------------------------------------PAGINACIÓN PÁGINAS--------------------------//

        for($i=1; $i<=$total_paginas; $i++){

          echo "<a href='?pag=" . $i . "'>" . $i . "</a>  ";

        }
  //----------------------------------------------FIN PAGINACÓN PÁGINAS---------------------------//
      
      ?>
    </td>
  </tr>    
  </table>

</form>

<p>&nbsp;</p>
</body>
</html>