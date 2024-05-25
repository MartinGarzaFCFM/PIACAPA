

CREATE DATABASE Linea;
USE Linea;

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL, -- Nombre del rol (por ejemplo, "Cliente" o "Vendedor")
  valor_num INT NOT NULL -- Valor numérico del rol (0 para "Cliente", 1 para "Vendedor", etc.)
);


CREATE TABLE usuario (
id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(40) NOT NULL,
    contrasena VARCHAR(40) NOT NULL,
   correo VARCHAR(70) NOT NULL,
    Nombre VARCHAR(255) NOT NULL,
    nacimiento DATE NOT NULL,
    sexo VARCHAR(15) NOT NULL, 
    creacion DATE NOT NULL,
   rol  INT NOT NULL,
   UsuImagenes TEXT,
   Privacidad BOOLEAN NOT NULL,
   estado BIT NOT NULL DEFAULT 0,
   
    FOREIGN KEY (rol) REFERENCES roles(id)
 
);
ALTER TABLE usuario
ADD CONSTRAINT correo UNIQUE (correo);
ALTER TABLE usuario
ADD CONSTRAINT usuario UNIQUE (usuario);





INSERT INTO roles (nombre, valor_num) VALUES ('Cliente', 1);
INSERT INTO roles (nombre, valor_num) VALUES ('Vendedor', 2);
INSERT INTO roles (nombre, valor_num) VALUES ('Administador', 3);
-- Puedes agregar más roles según sea necesario
DELIMITER //
CREATE PROCEDURE InsertarUsuarioPrivacidad(
    IN p_usuario VARCHAR(255),
    IN p_contrasena VARCHAR(255),
    IN p_correo VARCHAR(255),
    IN p_Nombre VARCHAR(255),
    IN p_nacimiento DATE,
    IN p_sexo VARCHAR(15) ,
    IN p_rol INT,
   IN p_UsuImagenes TEXT,
    IN p_Privacidad BOOLEAN
)
BEGIN
    INSERT INTO usuario (usuario, contrasena, correo, Nombre, nacimiento, sexo, creacion, rol, UsuImagenes, Privacidad)
    VALUES (p_usuario, p_contrasena, p_correo, p_Nombre, p_nacimiento, p_sexo, CURDATE(), p_rol, p_UsuImagenes, p_Privacidad);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE VerificarCredenciales(IN p_usuario VARCHAR(255), IN p_password VARCHAR(255))
BEGIN
    SELECT * FROM usuario WHERE usuario = p_usuario AND contrasena = p_password;
END //
DELIMITER ;

-- 
-- DELIMITER //
-- CREATE PROCEDURE ValidarContrasena(IN p_password VARCHAR(255))
-- BEGIN
  --  DECLARE pattern VARCHAR(255);
  --  SET pattern = '^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.{8,})';
    
--    IF p_password REGEXP pattern THEN
 --       SELECT 'Contraseña válida' AS mensaje;
 --   ELSE
  --      SELECT 'La contraseña no cumple con los requisitos' AS mensaje;
 --   END IF;
-- END //
-- DELIMITER ;



INSERT INTO usuario (usuario, contrasena, correo, Nombre, nacimiento, sexo, creacion, rol, UsuImagenes)
VALUES ('Admin', 'P@ssw0rd', 'admin@ejemplo.com', 'Fabian Alejandro', '2000-01-01', 'Masculino', CURDATE(), 3, 'imagen_admin.jpg');



DELIMITER //
CREATE PROCEDURE ActualizarUsuario(
	IN c_id INT,
    IN c_usuario VARCHAR(255),
    IN c_contrasena VARCHAR(255),
    IN c_correo VARCHAR(255),
    IN c_Nombre VARCHAR(255),
    IN c_nacimiento DATE
  
)
BEGIN
UPDATE usuario
SET
        usuario = c_usuario,
        contrasena =c_contrasena,
        correo = c_correo ,
        Nombre = c_Nombre,
        nacimiento = c_nacimiento
    WHERE
        id = c_id;
    
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE EliminarUsuario(IN c_id INT)
BEGIN
    UPDATE usuario
    SET estado = 1
    WHERE id = c_id;
END;
//
DELIMITER ;


SELECT
    id,
    usuario,
    contrasena,
    correo,
    Nombre,
    nacimiento,
    sexo,
    creacion,
    CASE
        WHEN rol = 0 THEN 'Cliente'
        WHEN rol = 1 THEN 'Vendedor'
        WHEN rol = 2 THEN 'Administrador'
        ELSE 'Valor Desconocido'
    END AS rol_descripcion
FROM usuario;

-- UPDATE usuario
-- SET estado = 0
-- WHERE id = 14;

-- DELETE FROM usuario WHERE id = '14' 
