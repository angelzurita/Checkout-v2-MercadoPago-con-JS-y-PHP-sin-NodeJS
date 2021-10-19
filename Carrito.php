<?php

session_start();
if (!isset($_SESSION['id_users'])) {
  echo "<script>alert('Inicia sesion para realizar la compra');</script>";
  echo "<script> window.location='./login/login.php'; </script>";
  die();
}
require __DIR__ .  '/extenciones/vendor/autoload.php';

include_once "./login/db/conexion.php";
$id = $_SESSION['id_users'];
$query = "SELECT * FROM users WHERE id_users = $id";
$res = mysqli_query($con, $query);

if ($res) {
  $data = mysqli_fetch_assoc($res);
} else {
  $errmsg = "No se pudo cargar los datos";
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHeOy56eJmeDpjwpjAZsDebgJW04QEv0s&sensor=TRUE"></script>
  <script src="./carrito/carrito.js"></script>

  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>


  <!-- Estilos Internos -->
  <title>ChicaChick</title>

</head>

<body>

  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="./index.php" style="font-family: 'Lobster', cursive;">ChicaChick</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Inicio
              <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./Pijamas.php">Pijamas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./Sostenes.php">Sostenes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./Ropa_interior.php">Ropa interior</a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-right justify-content-center">
          <?php if (isset($_SESSION['id_users'])) { ?>
            <li class="nav-item active">
              <a class="nav-link">Bienvenido
                <span class="sr-only">(current)</span></a>
            </li>
            </li><i class="btn btn-primary btn-xs "><b><?php echo $_SESSION['username']; ?></b></i></li>
            <li class="nav-item"><a class="nav-link" href="./login/logout.php">Cerrar sesión</a></li>
          <?php } else { ?>
            <li class="nav-item"><a class="nav-link" href="./login/login.php">Login</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="./login/registro.php">Registro</a></li> -->
          <?php } ?>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-10 col-md-offset-1">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th class="text-center">Precio</th>
              <th class="text-center">Total</th>
              <th> </th>
            </tr>
          </thead>
          <tbody id="tbody-carrito">

            <template id="item-card">
              <tr>
                <td class="col-sm-8 col-md-6">
                  <div class="media">
                    <img class="media-object" id="imagen" style="width: 72px; height: 72px;">
                    <div class="media-body">
                      <h4 class="media-heading" id="nombre">Product name</h4>
                    </div>
                  </div>
                </td>
                <td class="col-sm-1 col-md-1" id= "cantidad" style="text-align: center">
                  <input type="number" min="1" step="1" class="form-control" id="cant" value="1">
                </td>
                <td class="col-sm-1 col-md-1 text-center"><strong id="monto">$4.87</strong></td>
                <td class="col-sm-1 col-md-1 text-center"><strong id="monto-total">$14.61</strong></td>
                <td class="col-sm-1 col-md-1">
                  <button type="button" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove"></span> Eliminar
                  </button>
                </td>
              </tr>
            </template>

            <tr id="last-tr">
              <td>   </td>
              <td>   </td>
              <td>   </td>
              <td>
                <h3>Total</h3>
              </td>
              <td class="text-right">
                <h3><strong id="total"></strong></h3>
              </td>
            </tr>
            <tr>
              <td>   </td>
              <td>   </td>
              <td>   </td>
              <td>
                <button type="button" class="btn btn-primary" onclick="window.location.href='index.php'">Continuar comprando</button>
              </td>
              <td>

                <button class="btn btn-primary" data-toggle="modal" data-target="#datosPedido" id="comprar">Comprar</button>

                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#datosPedido" onclick="funciones();">Comprar</button> -->
                <script src="https://sdk.mercadopago.com/js/v2"></script>

                <script>
                  document.getElementById("comprar").addEventListener("click", function() {

                    usuarioUbicacion(<?php echo $id ?>);

                    if (document.getElementsByClassName('mercadopago-button').length == 0 || document.getElementsByClassName('mercadopago-button').length == 1) {
                      mpButt = document.getElementById('body-row');
                      mpButt.style.display = 'none';

                      datos();
                      
                    } else {

                      bNew = document.getElementsByClassName('mercadopago-button').length;

                      for (x = 0; x < bNew; x++) {
                        pagosA = document.getElementsByClassName('mercadopago-button')[x];
                        pagosA.style.display = 'none';
                        datUbi = document.getElementById('ubi');
                        datUbi.style.display = 'none';
                        confButton = document.getElementById('confirmacion-btn');
                        confButton.style.display = 'none';
                      }

                      datos();

                    }



                  });
                </script>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="datosPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Por favor confirma los datos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group " id="ubi">
            <div class="form-group">
              <label for="name">Telefono: </label>
              <input type="telefono" id="telefono" name="telefono" placeholder="Telefono" required class="form-control" value="<?php echo $data['telefono'] ?>" />
              <span class="text-danger"></span>
            </div>

            <div class="form-mapa" id="form-mapa">
              <label class="p-mapa">Mueve el marcador para seleccionar tu dirección: </label>
              <div id="map" style="height:250px; width:100%; border: 1px solid black;"></div>
              <input id="txtLat" name="txtLat" type="text" value="<?php echo $data['latitud'] ?>" style="display: none" />
              <input id="txtLng" name="txtLng" value="<?php echo $data['longitud'] ?>" style="display: none" /><br />
            </div>

            <div class="form-group">
              <label for="name">Comentario: </label>
              <textarea type="text" id="comentario" name="comentario" placeholder="Referencias sobre tu caso o algun comentario extra que desees." class="form-control" style="resize: none; height: 250px;"></textarea>
              <span class="text-danger"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar">Close</button>

          <div class="pago" id="body-row" data-toggle="modal" data-target="#datosPedido"></div>

          <button class="btn btn-primary" id="confirmacion-btn">Confirmar</button>

          <script>

            document.getElementById("confirmacion-btn").addEventListener("click", function() {

              if (document.getElementsByClassName('mercadopago-button').length == 0) {


                datUbi = document.getElementById('ubi');
                datUbi.style.display = 'none';
                confButton = document.getElementById('confirmacion-btn');
                confButton.style.display = 'none';
                datos();
              } else {
                comprar();
                
                bNew = document.getElementsByClassName('mercadopago-button').length;

                for (x = 0; x < bNew; x++) {

                  document.getElementById("exampleModalLabel").innerHTML = "Continuar con el pago";
                  pagosA = document.getElementsByClassName('mercadopago-button')[x];
                  pagosA.style.display = 'none';
                  datUbi = document.getElementById('ubi');
                  datUbi.style.display = 'none';
                  confButton = document.getElementById('confirmacion-btn');
                  confButton.style.display = 'none';
                  mpButt = document.getElementById('body-row');
                  mpButt.style.display = 'initial';
                }

                datos();

              }

            });
          </script>
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-dark text-center text-white">
    <!-- Grid container -->
    <div class="container">

      <!-- Grid row-->
      <div class="row py-4 d-flex align-items-center">

        <!-- Grid column -->
        <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
          <h6 class="mb-0">¡Siguenos en nuestras redes sociales!</h6>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-6 col-lg-7 text-center text-md-right">

          <!-- Facebook -->
          <a class="fb-ic" href="#">
            <i class="fab fa-facebook-f white-text mr-4"> </i>
          </a>
          <!-- Twitter -->
          <a class="tw-ic" href="#">
            <i class="fab fa-twitter white-text mr-4"> </i>
          </a>
          <!-- Google +-->
          <a class="gplus-ic" href="#">
            <i class="fab fa-google-plus-g white-text mr-4"> </i>
          </a>
          <!--Instagram-->
          <a class="ins-ic" href="#">
            <i class="fab fa-instagram white-text"> </i>
          </a>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row-->

    </div>

    <div class="container text-center text-md-left mt-5">

      <!-- Grid row -->
      <div class="row mt-3">

        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

          <!-- Content -->
          <h6 class="text-uppercase font-weight-bold">Tienda de ropa</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>Contenido sobre la pagina</p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Productos</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a class="nav-link" href="#">Dama</a>
          </p>
          <p>
            <a class="nav-link" href="#">Caballero</a>
          </p>
          <p>
            <a class="nav-link" href="#">Niños</a>
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">Liks de usuario</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a href="./login/login.php">Your Account</a>
          </p>
          <p>
            <a href="#!">Become an Affiliate</a>
          </p>
          <p>
            <a href="#!">Shipping Rates</a>
          </p>
          <p>
            <a href="#!">Help</a>
          </p>

        </div>
      </div>

      <!-- Grid container -->

      <!-- Copyright -->
      <div class="bg-dark p-3 text-center" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright: DICSS Desarrollo
      </div>
      <!-- Copyright -->
  </footer>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
</body>
<script src="./mapa/ubicacion.js"></script>


</html>