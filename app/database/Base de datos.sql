CREATE DATABASE IF NOT EXISTS dbevaluacion;

USE dbevaluacion;

-- Tabla: Roles
CREATE TABLE Roles (
    idrol INT AUTO_INCREMENT PRIMARY KEY,
    rol_nombre VARCHAR(50) NOT NULL
);

-- Tabla: Personas
CREATE TABLE Personas (
    idpersona INT AUTO_INCREMENT PRIMARY KEY,
    apellidos VARCHAR(100) NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    dni VARCHAR(15) NOT NULL,
    fechanac DATE,
    telefono VARCHAR(15)
);

-- Tabla: Usuarios
CREATE TABLE Usuarios (
    idusuario INT AUTO_INCREMENT PRIMARY KEY,
    idpersona INT NOT NULL,
    idrol INT NOT NULL,
    nombreusuario VARCHAR(50) NOT NULL,
    claveacceso VARCHAR(255) NOT NULL,
    nivelacceso INT DEFAULT 1,
    active_at DATETIME,
    FOREIGN KEY (idpersona) REFERENCES Personas(idpersona),
    FOREIGN KEY (idrol) REFERENCES Roles(idrol)
);

-- Tabla: Categorias
CREATE TABLE Categorias (
    idcategoria INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(100) NOT NULL
);

-- Tabla: Evaluaciones
CREATE TABLE Evaluaciones (
    idevaluacion INT AUTO_INCREMENT PRIMARY KEY,
    idcategoria INT NOT NULL,
    idusuario INT NOT NULL,
    fechainicio DATETIME NOT NULL,
    fechafin DATETIME NOT NULL,
    comentarios TEXT,
    tiempodesarrollo INT,
    FOREIGN KEY (idcategoria) REFERENCES Categorias(idcategoria),
    FOREIGN KEY (idusuario) REFERENCES Usuarios(idusuario)
);

-- Tabla: Preguntas
CREATE TABLE Preguntas (
    idpregunta INT AUTO_INCREMENT PRIMARY KEY,
    idevaluacion INT NOT NULL,
    titulo TEXT NOT NULL,
    puntaje DECIMAL(5, 2) NOT NULL,
    FOREIGN KEY (idevaluacion) REFERENCES Evaluaciones(idevaluacion)
);

-- Tabla: Alternativas
CREATE TABLE Alternativas (
    idalternativa INT AUTO_INCREMENT PRIMARY KEY,
    idpregunta INT NOT NULL,
    alternativa TEXT NOT NULL,
    escorrecto BOOLEAN NOT NULL,
    FOREIGN KEY (idpregunta) REFERENCES Preguntas(idpregunta)
);

-- Tabla: Asignaciones
CREATE TABLE Asignaciones (
    idasignacion INT AUTO_INCREMENT PRIMARY KEY,
    idevaluacion INT NOT NULL,
    idusuario INT NOT NULL,
    fecha_asignacion DATETIME NOT NULL,
    FOREIGN KEY (idevaluacion) REFERENCES Evaluaciones(idevaluacion),
    FOREIGN KEY (idusuario) REFERENCES Usuarios(idusuario)
);

-- Tabla: Resultados
CREATE TABLE Resultados (
    idresultado INT AUTO_INCREMENT PRIMARY KEY,
    idasignacion INT NOT NULL,
    FOREIGN KEY (idasignacion) REFERENCES Asignaciones(idasignacion)
);

-- Tabla: Intentos
CREATE TABLE Intentos (
    idintento INT AUTO_INCREMENT PRIMARY KEY,
    idasignacion INT NOT NULL,
    fechaintento DATETIME NOT NULL,
    puntajeobtenido DECIMAL(5, 2),
    FOREIGN KEY (idasignacion) REFERENCES Asignaciones(idasignacion)
);
