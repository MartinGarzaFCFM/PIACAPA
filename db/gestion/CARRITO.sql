

-- -------------------------------------------------------------------------------------------------lina CORRELOS 16-11-2023 AUN SIGO EN PROCESOOOO

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
        INSERT INTO CARRITO (ID_PRODUCTO, ID_USUARIO, CARR_CANTIDAD, CARR_PRECIO_UNITARIO, PRO_PRECIO_TOTAL_CALCULADO, CARR_FECHA_AGREGADO)
        VALUES (
            pIdProducto,
            pIdUsuario,
            pCantidad,
            vPrecioUnitario,
            vPrecioUnitario * pCantidad,
            NOW()
        );
        
    END IF;
     
END //
DELIMITER ;

-- para ver que existe el id usuario para agregar carrito
CREATE VIEW VistaInformacionUsuario AS
SELECT id
FROM usuario 
WHERE estado = 0;



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
    P.PRO_ESTADO = 0 AND C.ID_COTI IS NULL; 


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

-- para eliminar los productos del carrito
DELIMITER //

CREATE PROCEDURE EliminarProductoDelCarrito(IN carrito_id_param INT)
BEGIN
    DELETE FROM CARRITO WHERE ID_CARRITO = carrito_id_param;
END //

DELIMITER ;



-- para poder ver los productos cotizados.
CREATE VIEW vista_carrito_usuario_producto_cotizado AS
SELECT
    C.ID_CARRITO,
    C.ID_USUARIO,
    C.ID_PRODUCTO,
    C.ID_COTI,
    IP.Imagen AS ImagenProducto,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    C.CARR_CANTIDAD,
    C.CARR_PRECIO_UNITARIO,
    C.PRO_PRECIO_TOTAL_CALCULADO,
    C.CARR_FECHA_AGREGADO,
    CO.PRO_CADUCIDAD,
    CO.PRO_PRECIOUNITARIO,
    CO.PRO_MATERIAL,
    CO.PRO_MEDIDAS,
    CO.PRO_CANTIDAD
    
FROM
    CARRITO C
JOIN
    PRODUCTO P ON C.ID_PRODUCTO = P.ID_PRO
JOIN
    ImagenProducto IP ON P.ID_PRO = IP.FKProducto
LEFT JOIN
    COTIZACION CO ON C.ID_COTI = CO.ID_COTI
WHERE
    P.PRO_ESTADO = 0
    AND CO.COTIZACION_ESTADO = 0;





DELIMITER //
CREATE PROCEDURE vista_carrito_usuario_producto_cotizado(IN user_id_param INT)
BEGIN
    -- Realizar consultas directamente sobre la vista con joins y condiciones adicionales
  SELECT
    C.ID_CARRITO,
    C.ID_USUARIO,
    C.ID_PRODUCTO,
    C.ID_COTI,
    IP.Imagen AS ImagenProducto,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    C.CARR_CANTIDAD,
    C.CARR_PRECIO_UNITARIO,
    C.PRO_PRECIO_TOTAL_CALCULADO,
    C.CARR_FECHA_AGREGADO,
    CO.PRO_CADUCIDAD,
    CO.PRO_PRECIOUNITARIO,
    CO.PRO_MATERIAL,
    CO.PRO_MEDIDAS,
    CO.PRO_CANTIDAD
    FROM
        vista_carrito_usuario_producto_cotizado C
    JOIN
        PRODUCTO P ON C.ID_PRODUCTO = P.ID_PRO
    JOIN
        ImagenProducto IP ON P.ID_PRO = IP.FKProducto
    JOIN
        COTIZACION CO ON C.ID_COTI = CO.ID_COTI
    WHERE
        P.PRO_ESTADO = 0  AND CO.COTIZACION_ESTADO = 0
        AND C.ID_USUARIO = user_id_param;
END //
DELIMITER ;
-- Verificar productos cotizados
SELECT * FROM vista_carrito_usuario_producto_cotizado WHERE ID_USUARIO = 4;

