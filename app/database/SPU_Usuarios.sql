USE dbevaluacion;

DELIMITER $$

CREATE PROCEDURE spu_usuarios_login(IN p_nombreusuario VARCHAR(50))
BEGIN
    SELECT u.idusuario, u.nombreusuario, u.claveacceso, u.idrol, r.rol_nombre
    FROM usuarios u
    INNER JOIN roles r ON u.idrol = r.idrol
    WHERE u.nombreusuario = p_nombreusuario;
END$$

DELIMITER ;

CALL spu_usuarios_login('admin');
