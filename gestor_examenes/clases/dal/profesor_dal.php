<?php
    require_once(__DIR__ . "/../profesor.php");
    require_once(__DIR__ . "/../abstract_mapper.php");

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

        public function obtenerPorIdUsuario(int $idUsuario): ?Profesor {
            $pdo = $this->conectar();
            $stmt = $pdo->prepare("SELECT * FROM profesores WHERE idUsuario = :idUsuario");
            $stmt->execute([
                ':idUsuario' => $idUsuario,
            ]);
            $registro = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$registro) {
                return null;
            }

            return new Profesor($registro["idProfesor"] ?? $registro["IdProfesor"], $registro["idUsuario"]);
        }
    }
?>