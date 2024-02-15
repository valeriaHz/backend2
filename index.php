<?php
    use controller\Personas;
    require_once realpath('./vendor/autoload.php');
    Personas::obtener_datos();
    /* $newUser = array(
        'id_persona' => 1,
        'nombre' => 'Edgar',
        'apellido' => 'Castillo',
        'email' => 'eddy@email.com'
    ); */
    
?>

<!-- separa un arreglo de cadenas por comas -->