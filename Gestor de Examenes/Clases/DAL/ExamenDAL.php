<?php
require_once(__DIR__ . "/../Examen.php");
require_once(__DIR__ . "/../AbstractMapper.php");

class ExamenDAL extends AbstractMapper {
    public function insert($examen) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO examenes (tema, fechaExamen, enlaceAcceso, idProfesor) VALUES(:tema, :fechaExamen, :enlaceAcceso, :idProfesor);");
        $stmt->execute([
            ':tema'          => $examen->getTema(),
            ':fechaExamen'   => $examen->getFechaExamen(),
            ':enlaceAcceso'  => $examen->getEnlaceAcceso(),
            ':idProfesor'    => $examen->getidProfesor() 
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
}
?>