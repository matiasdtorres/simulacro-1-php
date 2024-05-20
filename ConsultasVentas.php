<?php

/*
4-
(1 pts.)
ConsultasVentas.php: (por GET) Datos a consultar:

a- La cantidad de  Helados  vendidos en un día en particular (se envía por parámetro), si no se pasa fecha, se  muestran las del día de ayer.
b- El listado de ventas de un usuario  ingresado.
c- El listado de ventas entre dos fechas ordenado por  nombre.
d- El listado de ventas por sabor ingresado.
e- El listado de ventas por vaso  Cucurucho.
*/


if(isset($_GET["get"]))
{
    if(isset($_GET["fecha"]))
    {
        $fecha = $_GET["fecha"];
    }
    else
    {
        $fecha = strtotime("-1 day");
        $fecha = date("d-m-Y", $fecha);
    }

    $fecha = strtotime($fecha);
    $fecha = date("d-m-Y", $fecha);

    $ventas = array();
    if (file_exists("./ventas.json"))
    {
        $ventas = json_decode(file_get_contents("./ventas.json"), true);
    }

    $cantidad = 0;

    foreach ($ventas as $venta)
    {
        if ($venta["fecha"] == $fecha)
        {
            $cantidad += $venta["stock"];
        }
    }
    echo $cantidad;
}



?>