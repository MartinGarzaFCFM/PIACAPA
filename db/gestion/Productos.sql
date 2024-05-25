use linea;

						
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
							
create table VideoProducto(
IDVideo INT AUTO_INCREMENT PRIMARY KEY,
Video  MEDIUMTEXT NOT NULL,
FKProducto int not null COMMENT 'Indica el producto al cual pertenece ese video',
foreign key(FKProducto) references Producto (ID_PRO)
);

						
CREATE TABLE ImagenProducto(
IDImagen INT auto_increment primary key,
Imagen MEDIUMBLOB  NOT NULL,
FKProducto int not null COMMENT 'Indica el producto el cual pertenece esta imagen',
foreign key (FKProducto) references Producto(ID_PRO)
);
						
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

-- prueba de que solo salgan productos son pro estado 0 OSEA NO ELIMINADOS

DELIMITER //


  CREATE VIEW VistaFiltrarProductooo AS
SELECT 
    PRODUCTO.ID_PRO,
    PRODUCTO.PRO_NOMBRE, 
    PRODUCTO.PRO_DESCRIPCION, 
    PRODUCTO.PRO_PRECIOTOTAL, 
    PRODUCTO.PRO_TIPO,
    PRODUCTO_COTIZADO.PRO_APROBADO,
    ImagenProducto.Imagen AS Imagen,
    VideoProducto.Video AS Video
    
FROM PRODUCTO
LEFT JOIN PRODUCTO_COTIZADO ON PRODUCTO.ID_PRO = PRODUCTO_COTIZADO.ID_COTI
LEFT JOIN ImagenProducto ON PRODUCTO.ID_PRO = ImagenProducto.FKProducto
LEFT JOIN VideoProducto ON PRODUCTO.ID_PRO = VideoProducto.FKProducto
WHERE PRODUCTO.PRO_ESTADO <> 1; -- Esta condición excluye productos con PRO_ESTADO igual a 1




DELIMITER //
CREATE PROCEDURE EliminarProducto(IN c_producto_id INT)
BEGIN
    UPDATE PRODUCTO
    SET PRO_ESTADO = 1
    WHERE ID_PRO = c_producto_id;
END;

//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE ModificarProductoo(
    IN c_producto_id INT,
    IN c_nombre VARCHAR(255),
    IN c_descripcion VARCHAR(255),
    IN c_tipo INT,
    IN c_cantidad INT,
    IN c_categoria VARCHAR(255),
    IN c_precio_total FLOAT(2),
    IN c_material VARCHAR(70),
    IN c_medidas VARCHAR(70)
)
BEGIN
    -- Actualizar campos en la tabla PRODUCTO
    UPDATE PRODUCTO
    SET
        PRO_NOMBRE = c_nombre,
        PRO_DESCRIPCION = c_descripcion,
        PRO_TIPO = c_tipo,
        PRO_CANTIDAD = c_cantidad,
        PRO_CATEGORIA = c_categoria,
        PRO_PRECIOTOTAL = c_precio_total
    WHERE ID_PRO = c_producto_id;

    -- Actualizar campos en la tabla PRODUCTO_COTIZADO
    UPDATE PRODUCTO_COTIZADO
    SET
        PRO_MATERIAL = c_material,
        PRO_MEDIDAS = c_medidas
    WHERE ID_COTI = c_producto_id;
END;

//
DELIMITER ;

  DELIMITER //
 CREATE PROCEDURE FiltrarProductoComprarrVendedorr(IN productoIDParam INT)
 BEGIN
    SELECT 
        PRODUCTO.ID_PRO,
        PRODUCTO.PRO_NOMBRE, 
        PRODUCTO.PRO_DESCRIPCION, 
        PRODUCTO.PRO_PRECIOTOTAL, 
       PRODUCTO.PRO_CANTIDAD,
        PRODUCTO.PRO_TIPO,
        ImagenProducto.Imagen AS Imagen,
        VideoProducto.Video AS Video,
        PRODUCTO.id_usuario,
        usuario.Nombre AS Nombre -- Agregar el nombre del usuario
    FROM PRODUCTO
   LEFT JOIN ImagenProducto ON PRODUCTO.ID_PRO = ImagenProducto.FKProducto
    LEFT JOIN VideoProducto ON PRODUCTO.ID_PRO = VideoProducto.FKProducto
    LEFT JOIN usuario ON PRODUCTO.id_usuario = usuario.id -- Unir con la tabla usuario para obtener el nombre
    WHERE PRODUCTO.ID_PRO = productoIDParam;
 END//

 DELIMITER ;


DELIMITER //

CREATE PROCEDURE ModificarProducto(
    IN c_producto_id INT,
    IN c_nombre VARCHAR(255),
    IN c_descripcion VARCHAR(255),
    IN c_tipo INT,
    IN c_cantidad INT,
    IN c_categoria VARCHAR(255),
    IN c_precio_total FLOAT(2),
    IN c_material VARCHAR(70),
    IN c_medidas VARCHAR(70)
)
BEGIN
    -- Actualizar campos en la tabla PRODUCTO
    UPDATE PRODUCTO
    SET
        PRO_NOMBRE = c_nombre,
        PRO_DESCRIPCION = c_descripcion,
        PRO_TIPO = c_tipo,
        PRO_CANTIDAD = c_cantidad,
        PRO_CATEGORIA = c_categoria,
        PRO_PRECIOTOTAL = c_precio_total
    WHERE ID_PRO = c_producto_id;

    -- Actualizar campos en la tabla PRODUCTO_COTIZADO solo si PRO_TIPO es 2
    IF c_tipo = 2 THEN
        UPDATE PRODUCTO_COTIZADO
        SET
            PRO_MATERIAL = c_material,
            PRO_MEDIDAS = c_medidas
        WHERE ID_COTI = c_producto_id;
    END IF;
END;

//
DELIMITER ;