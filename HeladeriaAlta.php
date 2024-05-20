<?php

/*
B- (1 pt.) HeladeriaAlta.php: (por POST) se ingresa Sabor, Precio, Tipo (“Agua” o “Crema”), Vaso (“Cucurucho”, “Plástico”), Stock (unidades).
Se guardan los datos en en el archivo de texto heladeria.json, tomando un id autoincremental como
identificador(emulado) .Sí el nombre y tipo ya existen , se actualiza el precio y se suma al stock existente.
completar el alta con imagen del helado, guardando la imagen con el sabor y tipo como identificación en la
carpeta /ImagenesDeHelados/2024.
*/

if (isset($_POST["sabor"]) && isset($_POST["precio"]) && isset($_POST["tipo"]) && isset($_POST["vaso"]) && isset($_POST["stock"]) && isset($_FILES["imagen"]))
{
    $sabor = $_POST["sabor"];
    $precio = $_POST["precio"];
    $tipo = $_POST["tipo"];
    $vaso = $_POST["vaso"];
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

    $id = 0;
    $actualizado = false;

    $helados = array();
    if (file_exists("./heladeria.json"))
    {
        $helados = json_decode(file_get_contents("./heladeria.json", JSON_PRETTY_PRINT), true);
    }

    foreach ($helados as &$helado)
    {
        if ($helado["sabor"] == $sabor && $helado["tipo"] == $tipo)
        {
            $helado["precio"] = $precio;
            $helado["stock"] = $stock;
            $actualizado = true;
            break;
        }
        if ($helado["id"] >= $id)
        {
            $id = $helado["id"] + 1;
        }
    }

    if (!$actualizado)
    {
        $helado = array(
            "id" => $id,
            "sabor" => $sabor,
            "precio" => $precio,
            "tipo" => $tipo,
            "vaso" => $vaso,
            "stock" => $stock,
            "imagen" => $sabor ."_". $tipo . ".png"
        );
        $helados[] = $helado;
    }

    file_put_contents("./heladeria.json", json_encode($helados, JSON_PRETTY_PRINT));

    $imagen_path = "./ImagenesDeHelados/2024/" . $sabor ."_". $tipo . ".png";
    move_uploaded_file($imagen["tmp_name"], $imagen_path);

    echo "helado actualizado/agregado";
}
else
{
    echo "faltan datos/imagen";
}