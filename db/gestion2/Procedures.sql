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

DELIMITER //
CREATE PROCEDURE AgregarProductoAListaCantidad(
    IN pIdLista INT,
    IN pIdProducto INT,
    IN pIdUsuario INT,
    IN pCantidad INT -- Nueva variable para la cantidad
)
BEGIN
    DECLARE vUsuarioValido INT;
    DECLARE vExistencia INT;

    -- Obtener la existencia del producto
    SELECT PRO_CANTIDAD INTO vExistencia
    FROM PRODUCTO
    WHERE ID_PRO = pIdProducto;

    -- Verifica si el usuario tiene permisos para agregar a la lista
    SELECT COUNT(*) INTO vUsuarioValido
    FROM VistaInformacionLista
    WHERE ID_LISTA = pIdLista AND LIST_CREADOR = pIdUsuario;

    IF vUsuarioValido > 0 THEN
        -- Usuario válido, procede con la inserción si la cantidad no supera la existencia
        IF pCantidad <= vExistencia THEN
            -- Insertar en la tabla LISTA_PRODUCTO
            INSERT INTO LISTA_PRODUCTO (ID_LISTA, ID_PRO, LISTA_PRO_CANTIDAD)
            VALUES (pIdLista, pIdProducto, pCantidad);

            -- Calcular PRO_PRECIO_TOTAL_CALCULADO
            UPDATE LISTA_PRODUCTO
            SET PRO_PRECIO_TOTAL_CALCULADO = (SELECT PRO_PRECIOTOTAL FROM PRODUCTO WHERE ID_PRO = pIdProducto) * pCantidad
            WHERE ID_LISTA = pIdLista AND ID_PRO = pIdProducto;

            SELECT 'Producto agregado a la lista con éxito.' AS mensaje;
        ELSE
            -- La cantidad supera la existencia, emite un mensaje de error
            SELECT 'Error: La cantidad ingresada supera la existencia del producto.' AS mensaje;
        END IF;
    ELSE
        -- Usuario no válido, emite un mensaje de error
        SELECT 'Error: Usuario no autorizado para agregar a esta lista.' AS mensaje;
    END IF;
END //
DELIMITER ;

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
    DECLARE cotizacion_aprobada INT;
 DECLARE caducidad_calculada DATE;
    -- Calcular la fecha de caducidad sumando 3 días a la fecha de cotización
   SET caducidad_calculada = DATE_ADD(NOW(), INTERVAL 3 DAY);

    -- Insertar en la tabla COTIZACION
    INSERT INTO COTIZACION (Vendedor, Cliente, ID_PRO, FECHA_COTIZACION, PRO_PRECIOUNITARIO, PRO_MATERIAL, PRO_MEDIDAS, PRO_CADUCIDAD, PRO_APROBADO, PRO_CANTIDAD)
    VALUES (vendedor_id, cliente_id, producto_id, NOW(), precio_unitario, material, medidas, caducidad_calculada, 1, cantidad);

    -- Obtener el ID de la cotización recién insertada
    SET cotizacion_id = LAST_INSERT_ID();

    -- Verificar si la cotización está aprobada
    SELECT PRO_APROBADO INTO cotizacion_aprobada FROM COTIZACION WHERE ID_COTI = cotizacion_id;

    IF cotizacion_aprobada = 1 THEN
        -- Calcular el precio total
        SET precio_total_calculado = precio_unitario * cantidad;

        -- Insertar en la tabla CARRITO
        INSERT INTO CARRITO (ID_USUARIO, ID_PRODUCTO, ID_COTI, CARR_CANTIDAD, CARR_PRECIO_UNITARIO, PRO_PRECIO_TOTAL_CALCULADO, CARR_FECHA_AGREGADO)
        VALUES (cliente_id, producto_id, cotizacion_id, cantidad, precio_unitario, precio_total_calculado, NOW());
    END IF;
END //

DELIMITER ;



DELIMITER //
CREATE PROCEDURE AprobarProductoCotizado(IN p_ID_COTI INT)
BEGIN
    UPDATE PRODUCTO_COTIZADO
    SET PRO_APROBADO = 1
    WHERE ID_COTI = p_ID_COTI;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE EditarCategoria(
    IN c_cat_id INT,
    IN nuevo_nombre VARCHAR(40),
    IN nueva_descripcion VARCHAR(70)
)
BEGIN
    UPDATE CATEGORIAS
    SET 
        CAT_NOMBRE = nuevo_nombre,
        CAT_DESC = nueva_descripcion
    WHERE CAT_ID = c_cat_id;
END;

//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE EliminarCategoria(IN c_cat_id INT)
BEGIN
    UPDATE CATEGORIAS
    SET CAT_ESTADO = 1
    WHERE CAT_ID = c_cat_id;
END;

//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE EliminarLista(IN c_lista_id INT)
BEGIN
    UPDATE LISTA
    SET LIST_ESTADO = 1
    WHERE ID_LISTA = c_lista_id;
END;

//
DELIMITER ;


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

CREATE PROCEDURE EliminarProductoCotizado(IN c_id_coti INT)
BEGIN
    DELETE FROM PRODUCTO_COTIZADO
    WHERE ID_COTI = c_id_coti;
END;

