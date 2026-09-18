<?php
require_once __DIR__ . "/../Examen.php";

class ExamenDAL {
    private string $usuario = 'root';
    private string $contrasena = '1234';
    private string $servidor = "localhost";
    private string $basededatos = 'gestor_examenes';

    public function insertExamen(Examen $examen): void {
        $conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->basededatos) or die("Error al conectar: ");
        mysqli_set_charset($conexion, 'utf8');

        $consulta = sprintf(
            "INSERT INTO examenes (tema, fechaExamen, enlaceAcceso, idProfesor) VALUES('%s', '%s', '%s', '%s');",
            $examen->getTema(),
            $examen->getFechaExamen()->format('Y-m-d H:i:s'),
            $examen->getEnlaceAcceso(),
            $examen->getIdProfesor()
        );

        mysqli_query($conexion, $consulta);
        $examen->setIdExamen(mysqli_insert_id($conexion));
        mysqli_close($conexion);
    }

    public function getExamenes(): array {
        $conexion = mysqli_connect($this->servidor, $this->usuario, $this->contrasena, $this->basededatos) or die("Error al conectar: ");
        mysqli_set_charset($conexion, 'utf8');

        $resultado = mysqli_query($conexion, "SELECT * FROM examenes");
        $registros = [];

        while ($registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
            $examen = new Examen(
                $registro["idExamen"],
                $registro["tema"],
                new DateTime($registro["fechaExamen"]),
                $registro["enlaceAcceso"],
                $registro["idProfesor"]
            );

            $registros[] = $examen;
        }

        mysqli_close($conexion);
        return $registros;
    }
}
?>