-- Verificar productos en el carrito
SELECT * FROM CARRITO WHERE ID_USUARIO = 4;
-- el vendedor va poder ver los productos vencidos y el procedure cambia a cotizacion_estado 1 lo cual no podra verse en el carrito, y elimina del carrito el producto
DELIMITER //
CREATE PROCEDURE GestionarCotizacionesVencidas(OUT cotizacion_id INT)
BEGIN
    DECLARE fecha_actual DATE;
    SET fecha_actual = CURDATE();

    -- Actualizar el estado de cotizaciones vencidas
    UPDATE COTIZACION
    SET COTIZACION_ESTADO = 1
    WHERE PRO_CADUCIDAD < fecha_actual AND COTIZACION_ESTADO = 0;

    -- Obtener el id de la cotización afectada
    SELECT ID_COTI INTO cotizacion_id
    FROM COTIZACION
    WHERE PRO_CADUCIDAD < fecha_actual AND COTIZACION_ESTADO = 1
    LIMIT 1;

    -- Eliminar productos cotizados vencidos del carrito
    DELETE C
    FROM CARRITO C
    JOIN COTIZACION CO ON C.ID_COTI = CO.ID_COTI
    WHERE CO.PRO_CADUCIDAD < fecha_actual AND CO.COTIZACION_ESTADO = 1;

END //
DELIMITER ;


--  Se filtran los resultados para incluir solo aquellos donde 
-- la cotización está activa (COTIZACION_ESTADO = 0) y la fecha de caducidad es anterior a la fecha actual.
CREATE VIEW vista_para_eliminar_el_cotizado AS
SELECT
    CO.ID_COTI,
    CO.Vendedor,
    CO.Cliente,
    CO.ID_PRO,
    CO.FECHA_COTIZACION,
    CO.PRO_CADUCIDAD,
    CO.PRO_PRECIOUNITARIO,
    CO.PRO_MATERIAL,
    CO.PRO_MEDIDAS,
    CO.PRO_CANTIDAD,
    CO.COTIZACION_ESTADO,
    CO.PRO_APROBADO,
    CA.ID_CARRITO,
    CA.ID_USUARIO,
    CA.ID_PRODUCTO,
    CA.CARR_CANTIDAD,
    CA.CARR_PRECIO_UNITARIO,
    CA.PRO_PRECIO_TOTAL_CALCULADO,
    CA.CARR_FECHA_AGREGADO
FROM
    COTIZACION CO
JOIN
    CARRITO CA ON CO.ID_COTI = CA.ID_COTI
WHERE
    CO.COTIZACION_ESTADO = 0
    AND CO.PRO_CADUCIDAD < CURDATE();



-- para mandar esos datos importantea productovendedor.php
DELIMITER //

CREATE PROCEDURE vista_para_eliminar_el_cotizado(IN user_id_param INT)
BEGIN
    
    SELECT
        CO.ID_COTI,
        CO.Vendedor,
        CO.Cliente,
        CO.ID_PRO,
        CO.FECHA_COTIZACION,
        CO.PRO_CADUCIDAD,
        CO.PRO_PRECIOUNITARIO,
        CO.PRO_MATERIAL,
        CO.PRO_MEDIDAS,
        CO.PRO_CANTIDAD,
        CO.COTIZACION_ESTADO,
        CO.PRO_APROBADO,
        CA.ID_CARRITO,
        CA.ID_USUARIO,
        CA.ID_PRODUCTO,
        CA.CARR_CANTIDAD,
        CA.CARR_PRECIO_UNITARIO,
        CA.PRO_PRECIO_TOTAL_CALCULADO,
        CA.CARR_FECHA_AGREGADO
    FROM
			vista_para_eliminar_el_cotizado CO
    JOIN
        CARRITO CA ON CO.ID_COTI = CA.ID_COTI
    WHERE
        CO.COTIZACION_ESTADO = 0
        AND CO.PRO_CADUCIDAD < CURDATE()
        AND CO.Vendedor = user_id_param;
END //

DELIMITER ;