//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE EliminarProductoDelCarrito(IN carrito_id_param INT)
BEGIN
    DELETE FROM CARRITO WHERE ID_CARRITO = carrito_id_param;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE EliminarProductoDeLista(
    IN pIdLista INT,
    IN pIdProducto INT,
    IN pIdUsuario INT
)
BEGIN
    DECLARE vUsuarioValido INT;

    -- Verifica si el usuario tiene permisos para eliminar de la lista
    SELECT COUNT(*) INTO vUsuarioValido
    FROM VistaInformacionLista
    WHERE ID_LISTA = pIdLista AND LIST_CREADOR = pIdUsuario;

    IF vUsuarioValido > 0 THEN
        -- Usuario válido, procede con la eliminación
        -- Eliminar el producto de la tabla LISTA_PRODUCTO
        DELETE FROM LISTA_PRODUCTO
        WHERE ID_LISTA = pIdLista AND ID_PRO = pIdProducto;

        SELECT 'Producto eliminado de la lista con éxito.' AS mensaje;
    ELSE
        -- Usuario no válido, emite un mensaje de error
        SELECT 'Error: Usuario no autorizado para eliminar de esta lista.' AS mensaje;
    END IF;
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

DELIMITER //

CREATE PROCEDURE InsertarCategoria(
    IN p_NombreCategoria VARCHAR(40),
    IN p_DescripcionCategoria VARCHAR(70),
    IN p_CreadorID INT
)
BEGIN
    DECLARE categoriaID INT;

    -- Insertar la nueva categoría en la tabla CATEGORIAS
    INSERT INTO CATEGORIAS (CAT_NOMBRE, CAT_DESC, CAT_CREADOR, CAT_ALTA)
    VALUES (p_NombreCategoria, p_DescripcionCategoria, p_CreadorID, CURDATE());

    -- Obtener el ID de la categoría recién insertada
    SET categoriaID = LAST_INSERT_ID();

    -- Devolver el ID de la categoría insertada
    SELECT categoriaID AS 'ID_CATEGORIA';
END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE InsertarConversacion(
    IN usuario1_param INT,
    IN usuario2_param INT,
    IN producto_id_param INT
)
BEGIN
    DECLARE nueva_conversacion_id INT;

    -- Inserta una nueva conversación
    INSERT INTO CONVERSACION (usuario1, usuario2, producto_id)
    VALUES (usuario1_param, usuario2_param, producto_id_param);

    -- Obtiene el ID de la conversación recién creada
    SET nueva_conversacion_id = LAST_INSERT_ID();

    -- Puedes devolver el ID de la conversación si es necesario
    SELECT nueva_conversacion_id AS id_conversacion;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE InsertarLista(
    IN nombreLista VARCHAR(40),
    IN descripcionLista VARCHAR(70),
	IN privacidadLista INT,
	IN id_usuario INT
   
)
BEGIN
    -- Insertar en la tabla LISTA
    INSERT INTO LISTA (LIST_NOMBRE, LIST_DESCRIPCION, LIST_PRIVACIDAD, LIST_CREADOR)
    VALUES (nombreLista, descripcionLista, privacidadLista, id_usuario);
    
    COMMIT;
END //

DELIMITER ;


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


DELIMITER //
CREATE PROCEDURE ModificarLista(
    IN p_ID_LISTA INT,
    IN p_LIST_NOMBRE VARCHAR(40),
    IN p_LIST_DESCRIPCION VARCHAR(70),
    IN p_LIST_PRIVACIDAD INT
)
BEGIN
    UPDATE LISTA
    SET
        LIST_NOMBRE = p_LIST_NOMBRE,
        LIST_DESCRIPCION = p_LIST_DESCRIPCION,
        LIST_PRIVACIDAD = p_LIST_PRIVACIDAD
    WHERE
        ID_LISTA = p_ID_LISTA;
END //
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
CREATE PROCEDURE sp_insertar_mensaje(
    IN p_mensaje VARCHAR(200),
    IN p_remitente INT,
    IN p_destinatario INT,
    IN p_conversacion_id INT,
    IN p_producto_id INT
)
BEGIN
    INSERT INTO MENSAJE (MSJ_MENSAJE, MSJ_REMITENTE, MSJ_DESTINATARIO, conversacion_id, producto_id)
    VALUES (p_mensaje, p_remitente, p_destinatario, p_conversacion_id, p_producto_id);
END //
DELIMITER ;

DELIMITER //

CREATE PROCEDURE ObtenerInformacionProductoCotizado(IN producto_id INT)
BEGIN
    SELECT 
     ID_PRO,
        PRO_MEDIDAS,
        PRO_MATERIAL,
         ID_COTI,
         PRO_PRECIOTOTAL,
        PRO_ESTADO,
        PRO_CANTIDAD
    FROM vistainformacionproductooo
    WHERE ID_PRO = producto_id;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE ObtenerInformacionProductoCotizadoCHAT(IN producto_id INT)
BEGIN
    SELECT 
     ID_PRO,
        PRO_MEDIDAS,
        PRO_MATERIAL,
         ID_COTI,
         PRO_PRECIOTOTAL,
        PRO_ESTADO,
        PRO_CANTIDAD,
        PRO_PRECIOUNITARIO
    FROM VistaParaChatCotizado
    WHERE ID_PRO = producto_id;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE VerificarCredenciales(IN p_usuario VARCHAR(255), IN p_password VARCHAR(255))
BEGIN
    SELECT * FROM usuario WHERE usuario = p_usuario AND contrasena = p_password;
END //
DELIMITER ;

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