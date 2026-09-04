DROP DATABASE IF EXISTS gestor_examenes;
CREATE DATABASE gestor_examenes;
USE gestor_examenes;

CREATE TABLE usuarios (
	idUsuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(35) NOT NULL,
	apellido VARCHAR(45) NOT NULL,
	email VARCHAR(80) NOT NULL
);

CREATE TABLE preguntas (
	idPregunta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	tema VARCHAR(45) NOT NULL,
	subtema VARCHAR(45) NOT NULL,
	dificultad ENUM('Facil', 'Intermedio', 'Dificil'),
	textoPregunta VARCHAR(500) NOT NULL,
	respuestas LONGTEXT NOT NULL,
	respuestaCorrecta VARCHAR(350) NOT NULL,
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
VALUES ('Programación', 'Algoritmos', 'Facil', '¿Con que forma se representa una decisión?', '{"respuesta": ["Cuadrado", "Rombo"]}', 'Rombo', 0),
       ('Programación', 'Algoritmos', 'Facil', '¿Los datos se guardan en variables?', '{"respuesta": ["Si", "No"]}', 'Si', 0),
       ('Programación', 'Algoritmos', 'Facil', '¿Con que forma se representa el inicio y final de un algoritmo?', '{"respuesta": ["Circulo", "Rectángulo", "Trapecio"]}', 'Circulo', 0),
       ('Programación', 'Algoritmos', 'Facil', 'Seleccione cual texto puede ser un algoritmo', '{"respuesta": ["Tomar café", "Playa", "Plato", "New York"]}', 'Tomar café', 0),
	   ('Programación', 'Algoritmos', 'Facil', '¿Qué es un algoritmo?', '{"respuesta": ["La forma de resolver una problemática", "La forma de crear una problemática", "Un lenguaje de programación"]}', 'La forma de resolver una problemática', 0),

	   ('Programación', 'Algoritmos', 'Intermedio', 'En programación orientada a objetos, ¿cuáles pueden ser consideradas clases?', '{"respuesta": ["Persona, Policía y Comisaría", "Arrestar solamente", "Caminar y correr"]}', 'Persona, Policía y Comisaría', 0),
	   ('Programación', 'Algoritmos', 'Intermedio', '¿Cuál es el primer paso recomendado antes de crear un algoritmo?', '{"respuesta": ["Analizar el problema", "Escribir código directamente", "Elegir colores para la interfaz"]}', 'Analizar el problema', 0),
	   ('Programación', 'Algoritmos', 'Intermedio', '¿Qué característica debe tener un algoritmo correcto?', '{"respuesta": ["Debe tener pasos ordenados y definidos", "Debe ser siempre muy largo", "Debe depender de un solo lenguaje"]}', 'Debe tener pasos ordenados y definidos', 0),
	   ('Programación', 'Algoritmos', 'Intermedio', '¿Qué estructura permite tomar decisiones dentro de un algoritmo?', '{"respuesta": ["Condicional", "Variable", "Comentario"]}', 'Condicional', 0),
	   ('Programación', 'Algoritmos', 'Intermedio', '¿Qué representa una variable dentro de un algoritmo?', '{"respuesta": ["Un espacio donde se almacena un dato", "Una pantalla del programa", "Un error del sistema"]}', 'Un espacio donde se almacena un dato', 0),

	   ('Programación', 'Algoritmos', 'Dificil', '¿Qué estructura de control permite repetir instrucciones en un algoritmo?', '{"respuesta": ["Bucle o ciclo", "Condicional", "Comentario"]}', 'Bucle o ciclo', 0),
	   ('Programación', 'Algoritmos', 'Dificil', '¿Qué ventaja tiene utilizar pseudocódigo antes de programar?', '{"respuesta": ["Permite diseñar la solución sin depender de un lenguaje", "Hace que el programa sea más rápido automáticamente", "Reemplaza la computadora"]}', 'Permite diseñar la solución sin depender de un lenguaje', 0),
	   ('Programación', 'Algoritmos', 'Dificil', '¿Qué característica evalúa que un algoritmo utilice correctamente los recursos?', '{"respuesta": ["Eficiencia", "Color del código", "Cantidad de comentarios"]}', 'Eficiencia', 0),
	   ('Programación', 'Algoritmos', 'Dificil', '¿Qué ocurre si un algoritmo tiene pasos en un orden incorrecto?', '{"respuesta": ["Puede producir resultados incorrectos", "Siempre funciona igual", "Se convierte automáticamente en código"]}', 'Puede producir resultados incorrectos', 0),
       ('Programación', 'Algoritmos', 'Dificil', '¿Qué método permite dividir un problema complejo en problemas más pequeños?', '{"respuesta": ["Divide y vencerás", "Eliminar variables", "Duplicar instrucciones"]}', 'Divide y vencerás', 0),


	   ('Programación', 'Clases', 'Facil', '¿Qué elementos principales forman una clase en programación orientada a objetos?', '{"respuesta":["Atributos y métodos","Variables y archivos","Pantallas y botones"]}', 'Atributos y métodos', 0),
	   ('Programación', 'Clases', 'Facil', '¿Qué representa una clase en programación orientada a objetos?', '{"respuesta":["Un modelo o plantilla para crear objetos","Un archivo de texto","Un tipo de error"]}', 'Un modelo o plantilla para crear objetos', 0),
	   ('Programación', 'Clases', 'Facil', '¿Cómo se llama una instancia creada a partir de una clase?', '{"respuesta":["Objeto","Variable","Método"]}', 'Objeto', 0),
	   ('Programación', 'Clases', 'Facil', '¿Cuál de estos elementos puede ser un atributo de una clase Persona?', '{"respuesta":["Nombre","Guardar","Imprimir pantalla"]}', 'Nombre', 0),
	   ('Programación', 'Clases', 'Facil', '¿Qué contiene un método dentro de una clase?', '{"respuesta":["Acciones o comportamientos","Solo nombres","Imágenes"]}', 'Acciones o comportamientos', 0),

	   ('Programación', 'Clases', 'Intermedio', '¿Qué diferencia existe entre una clase y un objeto?', '{"respuesta":["La clase es la plantilla y el objeto es una instancia de ella","Son exactamente lo mismo","El objeto siempre crea la clase"]}', 'La clase es la plantilla y el objeto es una instancia de ella', 0),
	   ('Programación', 'Clases', 'Intermedio', '¿Qué palabra se utiliza normalmente para crear un objeto a partir de una clase?', '{"respuesta":["new","class","import"]}', 'new', 0),
	   ('Programación', 'Clases', 'Intermedio', '¿Qué permite la encapsulación en una clase?', '{"respuesta":["Controlar el acceso a los datos internos","Eliminar todos los métodos","Crear más archivos automáticamente"]}', 'Controlar el acceso a los datos internos', 0),
	   ('Programación', 'Clases', 'Intermedio', '¿Qué tipo de método se ejecuta automáticamente al crear un objeto?', '{"respuesta":["Constructor","Destructor gráfico","Variable"]}', 'Constructor', 0),
	   ('Programación', 'Clases', 'Intermedio', '¿Qué relación permite que una clase herede características de otra?', '{"respuesta":["Herencia","Compilación","Conversión"]}', 'Herencia', 0),

	   ('Programación', 'Clases', 'Dificil', '¿Cuál es el objetivo principal de aplicar programación orientada a objetos?', '{"respuesta":["Organizar el código mediante objetos reutilizables","Eliminar completamente las variables","Evitar el uso de funciones"]}', 'Organizar el código mediante objetos reutilizables', 0),
	   ('Programación', 'Clases', 'Dificil', '¿Qué principio permite que una clase hija reutilice atributos y métodos de una clase padre?', '{"respuesta":["Herencia","Abstracción","Polimorfismo"]}', 'Herencia', 0),
	   ('Programación', 'Clases', 'Dificil', '¿Qué principio permite que un mismo método tenga diferentes comportamientos según el objeto?', '{"respuesta":["Polimorfismo","Encapsulación","Instanciación"]}', 'Polimorfismo', 0),
       ('Programación', 'Clases', 'Dificil', '¿Qué significa aplicar abstracción en una clase?', '{"respuesta":["Mostrar solo las características necesarias y ocultar detalles internos","Eliminar todos los atributos","Copiar una clase completa"]}', 'Mostrar solo las características necesarias y ocultar detalles internos', 0),
	   ('Programación', 'Clases', 'Dificil', '¿Qué ventaja ofrece dividir un sistema utilizando clases?', '{"respuesta":["Mejora la organización, mantenimiento y reutilización del código","Hace que todos los programas sean iguales","Evita utilizar objetos"]}', 'Mejora la organización, mantenimiento y reutilización del código', 0),


	   ('Programación', 'Logica', 'Facil', '¿Qué es la lógica en programación?', '{"respuesta":["La forma de razonar y resolver problemas mediante instrucciones","Un lenguaje de programación específico","Un tipo de computadora"]}', 'La forma de razonar y resolver problemas mediante instrucciones', 0),
	   ('Programación', 'Logica', 'Facil', '¿Qué operador lógico representa que ambas condiciones deben cumplirse?', '{"respuesta":["AND","OR","NOT"]}', 'AND', 0),
	   ('Programación', 'Logica', 'Facil', '¿Qué operador lógico representa que al menos una condición sea verdadera?', '{"respuesta":["OR","AND","NOT"]}', 'OR', 0),
	   ('Programación', 'Logica', 'Facil', '¿Qué estructura permite ejecutar una acción dependiendo de una condición?', '{"respuesta":["Si (if)","Variable","Comentario"]}', 'Si (if)', 0),
	   ('Programación', 'Logica', 'Facil', '¿Qué valor representa una condición que se cumple?', '{"respuesta":["Verdadero","Falso","Nulo"]}', 'Verdadero', 0),

	   ('Programación', 'Logica', 'Intermedio', '¿Qué devuelve una expresión lógica?', '{"respuesta":["Un valor verdadero o falso","Un archivo completo","Una imagen"]}', 'Un valor verdadero o falso', 0),
	   ('Programación', 'Logica', 'Intermedio', '¿Qué operador lógico invierte el valor de una condición?', '{"respuesta":["NOT","AND","OR"]}', 'NOT', 0),
	   ('Programación', 'Logica', 'Intermedio', 'Si una condición utiliza AND, ¿cuándo será verdadera?', '{"respuesta":["Cuando todas las condiciones sean verdaderas", "Cuando una condición sea verdadera", "Nunca puede ser verdadera"]}', 'Cuando todas las condiciones sean verdaderas', 0),
	   ('Programación', 'Logica', 'Intermedio', '¿Qué estructura permite elegir entre dos caminos posibles?', '{"respuesta":["Condicional if-else", "Variable", "Arreglo"]}', 'Condicional if-else', 0),
	   ('Programación', 'Logica', 'Intermedio', '¿Qué se debe analizar antes de crear una solución lógica?', '{"respuesta":["El problema y sus posibles soluciones", "El diseño visual solamente", "El nombre del programa"]}', 'El problema y sus posibles soluciones', 0),

	   ('Programación', 'Logica', 'Dificil', '¿Qué es una tabla de verdad?', '{"respuesta":["Una representación de resultados posibles de expresiones lógicas", "Una lista de variables del programa", "Un diseño de interfaz"]}', 'Una representación de resultados posibles de expresiones lógicas', 0),
	   ('Programación', 'Logica', 'Dificil', '¿Cuál es el resultado de una operación AND si una condición es falsa?', '{"respuesta":["Falso", "Verdadero", "Depende siempre del lenguaje"]}', 'Falso', 0),
	   ('Programación', 'Logica', 'Dificil', '¿Qué concepto permite combinar varias condiciones para tomar una decisión?', '{"respuesta":["Operadores lógicos", "Variables globales", "Comentarios"]}', 'Operadores lógicos', 0),
	   ('Programación', 'Logica', 'Dificil', '¿Qué ocurre cuando una condición dentro de un algoritmo nunca puede cumplirse?', '{"respuesta":["Existe una condición imposible o error lógico", "El programa siempre funciona mejor", "Se crea una nueva variable automáticamente"]}', 'Existe una condición imposible o error lógico', 0),
	   ('Programación', 'Logica', 'Dificil', '¿Qué técnica ayuda a encontrar errores en la lógica de un programa?', '{"respuesta":["Pruebas y análisis paso a paso", "Cambiar los colores del programa", "Eliminar todas las condiciones"]}', 'Pruebas y análisis paso a paso', 0),


	   ('Programación', 'JavaScript', 'Facil', '¿Qué es JavaScript?', '{"respuesta":["Un lenguaje de programación utilizado para crear páginas web interactivas", "Un sistema operativo", "Un motor de base de datos"]}', 'Un lenguaje de programación utilizado para crear páginas web interactivas', 0),
	   ('Programación', 'JavaScript', 'Facil', '¿Dónde se ejecuta principalmente JavaScript en una página web?', '{"respuesta":["En el navegador", "En el teclado", "En el monitor"]}', 'En el navegador', 0),
	   ('Programación', 'JavaScript', 'Facil', '¿Qué palabra se utiliza para declarar una variable que puede cambiar su valor?', '{"respuesta":["let", "html", "style"]}', 'let', 0),
	   ('Programación', 'JavaScript', 'Facil', '¿Qué símbolo se utiliza para escribir comentarios de una línea en JavaScript?', '{"respuesta":["//","##","<!--"]}', '//', 0),
	   ('Programación', 'JavaScript', 'Facil', '¿Qué función permite mostrar un mensaje en la consola del navegador?', '{"respuesta":["console.log()", "print()", "display()"]}', 'console.log()', 0),

	   ('Programación', 'JavaScript', 'Intermedio', '¿Cuál es la diferencia principal entre var, let y const?', '{"respuesta":["Controlan la forma en que se declaran y modifican variables","Son diferentes lenguajes de programación", "Sirven para crear imágenes"]}', 'Controlan la forma en que se declaran y modifican variables', 0),
	   ('Programación', 'JavaScript', 'Intermedio', '¿Qué estructura se utiliza para ejecutar código cuando una condición es verdadera?', '{"respuesta":["if", "for", "function"]}', 'if', 0),
	   ('Programación', 'JavaScript', 'Intermedio', '¿Qué es una función en JavaScript?', '{"respuesta":["Un bloque de código reutilizable que realiza una tarea","Una variable que guarda imágenes", "Un archivo HTML"]}', 'Un bloque de código reutilizable que realiza una tarea', 0),
	   ('Programación', 'JavaScript', 'Intermedio', '¿Qué método agrega un elemento al final de un array?', '{"respuesta":["push()", "remove()", "delete()"]}', 'push()', 0),
	   ('Programación', 'JavaScript', 'Intermedio', '¿Qué permite manipular JavaScript dentro de una página HTML?', '{"respuesta":["DOM","CPU","SQL"]}', 'DOM', 0),

	   ('Programación', 'JavaScript', 'Dificil', '¿Qué es una función flecha en JavaScript?', '{"respuesta":["Una forma simplificada de escribir funciones", "Una función que solo trabaja con flechas gráficas", "Un tipo de variable"]}', 'Una forma simplificada de escribir funciones', 0),
	   ('Programación', 'JavaScript', 'Dificil', '¿Qué característica permite que JavaScript ejecute operaciones sin bloquear el programa principal?', '{"respuesta":["Programación asíncrona", "Compilación manual", "Eliminación de variables"]}', 'Programación asíncrona', 0),
	   ('Programación', 'JavaScript', 'Dificil', '¿Qué es una Promise en JavaScript?', '{"respuesta":["Un objeto que representa el resultado futuro de una operación asíncrona", "Una variable global", "Un tipo de comentario"]}', 'Un objeto que representa el resultado futuro de una operación asíncrona', 0),
	   ('Programación', 'JavaScript', 'Dificil', '¿Qué método permite recorrer los elementos de un array y ejecutar una función en cada uno?', '{"respuesta":["forEach()", "create()", "connect()"]}', 'forEach()', 0),
	   ('Programación', 'JavaScript', 'Dificil', '¿Qué concepto permite que una función recuerde variables de su entorno externo?', '{"respuesta":["Closure", "Loop", "Selector"]}', 'Closure', 0);

SELECT * FROM preguntas;