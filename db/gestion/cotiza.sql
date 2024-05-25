-- -------------------------------------------------------------------------------------------------lina CORRELOS 16-11-2023

use linea;

CREATE TABLE COTIZACION (
    ID_COTI INT AUTO_INCREMENT PRIMARY KEY,
    Vendedor INT,
     Cliente INT,
   
    ID_PRO INT,
    FECHA_COTIZACION DATE,
    PRO_PRECIOUNITARIO FLOAT(2),
    PRO_MATERIAL VARCHAR(70),
    PRO_MEDIDAS VARCHAR(70),
    PRO_CADUCIDAD DATE,
     PRO_CANTIDAD INT,
     COTIZACION_ESTADO BIT DEFAULT 0,
    PRO_APROBADO BIT DEFAULT 0,
    FOREIGN KEY (ID_PRO) REFERENCES PRODUCTO (ID_PRO),
    FOREIGN KEY (Vendedor) REFERENCES usuario (id),
    FOREIGN KEY (Cliente) REFERENCES usuario (id)
);

DELIMITER //

CREATE PROCEDURE AltaCotizacionCarrito(
    IN vendedor_id INT,
    IN cliente_id INT,
    IN producto_id INT,
    IN precio_unitario FLOAT(2),
    IN material VARCHAR(70),
    IN medidas VARCHAR(70),
    IN cantidad INT  -- Nuevo parámetro
)
BEGIN
    DECLARE cotizacion_id INT;
    DECLARE precio_total_calculado FLOAT(2);
 --   DECLARE cotizacion_aprobada INT;
 DECLARE caducidad_calculada DATE;
    -- Calcular la fecha de caducidad sumando 3 días a la fecha de cotización
   SET caducidad_calculada = DATE_ADD(NOW(), INTERVAL 3 DAY);

    -- Insertar en la tabla COTIZACION
    INSERT INTO COTIZACION (Vendedor, Cliente, ID_PRO, FECHA_COTIZACION, PRO_PRECIOUNITARIO, PRO_MATERIAL, PRO_MEDIDAS, PRO_CADUCIDAD, PRO_APROBADO, PRO_CANTIDAD)
    VALUES (vendedor_id, cliente_id, producto_id, NOW(), precio_unitario, material, medidas, caducidad_calculada, 1, cantidad);

    -- Obtener el ID de la cotización recién insertada
    SET cotizacion_id = LAST_INSERT_ID();

    -- Verificar si la cotización está aprobada
   -- SELECT PRO_APROBADO INTO cotizacion_aprobada FROM COTIZACION WHERE ID_COTI = cotizacion_id;

   -- IF cotizacion_aprobada = 1 THEN
        -- Calcular el precio total
        SET precio_total_calculado = precio_unitario * cantidad;

        -- Insertar en la tabla CARRITO
        INSERT INTO CARRITO (ID_USUARIO, ID_PRODUCTO, ID_COTI, CARR_CANTIDAD, CARR_PRECIO_UNITARIO, PRO_PRECIO_TOTAL_CALCULADO, CARR_FECHA_AGREGADO, carr_estatus)
        VALUES (cliente_id, producto_id, cotizacion_id, cantidad, precio_unitario, precio_total_calculado, NOW(), 0);
   -- END IF;
END //

DELIMITER ;


