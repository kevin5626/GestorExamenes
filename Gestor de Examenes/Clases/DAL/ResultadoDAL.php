<?php
require_once(__DIR__ . "/../Resultado.php");
require_once(__DIR__ . "/../AbstractMapper.php");

class ResultadoDAL extends AbstractMapper {
    public function insert($resultado) {
        $pdo = $this->conectar();
        $stmt = $pdo->prepare("INSERT INTO resultados (fechaResultado, calificacion, cantidadErrores, cantidadAciertos, idExamen) VALUES(:fechaResultado, :calificacion, :cantidadErrores, :cantidadAciertos, :idExamen);");
        $stmt->execute([
            ':fechaResultado'     => $resultado->getFechaResultado(),
            ':calificacion'       => $resultado->getCalificacion(),
            ':cantidadErrores'    => $resultado->getCantidadErrores(),
            ':cantidadAciertos'   => $resultado->getCantidadAciertos(),
            ':idExamen'           => $resultado->getIdExamen()
        ]);

        $idResultado = $pdo->lastInsertId(); 
        $resultado->setIdUsuario($idResultado);
    }

    public function get(): array {
        $pdo = $this->conectar();
        $stmt = $pdo->query("SELECT * FROM resultados");
        $registros = array();

        while($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado = new Resultado ($registro["idResultado"], $registro["fechaResultado"], $registro["calificacion"], $registro["cantidadErrores"], $registro["cantidadAciertos"], $registro["idExamen"]);

            $registros[] = $resultados;
        }
        return $registros;
    }
}
?>