USE dbevaluacion;

-- Insertar roles
INSERT INTO Roles (rol_nombre) VALUES 
('Administrador'), 
('Instructor'), 
('Alumno'), 
('Invitado');

select * from Roles;

-- Insertar personas
INSERT INTO Personas (apellidos, nombres, dni, fechanac, telefono) VALUES 
('Pérez', 'Juan', '12345678', '1990-05-15', '987654321'),
('García', 'Ana', '87654321', '1992-08-20', '987654322');

select * from Personas;

-- Insertar usuarios
INSERT INTO Usuarios (idpersona, idrol, nombreusuario, claveacceso, nivelacceso, active_at) VALUES 
(1, 1, 'admin', '123', 1, NOW()),
(2, 2, 'instructor', '123', 1, NOW());

-- clave: claveacceso+123
UPDATE Usuarios SET claveacceso = '$2y$10$89QO0q6FMVp0fK0GV.SYj.2JYl0l9GjJEEDXDPNEHVqM2pn.W8/si' WHERE idusuario = 1;
UPDATE Usuarios SET claveacceso = '$2y$10$pR2NOlNRVIKy4kSlSeq8tuToy7z66GUq8N4W78HuvqLD8GPTE7LjS' WHERE idusuario = 2;

select * from Usuarios;

-- Insertar categorías
INSERT INTO Categorias (categoria) VALUES 
('Python'), 
('C#'), 
('Java');

-- Insertar evaluaciones
INSERT INTO Evaluaciones (idcategoria, idusuario, fechainicio, fechafin, comentarios, tiempodesarrollo) VALUES 
(1, 2, '2024-12-01 08:00:00', '2024-12-01 10:00:00', 'Evaluación inicial de matemáticas.', 120);

-- Insertar preguntas
INSERT INTO Preguntas (idevaluacion, titulo, puntaje) VALUES 
(1, '¿Cuál es el resultado de 2+2?', 5.0);

select * from preguntas;

-- Insertar alternativas
INSERT INTO Alternativas (idpregunta, alternativa, escorrecto) VALUES 
(1, '4', 1), 
(1, '5', 0), 
(1, '3', 0);

-- Insertar asignaciones
INSERT INTO Asignaciones (idevaluacion, idusuario, fecha_asignacion) VALUES 
(1, 2, '2024-11-20 10:00:00');

-- Insertar resultados
INSERT INTO Resultados (idasignacion) VALUES 
(1);

-- Insertar intentos
INSERT INTO Intentos (idasignacion, fechaintento, puntajeobtenido) VALUES 
(1, '2024-11-20 12:00:00', 5.0);
