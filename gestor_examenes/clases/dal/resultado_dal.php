<?php
require_once(__DIR__ . "/../resultado.php");
require_once(__DIR__ . "/../abstract_mapper.php");

class ResultadoDAL extends AbstractMapper {
    public function insert($resultado) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO resultados (fechaResultado, calificacion, cantidadErrores, cantidadAciertos, idExamen, idAlumno) VALUES(:fechaResultado, :calificacion, :cantidadErrores, :cantidadAciertos, :idExamen, :idAlumno);");
        $stmt->execute([
            ':fechaResultado'     => $resultado->getFechaResultado()->format('Y-m-d H:i:s'),
            ':calificacion'       => $resultado->getCalificacion(),
            ':cantidadErrores'    => $resultado->getCantidadErrores(),
            ':cantidadAciertos'   => $resultado->getCantidadAciertos(),
            ':idExamen'           => $resultado->getIdExamen(),
            ':idAlumno'           => $resultado->getIdAlumno()
        ]);

        $idResultado = $pdo->lastInsertId(); 
        $resultado->setIdResultado((int) $idResultado);
    }

    public function get(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT * FROM resultados");
        $registros = array();

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado = new Resultado($registro["idResultado"], new DateTime($registro["fechaResultado"]), $registro["calificacion"], $registro["cantidadErrores"], $registro["cantidadAciertos"], $registro["idExamen"], $registro["idAlumno"]);

            $registros[] = $resultado;
        }
        return $registros;
    }
}
?>