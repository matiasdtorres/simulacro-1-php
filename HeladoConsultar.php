<?php

/*
2- 
 (1pt.)  HeladoConsultar.php  : (por  POST  ) Se ingresa Sabor y Tipo, si coincide con algún registro del archivo 
 heladeria.json,   retornar “existe”. De lo contrario  informar si no existe el tipo o el nombre.
*/

if (isset($_POST["sabor"]) && isset($_POST["tipo"]))
{
    $sabor = $_POST["sabor"];
    $tipo = $_POST["tipo"];

    $helados = json_decode(file_get_contents("./heladeria.json"), true);

    foreach ($helados as $helado)
    {
        if ($helado["sabor"] == $sabor && $helado["tipo"] == $tipo)
        {
            echo "existe";
            exit;
        }
    }

    echo "no existe";
    exit;
}


?>