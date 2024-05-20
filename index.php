<?php

/*
A- (1 pt.) index.php:Recibe todas las peticiones que realiza el postman, y administra a qué archivo se debe incluir.
B- (1 pt.) HeladeriaAlta.php: (por POST) se ingresa Sabor, Precio, Tipo (“Agua” o “Crema”), Vaso (“Cucurucho”,
“Plástico”), Stock (unidades).
Se guardan los datos en en el archivo de texto heladeria.json, tomando un id autoincremental como
identificador(emulado). Sí el nombre y tipo ya existen , se actualiza el precio y se suma al stock existente.
completar el alta con imagen del helado, guardando la imagen con el sabor y tipo como identificación en la
carpeta /ImagenesDeHelados/2024.
*/

if(isset($_GET["get"]) || isset($_POST["post"]))
{
    switch ($_SERVER["REQUEST_METHOD"])
    {
        case "GET":
            switch ($_GET["get"])
            {
                case "cookies":
                    require_once "./cookies.php";
                    break;
                default:
                    echo "parametro no permitido";
                    break;
            }
            break;
        case "POST":
            switch ($_POST["post"])
            {
                case "alta":
                    require_once "./HeladeriaAlta.php";
                    break;
                default:
                    echo "tipo no permitido";
                    break;
            }
            break;
            default:
                echo "metodo no permitido";
                break;
        }
}
else
{
    echo "parametro no permitido";
}

?>