<?php
    require_once(__DIR__ . "/../Profesor.php");
    require_once(__DIR__ . "/../AbstractMapper.php");

    class ProfesorDAL extends AbstractMapper {
        public function insert($profesor) {
            $pdo = $this->conectar();
            $stmt = $pdo->prepare("INSERT INTO profesores (idUsuario) VALUES(:idUsuario);");
            $stmt->execute([
                ':idUsuario'     => $profesor->getIdUsuario(),
            ]);

            $idProfesor = $pdo->lastInsertId(); 
            $profesor->setIdProfesor($idProfesor);
        }

        public function get(): array {
            $pdo = $this->conectar();
            $stmt = $pdo->query("SELECT * FROM profesores");
            $registros = array();

            while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $profesor = new Profesor ($registro["IdProfesor"], $registro["idUsuario"]);

                $registros[] = $profesor;
            }
            return $registros;
        }
    }
?>