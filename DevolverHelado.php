<?php

/*
6-  (2 pts.)  DevolverHelado.php   (por POST), 
 Guardar en el archivo (devoluciones.json y cupones.json)  :
 a- Se ingresa el número de pedido y la causa de la devolución.
 El número de pedido debe existir (en ventas.json), se ingresa una  foto del cliente enojado,esto debe generar un
 cupón  de descuento  (id, devolucion_id, porcentajeDescuento,  estado[usado/no usado])
 con el 10% de descuento para  la próxima compra.
*/

if (isset($_POST["pedido"]) && isset($_POST["causa"]) && isset($_FILES["foto"]))
{
    $pedido = $_POST["pedido"];
    $causa = $_POST["causa"];
    $foto = $_FILES["foto"];
    $existepedido = false;

    $ventas = file_get_contents("ventas.json");
    $ventas = json_decode($ventas, true);
    foreach ($ventas as $venta)
    {
        if ($venta["id"] == $pedido)
        {
            $devoluciones = array();

            if (file_exists("./devoluciones.json"))
            {
                $devoluciones = json_decode(file_get_contents("./devoluciones.json"), true);
            }

            foreach ($devoluciones as $devolucion) {
                if ($devolucion["pedido"] == $pedido) {
                    echo "El pedido ya ha sido devuelto";
                    exit;
                }
            }

            $devoluciones[] = array(
                "pedido" => $pedido,
                "causa" => $causa,
            );

            $devoluciones = json_encode($devoluciones, JSON_PRETTY_PRINT);
            file_put_contents("./devoluciones.json", $devoluciones);

            $cupones = array();
            if (file_exists("./cupones.json"))
            {
                $cupones = json_decode(file_get_contents("./cupones.json"), true);
            }

            foreach ($cupones as $cupon) {
                if ($cupon["pedido"] == $pedido) {
                    echo "El pedido ya tiene un cupón de descuento";
                    exit;
                }
            }

            $cupones[] = array(
                "pedido" => $pedido,
                "porcentajeDescuento" => 10,
                "estado" => "no usado"
            );

            $cupones = json_encode($cupones, JSON_PRETTY_PRINT);
            file_put_contents("./cupones.json", $cupones);
            $existepedido = true;
            echo "devolucion guardada";
        }
    }
    if (!$existepedido)
    {
        echo "El pedido no existe";
        exit;
    }
}
else
{
    echo "Faltan datos";
}

?>