use linea;
-- checar privacida para si se vera o no: en tabla usuario perfil

create table LISTA(
ID_LISTA int primary key auto_increment,
LIST_NOMBRE varchar (40),
LIST_DESCRIPCION varchar(70),
LIST_ESTADO BIT DEFAULT 0,
LIST_CREADOR int,
LIST_PRIVACIDAD int,
foreign key (LIST_CREADOR) references usuario (id)

);


-- Esta tabla garantiza que no podemos tener la misma combinación de ID_LISTA e ID_PRO más de una vez en la tabla LISTA_PRODUCTO,
CREATE TABLE LISTA_PRODUCTO (
    ID_LISTA INT,
    ID_PRO INT,
    LISTA_PRO_CANTIDAD  INT,
    PRO_PRECIO_TOTAL_CALCULADO FLOAT(2) COMMENT 'Indica el precio total calculado',
    PRIMARY KEY (ID_LISTA, ID_PRO),
    FOREIGN KEY (ID_LISTA) REFERENCES LISTA(ID_LISTA),
    FOREIGN KEY (ID_PRO) REFERENCES PRODUCTO(ID_PRO)
);



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


-- solo mostrara listas con el mismo id que hay en el sistema del usuario
CREATE VIEW VistaInformacionLista AS
SELECT ID_LISTA, LIST_CREADOR, LIST_NOMBRE, LIST_DESCRIPCION, LIST_PRIVACIDAD
FROM LISTA 
WHERE LIST_ESTADO = 0;


SELECT * FROM VistaInformacionLista WHERE LIST_CREADOR = 18;



SELECT * FROM VistaInformacionLista WHERE ID_LISTA = 1;



SELECT * FROM VistaListaProductoss WHERE ID_LISTA = 2;



CREATE VIEW VistaListaProductoss AS
SELECT
    LP.ID_LISTA,
    LP.ID_PRO,
    L.LIST_CREADOR AS ID_USUARIO_LISTA,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    P.PRO_PRECIOTOTAL,
    P.PRO_CANTIDAD,
    LP.LISTA_PRO_CANTIDAD, -- Agregada la columna LISTA_PRO_CANTIDAD
    LP.PRO_PRECIO_TOTAL_CALCULADO, -- Agregada la columna PRO_PRECIO_TOTAL_CALCULADO
    IP.Imagen
FROM
    LISTA_PRODUCTO LP
JOIN
    LISTA L ON LP.ID_LISTA = L.ID_LISTA
JOIN
    PRODUCTO P ON LP.ID_PRO = P.ID_PRO
LEFT JOIN
    ImagenProducto IP ON P.ID_PRO = IP.FKProducto;






SELECT
        ID_LISTA,
        ID_PRO,
        ID_USUARIO_LISTA,
        PRO_NOMBRE,
        PRO_DESCRIPCION,
        PRO_PRECIOTOTAL,
        PRO_CANTIDAD,
        Imagen
    FROM
        VistaListaProductoss
    WHERE
        ID_LISTA = 2 AND ID_USUARIO_LISTA = 19




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

CREATE PROCEDURE EliminarLista(IN c_lista_id INT)
BEGIN
    UPDATE LISTA
    SET LIST_ESTADO = 1
    WHERE ID_LISTA = c_lista_id;
END;

//
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

CREATE VIEW VistaInformacionProductooo AS
SELECT
    P.ID_PRO,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    P.PRO_TIPO,
    P.PRO_PRECIOTOTAL,
    P.PRO_CANTIDAD,
    P.PRO_CATEGORIA,
    PC.PRO_MATERIAL,
    PC.PRO_MEDIDAS,
    P.id_usuario AS PRO_ID_USUARIO,
    PC.ID_COTI
FROM
    PRODUCTO P
LEFT JOIN
    PRODUCTO_COTIZADO PC ON P.ID_PRO = PC.ID_COTI
WHERE
    (P.PRO_ESTADO = 0 AND PC.PRO_APROBADO = 1)
    OR (P.PRO_TIPO = 2 AND P.PRO_ESTADO = 0);
    
    

CREATE VIEW VistaProductosGestion AS
SELECT
    P.ID_PRO,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    P.PRO_TIPO,
    P.PRO_PRECIOTOTAL,
    P.PRO_CANTIDAD,
    P.PRO_CATEGORIA  -- Modificado aquí
FROM
    PRODUCTO P
LEFT JOIN
    PRODUCTO_COTIZADO PC ON P.ID_PRO = PC.ID_COTI;
 