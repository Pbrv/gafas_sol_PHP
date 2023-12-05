<?php
    require_once 'configuracionBBDD.php';

    class ConexionBD {
        private $hostname = HOST;
        private $database = BD;
        private $user = USER;
        private $password = PASSWORD;
        private $charset = CHARSET;
        private $conexion;
        
        function getConexion() {
            //se añaden try y catch por si hubiera un fallo en tiempo de ejecucion
            try {
                $this->conexion = new PDO('mysql:host=' . $this->hostname.
                        ';dbname=' . $this->database . ';charset=' . $this->charset, $this->user, $this->password);
                
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //ATTR_ERRMODE --> Reporte de errores
                //ERRMODE_EXCEPTION --> Lanza excepciones
                
            } catch (PDOException $e) {
                die ("¡ERROR: !" . $e->getMessage()); 
            }
            return $this->conexion;        
        }
        
        function cerrarConexion() {
            $this->conexion = null;
        }
    }

?>
