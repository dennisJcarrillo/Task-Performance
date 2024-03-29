<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Parametro.php');
require_once('../../Controlador/ControladorParametro.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link href="/Recursos/css/login.css" rel="stylesheet" />
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <title>Recuperación contraseña</title>
</head>

<body class="container">
  <div class="ancho">
    <form action="solicitarUsuario_Rec.php" method="post">
      <div class="logo-empresa">
        <img src="<?php echo '/Recursos/' . ControladorParametro::obtenerUrlLogo(); ?>" height="220px">
      </div>
      <div style="display: flex; justify-content: center;">
        <p style="display: flex; justify-content: center; font-size: 2rem; font-weight: 500; width: 390px; 
        margin-bottom: 2rem; color: gray; text-transform: uppercase; background-color: #ffc90e; border-radius: 3rem;">
          Task
          Performance
        </p>
      </div>
      <h2 class="title-form" style="margin-bottom: 0;">Elija un método de recuperación</h2>
      <div class="check-conteiner">
        <input type="radio" name="radioOption" id="correo" value="correo" checked><label for="correo">Correo
          electrónico</label>
        <input type="radio" name="radioOption" id="pregunta" value="pregunta"><label for="pregunta">Pregunta
          secreta</label>
      </div>
      <button type="submit" name="enviado" class="btn btn-primary" style="margin-top: 1.5rem;">Continuar</button>
      <a href="../login/login.php" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <!-- <script src="../../Recursos/js/validacionesLogin.js"></script> -->
</body>

</html>