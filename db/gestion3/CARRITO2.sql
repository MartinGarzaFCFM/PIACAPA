  -- -------------------------------------------- lina crear esta tabla  CARRITO2
CREATE TABLE CARRITO2 (
    ID_CARRITO INT AUTO_INCREMENT PRIMARY KEY,
    ID_USUARIO INT NOT NULL,
    ID_PRODUCTO INT NOT NULL,
    ID_COTI INT,  -- Nueva columna para relacionar con la cotización
    CARR_CANTIDAD INT NOT NULL,
     CARR_PRECIO_UNITARIO FLOAT(2),  -- Precio unitario de la cotización
     PRO_PRECIO_TOTAL_CALCULADO FLOAT(2),  -- Se calculará en base a CANTIDAD * PRECIO_UNITARIO
     CARR_FECHA_AGREGADO DATE NOT NULL,
    FOREIGN KEY (ID_USUARIO) REFERENCES usuario (id),
    FOREIGN KEY (ID_PRODUCTO) REFERENCES PRODUCTO (ID_PRO),
    FOREIGN KEY (ID_COTI) REFERENCES COTIZACION (ID_COTI)
);
alter table carrito2 add carr_estatus int;
-- -------------------------------------------------------------------------------------------------lina CORRELOS 16-11-2023 AUN SIGO EN PROCESOOOO
-- -------------------------------------------- lina agregar estatus carrito
CREATE TABLE CARRITO (
    ID_CARRITO INT AUTO_INCREMENT PRIMARY KEY,
    ID_USUARIO INT NOT NULL,
    ID_PRODUCTO INT NOT NULL,
    ID_COTI INT,  -- Nueva columna para relacionar con la cotización
    CARR_CANTIDAD INT NOT NULL,
     CARR_PRECIO_UNITARIO FLOAT(2),  -- Precio unitario de la cotización
     PRO_PRECIO_TOTAL_CALCULADO FLOAT(2),  -- Se calculará en base a CANTIDAD * PRECIO_UNITARIO
     CARR_FECHA_AGREGADO DATE NOT NULL,
    FOREIGN KEY (ID_USUARIO) REFERENCES usuario (id),
    FOREIGN KEY (ID_PRODUCTO) REFERENCES PRODUCTO (ID_PRO),
    FOREIGN KEY (ID_COTI) REFERENCES COTIZACION (ID_COTI)
);
alter table carrito add carr_estatus int;

-- -------------------------------------------- lina crear esta  agregar_productonormal_carrito

drop procedure agregar_productonormal_carrito;

-- el producto cotizado lo doy de alta  junto con carrito 
DELIMITER //
CREATE PROCEDURE Agregar_ProductoNormal_Carrito(
    IN pIdProducto INT,
    IN pIdUsuario INT,
    IN pCantidad INT -- Nueva variable para la cantidad
)
BEGIN
     DECLARE vUsuarioValido INT;
    DECLARE vExistencia INT;
   DECLARE vPrecioUnitario FLOAT(2);
   
    -- Obtener la existencia del producto
 SELECT PRO_CANTIDAD, PRO_PRECIOTOTAL INTO vExistencia, vPrecioUnitario
    FROM PRODUCTO
    WHERE ID_PRO = pIdProducto;
    
      -- Verifica si el usuario tiene permisos para agregar a la lista
    SELECT COUNT(*) INTO vUsuarioValido
    FROM VistaInformacionUsuario
    WHERE id = pIdUsuario;
    
    
     IF vUsuarioValido > 0 AND pCantidad <= vExistencia THEN
        -- Insertar en la tabla CARRITO
        INSERT INTO CARRITO (ID_PRODUCTO, ID_USUARIO, CARR_CANTIDAD, CARR_PRECIO_UNITARIO, PRO_PRECIO_TOTAL_CALCULADO, CARR_FECHA_AGREGADO,carr_estatus)
        VALUES (
            pIdProducto,
            pIdUsuario,
            pCantidad,
            vPrecioUnitario,
            vPrecioUnitario * pCantidad,
            NOW(),
            0
        );
        
    END IF;
     
END //
DELIMITER ;
-- -------------------------------------------- lina crear esta agregar_productonormal_carrito

-- ----------------------------------------------------- lina crear esta  vista_carrito_usuario_producto
-- ALAN drop la vista y volverla a crear
drop view vista_carrito_usuario_producto;
-- para ver los productos normales en carrito
CREATE VIEW vista_carrito_usuario_producto AS
SELECT
    C.ID_CARRITO,
    C.ID_USUARIO,
    C.ID_PRODUCTO,
    IP.Imagen AS ImagenProducto,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    C.CARR_CANTIDAD,
    C.CARR_PRECIO_UNITARIO,
    C.PRO_PRECIO_TOTAL_CALCULADO,
    C.CARR_FECHA_AGREGADO
FROM
    CARRITO C
JOIN
    PRODUCTO P ON C.ID_PRODUCTO = P.ID_PRO
JOIN
    ImagenProducto IP ON P.ID_PRO = IP.FKProducto
WHERE
    P.PRO_ESTADO = 0 AND C.ID_COTI IS NULL and carr_estatus=0; 

-- ----------------------------------------------------- lina crear esta  vista_carrito_usuario_producto
DELIMITER //
CREATE PROCEDURE vista_carrito_usuario_producto(IN user_id_param INT)
BEGIN
    -- Realizar consultas directamente sobre la vista con joins y condiciones adicionales
    SELECT
        C.ID_CARRITO,
        C.ID_USUARIO,
        C.ID_PRODUCTO,
        IP.Imagen AS ImagenProducto,
        P.PRO_NOMBRE,
        P.PRO_DESCRIPCION,
        C.CARR_CANTIDAD,
        C.CARR_PRECIO_UNITARIO,
        C.PRO_PRECIO_TOTAL_CALCULADO,
        C.CARR_FECHA_AGREGADO
    FROM
        vista_carrito_usuario_producto C
    JOIN
        PRODUCTO P ON C.ID_PRODUCTO = P.ID_PRO
    JOIN
        ImagenProducto IP ON P.ID_PRO = IP.FKProducto
    WHERE
        P.PRO_ESTADO = 0
        AND C.ID_USUARIO = user_id_param;
END //
DELIMITER ;

-- ----------------------------------------------------- lina crear esta  EliminarProductoDelCarrito
DELIMITER //
drop procedure EliminarProductoDelCarrito;
delimiter //
CREATE PROCEDURE EliminarProductoDelCarrito(IN carrito_id_param INT)
BEGIN
update carrito
set carr_estatus = 1
where ID_CARRITO=carrito_id_param;
END //

DELIMITER ;
-- ----------------------------------------------------- lina crear esta  EliminarProductoDelCarrito

-- Verificar productos cotizados
SELECT * FROM vista_carrito_usuario_producto_cotizado WHERE ID_USUARIO = 4;

-- Verificar productos en el carrito
SELECT * FROM CARRITO WHERE ID_USUARIO = 4;






