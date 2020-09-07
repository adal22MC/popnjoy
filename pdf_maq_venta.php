<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Venta</title>

  <style type="text/css">
    * {
      font-family: Verdana, Arial, sans-serif;
      font-size: 14px;

    }
    .tdD{
        width: 100px;
    }
    .imgE{
      margin-top: 5px;
    }
    .pre{
      font-weight: bold;
    }
    table {
      font-size: x-small;
    }

    tfoot tr td {
      font-weight: bold;
      font-size: x-small;
    }

    .gray {
      background-color: lightgray;
    }

    .success {
      color: green;
    }

    .hr {
      width: 75%;
    }

    footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 80px;
      color: black;
    }
  </style>
</head>

<body>
  <!-- Cabecera -->
  <table width="70%">
    <tr>
        <td valign="top" align="left" > 
            <img src="dist/img/pos.jpg" alt="logo" width="150" align="center" class="imgE"/>           
         </td>
         <td valign="top" align="center" class="tdD"> 
            <?php
            $datosE = Empresa_model::select();
           
            echo "
            <p style='font-size: 12px' >                  
            <pre><p style='font-size: 14px' class='pre' >". $datosE['nombre'] . "</p>
            
" . $datosE['telefono'] . "
" . $datosE['correo'] . "
" . $datosE['direccion'] . " 
" . $datosE['pagina_web'] . "</pre>
                </p>";  
            ?>
        </td>
    </tr>
  </table>
  <br>
  <?php
    
  foreach ($Id as $item) {
    $id_c = 0;
  ?>
    <!-- Información del Despacho  -->
    <table width="60%">
        <?php
            if (isset($_GET['fechaInicial'])) {
            echo "
            <tr>
            <td><strong>Inicio:</strong>" . $_GET['fechaInicial'] . "</td>
            <td><strong>Final:</strong>" . $_GET['fechaFinal'] . "</td>
            </tr> ";
            }
        ?>
      <?php
      
        $datoFH = Venta_model::obtenerHFVenta($item["id"]);
        $id_c += $datoFH["cliente"];
        echo"<tr>
        <td><strong>Fecha:</strong> " . $datoFH['fecha'] . "</td>
        <td><strong>Hora:</strong> " . $datoFH['hora'] . "</td></tr>
        ";
      ?>

    </table>
    <hr>
    <!-- Información del trabajador -->
    <div width="100%" align="right">
      <h3 align="center">Datos del Cliente:</h3>
      <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Direccion</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $datoC = Cliente_model::selectId($id_c);
            echo '
                <tr>
                    <th scope="row">'.$datoC["nombre"].'</th>
                    <td align="center">'.$datoC["email"].'</td>
                    <td align="center">'.$datoC["telefono"].'</td>
                    <td align="center">'.$datoC["direccion"].'</td>
                </tr>';
          ?>
        </tbody>
      </table>
    </div>
    <br /> <br>
    <!-- Resumen de la cotización -->
    <table width="100%">
      <thead style="background-color: lightgray;">
        <tr>
          <th>Codigo</th>
          <th>Producto</th>
          <th>Categoria</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $datosP = Venta_model::obtenerProductosVenta($item["id"]);
          $total = 0;
          foreach($datosP as $P){
              $total += $P["total"];
            echo '
            <tr>
                <th scope="row">'.$P["id"].'</th>
                <td align="center">'.$P["nombre"].'</td>
                <td align="center">'.$P["descripcion"].'</td>
                <td align="center">'.$P["total"].'</td>
            </tr>';
          }
        ?>
      </tbody>
      <tfoot>

        <tr>
          <?php
           echo '
           <td colspan="2"></td>
           <td align="right" >TOTAL: </td>
           <td align="center" class="gray">
             <h3 style="margin: 0px 0px;">'.$total.'</h3>
           </td>';
          ?>
        </tr>
      </tfoot>
    </table>
   
    <br><br><br><br>
  <?php
  }
  ?>
  
</body>

</html>