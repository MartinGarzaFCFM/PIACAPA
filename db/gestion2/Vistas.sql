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

-- 
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
-- 

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
    
 --
 
CREATE VIEW Vista_Categorias AS
SELECT CAT_ID, CAT_NOMBRE, CAT_DESC, CAT_CREADOR
FROM CATEGORIAS
 WHERE CAT_ESTADO = 0;
 
 --
 
 CREATE VIEW vista_conversaciones_info AS
SELECT 
    C.*,
    (SELECT Nombre FROM usuario WHERE id = C.usuario1) as RemitenteNombre,
    (SELECT Nombre FROM usuario WHERE id = C.usuario2) as DestinatarioNombre,
    P.PRO_NOMBRE as ProductoNombre
FROM CONVERSACION C
INNER JOIN producto P ON C.producto_id = P.ID_PRO
WHERE C.usuario2 = C.usuario2;

--

CREATE VIEW vista_conversacion_existente AS
SELECT
    usuario1,
    usuario2,
    producto_id,
    id_conversacion
FROM
    conversacion;
    
    --
    
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


-- 

CREATE VIEW VistaCategorias AS
SELECT CAT_NOMBRE FROM CATEGORIAS WHERE CAT_ESTADO = 0;

-- 

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
WHERE 
    (PRODUCTO.PRO_TIPO = 2) OR -- Incluye todos los productos con PRO_TIPO=2
    (PRODUCTO.PRO_TIPO = 1 AND PRODUCTO_COTIZADO.PRO_APROBADO = 1); -- Incluye solo productos con PRO_TIPO=1 y PRO_APROBADO=1

--

CREATE VIEW VistaInformacionLista AS
SELECT ID_LISTA, LIST_CREADOR, LIST_NOMBRE, LIST_DESCRIPCION, LIST_PRIVACIDAD
FROM LISTA 
WHERE LIST_ESTADO = 0;

--

CREATE VIEW vistainformacionproductooo AS
SELECT
    p.ID_PRO AS ID_PRO,
    p.PRO_NOMBRE AS PRO_NOMBRE,
    p.PRO_DESCRIPCION AS PRO_DESCRIPCION,
    p.PRO_TIPO AS PRO_TIPO,
    p.PRO_PRECIOTOTAL AS PRO_PRECIOTOTAL,
    p.PRO_CANTIDAD AS PRO_CANTIDAD,
    p.PRO_CATEGORIA AS PRO_CATEGORIA,
    pc.PRO_MATERIAL AS PRO_MATERIAL,
    pc.PRO_MEDIDAS AS PRO_MEDIDAS,
    p.id_usuario AS PRO_ID_USUARIO,
    pc.ID_COTI AS ID_COTI
FROM
    (producto p
        LEFT JOIN producto_cotizado pc ON (p.ID_PRO = pc.ID_COTI))
WHERE
    p.PRO_ESTADO = 0
    AND (pc.PRO_APROBADO = 1 OR p.PRO_TIPO = 2)
    AND p.PRO_ESTADO = 0;

--

CREATE VIEW VistaInformacionUsuario AS
SELECT id
FROM usuario 
WHERE estado = 0;

    SELECT *
    FROM VistaInformacionUsuario
    WHERE id = 19;

--

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
    
    --
    
    CREATE VIEW VistaParaVerUsuYconversacion AS
SELECT
    C.id_conversacion,
    C.usuario1 AS remitente,
    C.usuario2 AS destinatario,
    C.producto_id
FROM
    conversacion C;

--
CREATE VIEW VistaParaChatCotizado AS
SELECT
    p.ID_PRO AS ID_PRO,
    p.PRO_NOMBRE AS PRO_NOMBRE,
    p.PRO_DESCRIPCION AS PRO_DESCRIPCION,
    p.PRO_TIPO AS PRO_TIPO,
    p.PRO_PRECIOTOTAL AS PRO_PRECIOTOTAL,
    p.PRO_CANTIDAD AS PRO_CANTIDAD,
    p.PRO_CATEGORIA AS PRO_CATEGORIA,
    pc.PRO_MATERIAL AS PRO_MATERIAL,
    pc.PRO_MEDIDAS AS PRO_MEDIDAS,
    p.id_usuario AS PRO_ID_USUARIO,
    pc.ID_COTI AS ID_COTI,
    pc.PRO_PRECIOUNITARIO AS PRO_PRECIOUNITARIO,
     pc.PRO_CADUCIDAD AS PRO_CADUCIDAD,
   
     p.PRO_ESTADO AS PRO_ESTADO
FROM
    (producto p
        LEFT JOIN producto_cotizado pc ON (p.ID_PRO = pc.ID_COTI))
WHERE
    p.PRO_ESTADO = 0
    AND (pc.PRO_APROBADO = 1 OR p.PRO_TIPO = 2)
    AND p.PRO_ESTADO = 0;
 
--

CREATE VIEW VistaMensajesConversacion AS
SELECT 
    m.MSJ_ID,
    m.MSJ_MENSAJE,
    m.MSJ_REMITENTE,
    m.MSJ_DESTINATARIO,
    m.MSJ_FECHA,
    m.MSJ_LEIDO,
    m.conversacion_id,
    c.usuario1,
    c.usuario2
FROM MENSAJE m
JOIN CONVERSACION c ON m.conversacion_id = c.id_conversacion;

--

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