use linea;

						-- A esta tabla no le hice nada
create table PRODUCTO (
ID_PRO INT AUTO_INCREMENT PRIMARY KEY,
PRO_NOMBRE VARCHAR (255) NOT NULL,
PRO_DESCRIPCION VARCHAR (255) NOT NULL,
PRO_TIPO INT ,
PRO_PRECIOTOTAL FLOAT(2) COMMENT 'Indica el precio unitario',
PRO_CANTIDAD INT NOT NULL,
PRO_ESTADO BIT DEFAULT 0,
PRO_FECHALTA  DATE NOT NULL,
PRO_CATEGORIA VARCHAR(255),
-- PRO_PRECIO_TOTAL_CALCULADO FLOAT(2) COMMENT 'Indica el precio total calculado, es decir, PRO_PRECIOTOTAL multiplicado por PRO_CANTIDAD del servidor php',
id_usuario int,
foreign key (id_usuario) references usuario (id)
);



-- ALTER TABLE PRODUCTO
-- ADD COLUMN PRO_PRECIO_TOTAL_CALCULADO FLOAT(2);
-- ALTER TABLE PRODUCTO
-- DROP COLUMN PRO_PRECIO_TOTAL_CALCULADO;
								-- Cambie el tipo de dato del video
create table VideoProducto(
IDVideo INT AUTO_INCREMENT PRIMARY KEY,
Video  MEDIUMTEXT NOT NULL,
FKProducto int not null COMMENT 'Indica el producto al cual pertenece ese video',
foreign key(FKProducto) references Producto (ID_PRO)
);

						-- Para la imagen cambie el tipo de dato
CREATE TABLE ImagenProducto(
IDImagen INT auto_increment primary key,
Imagen MEDIUMBLOB  NOT NULL,
FKProducto int not null COMMENT 'Indica el producto el cual pertenece esta imagen',
foreign key (FKProducto) references Producto(ID_PRO)
);



								-- Cambie el tipo de dato del video e imagen
DELIMITER //

CREATE PROCEDURE InsertarProducto(
    IN tipoProducto INT,
    IN nombreProducto VARCHAR(255),
    IN descripcionProducto VARCHAR(255),
    IN precioProducto FLOAT(2),
    IN cantidadProducto INT,
    IN categoriaProducto VARCHAR(255),  -- Debes definir cómo manejar la categoría en tu sistema
    IN videoProducto MEDIUMTEXT,
    IN imagenesProducto MEDIUMBLOB ,  -- Debes definir cómo manejar las imágenes en tu sistema
    IN id_usuario int
)
BEGIN
    -- Insertar en la tabla PRODUCTO
    INSERT INTO PRODUCTO (PRO_NOMBRE, PRO_DESCRIPCION, PRO_TIPO, PRO_PRECIOTOTAL, PRO_CANTIDAD, PRO_FECHALTA, PRO_CATEGORIA, id_usuario )
    VALUES (nombreProducto, descripcionProducto, tipoProducto, precioProducto, cantidadProducto, NOW(),categoriaProducto,id_usuario);

    -- Obtener el ID del producto recién insertado
    SET @productoID = LAST_INSERT_ID();

    -- Insertar en la tabla VideoProducto
    INSERT INTO VideoProducto (Video, FKProducto)
    VALUES (videoProducto, @productoID);

    -- Insertar en la tabla ImagenProducto (puedes repetir esta sección si tienes múltiples imágenes)
    INSERT INTO ImagenProducto (Imagen, FKProducto)
    VALUES (imagenesProducto, @productoID);

    COMMIT;
END //

DELIMITER ;


-- esta vista si funciona pero como quiero saber si el producto cotizado es 0 no me lo mostrara en index.php
-- entonces necesita ser 1 para que se vea en index.php
-- CREATE VIEW VistaFiltrarProductoo AS
-- -SELECT 
  --  PRODUCTO.ID_PRO,
   -- PRODUCTO.PRO_NOMBRE, 
   -- PRODUCTO.PRO_DESCRIPCION, 
   -- PRODUCTO.PRO_PRECIOTOTAL, 
   --  PRODUCTO.PRO_TIPO,  -- Agrega el campo PRO_TIPO aquí
   -- ImagenProducto.Imagen AS Imagen,
   -- VideoProducto.Video AS Video
    
-- FROM PRODUCTO
-- LEFT JOIN ImagenProducto ON PRODUCTO.ID_PRO = ImagenProducto.FKProducto
-- LEFT JOIN VideoProducto ON PRODUCTO.ID_PRO = VideoProducto.FKProducto;

CREATE VIEW VistaFiltrarProductooo AS
SELECT 
    PRODUCTO.ID_PRO,
    PRODUCTO.PRO_NOMBRE, 
    PRODUCTO.PRO_DESCRIPCION, 
    PRODUCTO.PRO_PRECIOTOTAL, 
    PRODUCTO.PRO_TIPO,
    PRODUCTO_COTIZADO.PRO_APROBADO,  -- Agrega el campo PRO_APROBADO aquí
    ImagenProducto.Imagen AS Imagen,
    VideoProducto.Video AS Video
    
FROM PRODUCTO
LEFT JOIN PRODUCTO_COTIZADO ON PRODUCTO.ID_PRO = PRODUCTO_COTIZADO.ID_COTI  -- Ajusta la condición del JOIN según tus claves primarias/foráneas
LEFT JOIN ImagenProducto ON PRODUCTO.ID_PRO = ImagenProducto.FKProducto
LEFT JOIN VideoProducto ON PRODUCTO.ID_PRO = VideoProducto.FKProducto;





DELIMITER //
CREATE PROCEDURE FiltrarProductoComprarr(IN productoIDParam INT)
BEGIN
    SELECT 
        PRODUCTO.ID_PRO,
        PRODUCTO.PRO_NOMBRE, 
        PRODUCTO.PRO_DESCRIPCION, 
        PRODUCTO.PRO_PRECIOTOTAL, 
        PRODUCTO.PRO_CANTIDAD,
        PRODUCTO.PRO_TIPO, -- ESTO ES NUEVO PARA EL BOTON DE COTIZXAR
        ImagenProducto.Imagen AS Imagen,
        VideoProducto.Video AS Video
    FROM PRODUCTO
    LEFT JOIN ImagenProducto ON PRODUCTO.ID_PRO = ImagenProducto.FKProducto
    LEFT JOIN VideoProducto ON PRODUCTO.ID_PRO = VideoProducto.FKProducto
    WHERE PRODUCTO.ID_PRO = productoIDParam;
END//
DELIMITER ;




