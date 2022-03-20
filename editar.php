<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Actualizar Usuario</title>
<link rel="stylesheet" type="text/css" href="hoja.css">
</head>

<body>

<h1>ACTUALIZAR</h1>

<?php

  require_once "conexion.php";

  if(!isset($_POST["bot_actualizar"])){
    $id=$_GET["id"];

    $ced=$_GET["ced"];

    $nom=$_GET["nom"];

    $apell=$_GET["apell"];

    $dire=$_GET["dire"];

    $tele=$_GET["tel"];

    $email=$_GET["email"];
  }else{

    $id=$_POST["id"];

    $nom=$_POST["nom"];

    $apell=$_POST["ape"];

    $dir=$_POST["dir"];

    $ced=$_POST["ced"];

    $tele=$_POST["tel"];

    $email=$_POST["email"];

    $sql="UPDATE datos_usuario SET nombre=:miNom, apellido=:miApe, direccion=:miDir, telefono=:miTel, correo=:miCorreo WHERE id=:miId AND cedula=:miCed";

    $resultado=$base->prepare($sql);

    $resultado->execute(array(":miId"=>$id, ":miCed"=>$ced ,":miNom"=>$nom, ":miApe"=>$apell, ":miDir"=>$dir, ":miTel"=>$tele, ":miCorreo"=>$email));

    header("Location: index.php");

  }

?>

<p>
 
</p>
<p>&nbsp;</p>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <table width="25%" border="0" align="center">
    <tr>
      <td></td>
      <td><label for="id"></label>
      <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
      <td>Cedula</td>
      <td><label for="ced"></label>
      <input type="text" name="ced" id="ced" value="<?php echo $ced; ?>" readonly></td>
    </tr>
    <tr>
      <td>Nombre</td>
      <td><label for="nom"></label>
      <input type="text" name="nom" id="nom" value="<?php echo $nom; ?>"></td>
    </tr>
    <tr>
      <td>Apellido</td>
      <td><label for="ape"></label>
      <input type="text" name="ape" id="ape" value="<?php echo $apell; ?>"></td>
    </tr>
    <tr>
      <td>Dirección</td>
      <td><label for="dir"></label>
      <input type="text" name="dir" id="dir" value="<?php echo $dire; ?>"></td>
    </tr>
    <tr>
      <td>No. Telefono</td>
      <td><label for="tel"></label>
      <input type="text" name="tel" id="tel" value="<?php echo $tele; ?>"></td>
    </tr>
    <tr>
      <td>Correo Electronico</td>
      <td><label for="email"></label>
      <input type="text" name="email" id="email" value="<?php echo $email; ?>"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>