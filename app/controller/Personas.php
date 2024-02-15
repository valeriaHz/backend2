<?php 
    namespace controller;
    use model\tablaPersona;
    require_once realpath('.../../vendor/autoload.php');

    class Personas{
        public static function obtener_datos(){
            $persona = new tablaPersona();
            echo json_encode($persona->consulta());
        }
    }
?>