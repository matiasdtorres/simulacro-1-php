<?php

/*
3- 
 a- (1 pts.)  AltaVenta.php  : (por  POST  ) se recibe el email del usuario y el Sabor, Tipo y Stock,  si el ítem existe  en 
 heladeria.json,  y  hay stock  guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) .  Se debe descontar la cantidad vendida del stock.
 b- (1 pt) Completar el alta de la venta con imagen de la venta (ej:una imagen del usuario), guardando la imagen  con el sabor+tipo+vaso+mail(solo usuario hasta el @) y fecha de la venta  en la carpeta 
 /ImagenesDeLaVenta/2024  . 

*/


if (isset($_POST["email"]) && isset($_POST["sabor"]) && isset($_POST["vaso"]) && isset($_POST["tipo"]) && isset($_POST["stock"]))
{
    $email = $_POST["email"];
    $sabor = $_POST["sabor"];
    $vaso = $_POST["vaso"];
    $tipo = $_POST["tipo"];
    $stock = $_POST["stock"];
    $imagen = $_FILES["imagen"];

    if ($tipo != "agua" && $tipo != "crema")
    {
        echo "El tipo de helado debe ser agua o crema";
        exit;
    }
    elseif ($vaso != "cucurucho" && $vaso != "plastico")
    {
        echo "El tipo de vaso debe ser cucurucho o plastico";
        exit;
    }

    $helados = json_decode(file_get_contents("./heladeria.json", JSON_PRETTY_PRINT), true);

    foreach ($helados as &$helado)
    {
        if ($helado["sabor"] == $sabor && $helado["tipo"] == $tipo && $helado["stock"] >= $stock)
        {
            $helado["stock"] -= $stock;
            file_put_contents("./heladeria.json", json_encode($helados, JSON_PRETTY_PRINT));
            $ventas = json_decode(file_get_contents("./ventas.json", JSON_PRETTY_PRINT), true);

            $id = 0;
            if (file_exists("./ventas.json"))
            {
                foreach ($ventas as $venta)
                {
                    if ($venta["id"] >= $id)
                    {
                        $id = $venta["id"] + 1;
                    }
                }
            }

            $imagenNombre = $sabor ."_". $tipo ."_". $vaso ."_". explode("@", $email)[0] . date("_d-m-Y_") . ".png";
            move_uploaded_file($imagen["tmp_name"], "./ImagenesDeLaVenta/2024/" . $imagenNombre);

            $venta = array(
                "id" => $id,
                "email" => $email,
                "sabor" => $sabor,
                "tipo" => $tipo,
                "vaso" => $vaso,
                "stock" => $stock,
                "imagen" => $imagenNombre,
                "fecha" => date("d-m-Y")
            );

            $ventas[] = $venta;
            file_put_contents("./ventas.json", json_encode($ventas, JSON_PRETTY_PRINT));
            echo "venta realizada";
            exit;
        }
    }

    echo "no existe";
    exit;
}
else
{
    echo "faltan datos/imagen";
}


?>