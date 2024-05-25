-- ----------------------------------------
DELIMITER //

CREATE PROCEDURE BuscarProductos(IN busqueda VARCHAR(255))
BEGIN
    SELECT P.*, IP.Imagen
    FROM PRODUCTO P
    LEFT JOIN ImagenProducto IP ON P.ID_PRO = IP.FKProducto
    LEFT JOIN PRODUCTO_COTIZADO PC ON P.ID_PRO = PC.ID_COTI
    WHERE (P.PRO_NOMBRE LIKE CONCAT('%', busqueda, '%') OR
           P.PRO_DESCRIPCION LIKE CONCAT('%', busqueda, '%'))
          AND P.PRO_ESTADO = 0
          AND (PC.PRO_APROBADO = 1 OR PC.PRO_APROBADO IS NULL);
END //

DELIMITER ;
-- ------------------------------------
DELIMITER //

CREATE PROCEDURE ObtenerProductosAdimin()
BEGIN
    SELECT P.PRO_NOMBRE
    FROM PRODUCTO_COTIZADO PC
    INNER JOIN PRODUCTO P ON PC.ID_COTI = P.ID_PRO
    WHERE PC.PRO_APROBADO = 1;
END//

DELIMITER ;

DELIMITER //

CREATE PROCEDURE ObtenerProductosVendedor(IN vendedorID INT)
BEGIN
    SELECT P.PRO_NOMBRE, P.PRO_ESTADO,PC.PRO_APROBADO, P.ID_PRO
    FROM PRODUCTO P
    JOIN usuario U ON P.id_usuario = U.id
    LEFT JOIN PRODUCTO_COTIZADO PC ON P.ID_PRO = PC.ID_COTI
    WHERE U.rol = 2 AND U.id = vendedorID AND P.PRO_ESTADO = 0 AND (PC.PRO_APROBADO = 1 OR PC.PRO_APROBADO IS NULL);
END//

DELIMITER ;


DELIMITER //
CREATE PROCEDURE ObtenerListasPorUsuario(IN usuario_id INT)
BEGIN
    SELECT
        L.ID_LISTA,
        L.LIST_NOMBRE,
        L.LIST_DESCRIPCION,
        L.LIST_ESTADO,
        U.usuario AS LIST_CREADOR,
        L.LIST_PRIVACIDAD
    FROM
        LISTA L
    JOIN
        usuario U ON L.LIST_CREADOR = U.id
    WHERE
        U.id = usuario_id AND
        L.LIST_ESTADO = 0 AND
        L.LIST_PRIVACIDAD=1;
END //
DELIMITER ;




-- -------------------------------
CREATE VIEW VistaCategorias AS
SELECT CAT_NOMBRE FROM CATEGORIAS WHERE CAT_ESTADO = 0;

-- prueba 11 18 2023
CREATE VIEW Vista_Cat_egorias AS
SELECT CAT_ID, CAT_NOMBRE FROM CATEGORIAS WHERE CAT_ESTADO = 0;
   
CREATE VIEW Vista_Productos_Categoria AS
SELECT
    P.ID_PRO,
    P.PRO_NOMBRE,
    P.PRO_DESCRIPCION,
    P.PRO_PRECIOTOTAL,
    C.CAT_ID,
    ImagenProducto.Imagen AS Imagen
FROM
    PRODUCTO P
JOIN
    CATEGORIAS C ON P.PRO_CATEGORIA = C.CAT_NOMBRE
    LEFT JOIN ImagenProducto ON P.ID_PRO = ImagenProducto.FKProducto

WHERE
    C.CAT_ESTADO = 0
    AND P.PRO_ESTADO = 0;

SELECT * FROM Vista_Productos_Categoria WHERE CAT_ID = 2 


