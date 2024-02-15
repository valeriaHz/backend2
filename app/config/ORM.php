<?php
    namespace config;
    use config\Conexion;
    use PDO;
    require_once realpath('.../../vendor/autoload.php'); 
        class ORM{
            protected $tabla;
            protected $id_tabla;
            protected $atributos;
            function __construct(){
                $this->atributos = $this->atributos_tabla();
            }

            private function atributos_tabla(){
                $consulta = Conexion::obtener_conexion()->prepare("DESCRIBE $this->tabla");
                $consulta->execute();
                $campos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $atributos = [];
                foreach($campos as $campo){
                    array_push($atributos, $campo['Field']);
                }
                return $atributos;
            }

            public function consulta($seleccion = ['*']){
                $seleccion = implode(',', $seleccion);
                $consulta = Conexion::obtener_conexion()->prepare("SELECT $seleccion FROM $this->tabla");
                if($consulta->execute()){
                    $data = $consulta->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $data = [];
                }
                    return $data;
            }
            
    
            /* public function consulta_id($id){
                $seleccion = implode(',', $seleccion);
                $consulta= Conexion::obtener_conexion()->prepare("SELECT * FROM $this->tabla WHERE $this->id_tabla = :id_tabla");
                if($consulta->execute($id)){
                    $data = $consulta->fetch(PDO::FETCH_ASSOC);
                }else{
                    $data = [];
                }
                return $data;
            } */
    
            public function insercion($datos){
                $propiedades= implode(",", array_keys($datos));
                $propiedades_key= ":".implode(", :", array_keys($datos));
                $consulta= Conexion::obtener_conexion()->prepare("INSERT INTO $this->tabla $propiedades");
                if($consulta->execute($datos)){
                    echo json_encode([1, "Inserción correcta"]);
                }else{
                    echo json_encode([0, "Error al insertar datos"]);
                }
            }

            public function actualizar($datos){
                $query = [];
                foreach(array_keys($datos) as $key){
                    if($this->id_tabla <> $key){
                        array_push($query, $key.'=:'.$key);
                    }
                }
                $query = implode(',', $query);
                $consulta = Conexion::obtener_conexion()->prepare("UPDATE $this->tabla SET $query WHERE $this->id_tabla = : id_persona");
                if($consulta->execute($datos)){
                    echo json_encode(([1, "Actualización correcta"]));
                }else{
                    echo json_encode([0, "Error al actualizar datos"]);
                }
            }
    
            /* public function actualizar($datos){
                $query = "";
                foreach(array_keys($datos) as $key){
                    $query .= $this->id_tabla == $key ? '' : ($contador =/ 0 ? ',' .$key ."=:". $key);
                    $contador++;
                }
                $consulta = Conexion::obtener_conexion()->prepare("UPDATE $this->$tabla SET $query WHERE $this->$id_tabla = : id_persona");
                if($consulta->execute($datos)){
                    echo json_encode(([1, "Actualización correcta"]));
                }else{
                    echo json_encode([0, "Error al actualizar datos"]);
                }
            } */
    
            public function eliminar($id){
                $consulta = Conexion::obtener_conexion()->prepare("DELETE FROM $this->tabla WHERE $this->id_tabla = :$this->id_tabla");
                if($consulta->execute($id)){
                    echo json_encode(([1, "Eliminación correcta"]));
                }else{
                    echo json_encode([0, "Error al actualizar datos"]);
                }
            }


    }

?>

<!-- composer dump-autoload actualiza los archivos -->