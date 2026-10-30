<?php
require_once(__DIR__ . "/../examen.php");
require_once(__DIR__ . "/../abstract_mapper.php");

class ExamenDAL extends abstractMapper {
    public function insert($examen) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO examenes (tema, fechaExamen, enlaceAcceso, idProfesor) VALUES(:tema, :fechaExamen, :enlaceAcceso, :idProfesor);");
        $stmt->execute([
            ':tema'          => $examen->getTema(),
            ':fechaExamen'   => $examen->getFechaExamen()->format('Y-m-d H:i:s'),
            ':enlaceAcceso'  => $examen->getEnlaceAcceso(),
            ':idProfesor'    => $examen->getIdProfesor()
        ]);

        $idExamen = $pdo->lastInsertId(); 
        $examen->setIdExamen($idExamen);
    }

    public function get(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT * FROM examenes");
        $registros = array();

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $examen = new Examen($registro["idExamen"], $registro["tema"], new DateTime($registro["fechaExamen"]), $registro["enlaceAcceso"], $registro["idProfesor"]);

            $registros[] = $examen;
        }
        return $registros;
    }

    public function obtenerPorId(int $idExamen): ?Examen {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("SELECT * FROM examenes WHERE idExamen = :idExamen");
        $stmt->execute([
            ':idExamen' => $idExamen,
        ]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$registro) {
            return null;
        }

        return new Examen($registro["idExamen"], $registro["tema"], new DateTime($registro["fechaExamen"]), $registro["enlaceAcceso"], $registro["idProfesor"]);
    }

    public function actualizarEnlaceAcceso($examen): void {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("UPDATE examenes SET enlaceAcceso = :enlaceAcceso WHERE idExamen = :idExamen");
        $stmt->execute([
            ':enlaceAcceso' => $examen->getEnlaceAcceso(),
            ':idExamen'     => $examen->getIdExamen(),
        ]);
    }
}
?>