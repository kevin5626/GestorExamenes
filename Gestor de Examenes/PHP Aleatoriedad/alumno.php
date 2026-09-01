<?php
    class Alumno {
        private int $dni;
        private string $nombre;
        private string $apellido;
        private int $id_curso;

        function __construct(int $dni, string $nombre, string $apellido, int $id_curso) {
            $this -> dni = $dni;
            $this -> nombre = $nombre;
            $this -> apellido = $apellido;
            $this -> id_curso = $id_curso;
        }
            
        public function getDni(): int {
            return $this -> dni;
        }

        public function getNombre(): string {
            return $this -> nombre;
        }
    
        public function getApellido(): string {
            return $this -> apellido;
        }
    
        public function getIdCurso1(): int {
            return $this -> id_curso;
        }

        public function setDni(int $dni): void {
            $this -> dni = $dni;
        }
        
        public function setNombre(string $nombre): void {
            $this -> nombre = $nombre;
        }

        public function setApellido(string $apellido): void {
            $this -> apellido = $apellido;
        }

        public function setIdCurso1(string $id_curso): void {
            $this -> id_curso = $id_curso;
        }
    }
?>