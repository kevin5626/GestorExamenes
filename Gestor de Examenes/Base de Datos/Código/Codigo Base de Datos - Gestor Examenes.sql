DROP DATABASE IF EXISTS gestor_examenes;
CREATE DATABASE gestor_examenes;
USE gestor_examenes;

CREATE TABLE usuarios (
idUsuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(35) NOT NULL,
apellido VARCHAR(45) NOT NULL,
email VARCHAR(80) NOT NULL,
contrasenia CHAR(64) NULL
);

CREATE TABLE preguntas (
idPregunta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
tema VARCHAR(45) NOT NULL,
subtema VARCHAR(45) NOT NULL,
dificultad ENUM('Facil', 'Intermedio', 'Dificil'),
textoPregunta VARCHAR(500) NOT NULL,
respuestas JSON NOT NULL,
respuestaCorrecta VARCHAR(45) NOT NULL,
apariciones INT NOT NULL
);

CREATE TABLE profesores (
idProfesor INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
idUsuario INT NOT NULL,
FOREIGN KEY (idUsuario) REFERENCES usuarios (idUsuario) 
);

CREATE TABLE alumnos (
idAlumno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
idUsuario INT NOT NULL,
FOREIGN KEY (idUsuario) REFERENCES usuarios (idUsuario) 
);

CREATE TABLE examenes (
idExamen INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
tema VARCHAR(50) NOT NULL,
fechaExamen DATETIME NOT NULL,
enlaceAcceso VARCHAR(60) NOT NULL,
idAlumno INT NOT NULL,
idProfesor INT NOT NULL,
FOREIGN KEY (idProfesor) REFERENCES profesores (idProfesor),
FOREIGN KEY (idAlumno) REFERENCES alumnos (idAlumno)
);

CREATE TABLE examenesYPreguntas (
idExamenYPreguntas INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
idPregunta INT NOT NULL,
idExamen INT NOT NULL,
FOREIGN KEY (idPregunta) REFERENCES preguntas (idPregunta),
FOREIGN KEY (idExamen) REFERENCES examenes (idExamen) 
);

CREATE TABLE resultados (
idResultado INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
fechaResultado DATETIME NOT NULL,
calificacion TINYINT NOT NULL CHECK(calificacion > 0 and calificacion < 11),
cantidadErrores TINYINT NOT NULL,
cantidadAciertos TINYINT NOT NULL,
idExamen INT NOT NULL,
FOREIGN KEY (idExamen) REFERENCES examenes (idExamen)
);

INSERT INTO preguntas (tema, subtema, dificultad, textoPregunta, respuestas, respuestaCorrecta, apariciones)
VALUES ('Programación', 'Clases', 'Facil', 'seleccione las clases:', '{"respuesta": ["Persona", "Policia", "Comisaria", "Arrestar"]}', 'Persona, Policia, Comisaria', 0),
	   ('Programación', 'Logica', 'Dificil', '¿para que sirve un If?', '{"respuesta": ["Tomar decisiones", "Evitar eorres"]}', 'Tomar decisiones', 0),
	   ('Programación', 'Logica', 'Intermedio', '¿Un rombo representa una desición?', '{"respuesta": ["No", "puede ser"]}', 'Si', 0);