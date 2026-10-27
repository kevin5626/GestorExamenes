<?php
    require_once(__DIR__ . "/../Alumno.php");
    require_once(__DIR__ . "/../AbstractMapper.php");
    
    class AlumnoDAL extends AbstractMapper {
        public function insert($alumno) {
            $pdo = $this->conectar();
            $stmt = $pdo->prepare("INSERT INTO alumnos (idUsuario) VALUES(:idUsuario);");
            $stmt->execute([
                ':idUsuario'     => $alumno->getIdUsuario(),
            ]);

            $idAlumno = $pdo->lastInsertId(); 
            $alumno->setIdUsuario($idAlumno);
        }

        public function get(): array {
            $pdo = $this->conectar();
            $stmt = $pdo->query("SELECT * FROM alumnos");
            $registros = array();

            while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $alumno = new Alumno ($registro["idAlumno"], $registro["idUsuario"]);

                $registros[] = $alumno;
            }
            return $registros;
        }
    }
?>