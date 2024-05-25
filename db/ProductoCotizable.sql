

-- Tabla para productos cotizados que hereda de PRODUCTO_BASE
CREATE TABLE PRODUCTO_COTIZADO (
    ID_COTI INT AUTO_INCREMENT PRIMARY KEY,
    PRO_PRECIOUNITARIO FLOAT(2),
    
    PRO_MATERIAL VARCHAR(70),
    PRO_MEDIDAS VARCHAR(70),
    PRO_CADUCIDAD DATE,
    PRO_APROBADO BIT DEFAULT 0,
    FOREIGN KEY (ID_COTI) REFERENCES PRODUCTO (ID_PRO)
);


CREATE TABLE COMENTARIO(
ID_COMENTARIO int primary key auto_increment,
OP_VALORACION INT NOT NULL,
OP_COMENTARIOS VARCHAR (255) NOT NULL,
fecha date,
activo bool,
	ID_PRO     int COMMENT 'PK DE PRODUCTOS',
    id     int COMMENT 'PK DE PRODUCTOS',
	foreign key (ID_PRO) references PRODUCTO (ID_PRO),
foreign key (id) references usuario (id)
);



DELIMITER //

CREATE PROCEDURE InsertarProductoCotizable(
    IN tipoProducto INT,
    IN nombreProducto VARCHAR(255),
    IN descripcionProducto VARCHAR(255),
    IN precioProducto FLOAT(2),
    IN cantidadProducto INT,
    IN categoriaProducto VARCHAR(255),  -- Debes definir cómo manejar la categoría en tu sistema
    IN videoProducto MEDIUMTEXT,
    IN imagenesProducto MEDIUMBLOB ,  -- Debes definir cómo manejar las imágenes en tu sistema
    IN materialProducto VARCHAR(70),
    IN medidasProducto VARCHAR(70),
    IN id_usuario INT
)
BEGIN
    DECLARE productoID INT;
    DECLARE caducidadProducto DATE;

    -- Establecer la fecha de caducidad como la fecha actual más 5 días
    SET caducidadProducto = DATE_ADD(NOW(), INTERVAL 5 DAY);

    -- Insertar en la tabla PRODUCTO
    INSERT INTO PRODUCTO (PRO_NOMBRE, PRO_DESCRIPCION, PRO_TIPO, PRO_PRECIOTOTAL, PRO_CANTIDAD, PRO_FECHALTA, PRO_CATEGORIA, id_usuario)
    VALUES (nombreProducto, descripcionProducto, tipoProducto, precioProducto, cantidadProducto, NOW(), categoriaProducto, id_usuario);

    -- Obtener el ID del producto recién insertado
    SET productoID = LAST_INSERT_ID();

    -- Insertar en la tabla VideoProducto
    INSERT INTO VideoProducto (Video, FKProducto)
    VALUES (videoProducto, productoID);

    -- Insertar en la tabla ImagenProducto (puedes repetir esta sección si tienes múltiples imágenes)
    INSERT INTO ImagenProducto (Imagen, FKProducto)
    VALUES (imagenesProducto, productoID);

    -- Insertar en la tabla PRODUCTO_COTIZADO
    INSERT INTO PRODUCTO_COTIZADO (ID_COTI, PRO_PRECIOUNITARIO, PRO_MATERIAL, PRO_MEDIDAS, PRO_CADUCIDAD, PRO_APROBADO)
    VALUES (productoID, precioProducto, materialProducto, medidasProducto, caducidadProducto, 0);

    COMMIT;
END //

DELIMITER ;

-- Eliminar varios registros por ID
DELETE FROM PRODUCTO WHERE ID_PRO IN (3, 4, 5);
DELETE FROM VideoProducto WHERE IDVideo IN (3, 4, 5);
DELETE FROM ImagenProducto WHERE IDImagen IN (3, 4, 5);

DELETE FROM PRODUCTO_COTIZADO WHERE ID_COTI = 5;


-- CREATE VIEW ProductosPendientesAprobacion AS
-- SELECT * FROM PRODUCTO_COTIZADO WHERE PRO_APROBADO = 0;

CREATE VIEW ProductosPendientesAprobacion AS
SELECT 
    PC.ID_COTI,
    P.ID_PRO,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    P.PRO_TIPO,
    P.PRO_PRECIOTOTAL,
    P.PRO_CANTIDAD,
    P.PRO_ESTADO,
    P.PRO_FECHALTA,
    P.PRO_CATEGORIA,
    P.id_usuario,
    U.Usuario,
     IP.Imagen,
     VP.Video
     
FROM PRODUCTO_COTIZADO PC
JOIN PRODUCTO P ON PC.ID_COTI = P.ID_PRO

JOIN
    USUARIO U ON P.id_usuario = U.id
    LEFT JOIN ImagenProducto IP ON P.ID_PRO = IP.FKProducto
  LEFT JOIN  VideoProducto VP ON P.ID_PRO = VP.FKProducto
WHERE PC.PRO_APROBADO = 0;



SELECT * FROM ProductosPendientesAprobacion;

DELIMITER //
CREATE PROCEDURE AprobarProductoCotizado(IN p_ID_COTI INT)
BEGIN
    UPDATE PRODUCTO_COTIZADO
    SET PRO_APROBADO = 1
    WHERE ID_COTI = p_ID_COTI;
END //
DELIMITER ;
