use linea;
drop table compra;
create table compra (
id_compra int primary key auto_increment,
comprador int,
id_pro int,
cant_pro int,
fecha_compra date,
precio float,
estatus tinyint,
id_carrito int,
id_coti int,
foreign key (comprador)references usuario (id),
foreign key (id_pro)references producto (id_pro),
foreign key (id_carrito)references carrito (id_carrito),
foreign key (id_coti) references cotizacion(id_coti)
);

DELIMITER //

CREATE PROCEDURE ConsultarCompras(
    IN fecha_inicio_param DATE,
    IN fecha_fin_param DATE,
    IN categoria_param VARCHAR(255),
    IN id_usuario_param INT
)
BEGIN
    SELECT 
        fecha_compra AS 'Fecha y Hora de Compra',
        producto.pro_categoria AS 'Categoría',
        producto.pro_nombre AS 'Producto',
        precio
    FROM 
        compra
    JOIN 
        producto ON compra.id_pro = producto.id_pro
    LEFT JOIN 
        cotizacion ON compra.id_coti = cotizacion.id_coti
    WHERE 
        (fecha_compra BETWEEN fecha_inicio_param AND fecha_fin_param OR fecha_inicio_param IS NULL OR fecha_fin_param IS NULL)
        AND (producto.pro_categoria = categoria_param OR categoria_param IS NULL)
        AND compra.comprador = id_usuario_param;
END //

DELIMITER ;

CALL ConsultarCompras('2023-11-19', '2023-11-19', null, 3);
CALL ConsultarCompras('2023-11-19', '2023-11-19', 'Lacteos', 3);

-- venta
DELIMITER //

CREATE PROCEDURE ConsultarComprasVendedor(
    IN fecha_inicio_param DATE,
    IN fecha_fin_param DATE,
    IN categoria_param VARCHAR(255),
    IN id_usuario_param INT
)
BEGIN
    -- Consulta Detallada
    SELECT 
        compra.fecha_compra AS 'Fecha y Hora de la Venta',
        producto.pro_categoria AS 'Categoría',
        producto.pro_nombre AS 'Producto',
        CASE
            WHEN producto.PRO_TIPO = 1 THEN cotizacion.PRO_CANTIDAD
            WHEN producto.PRO_TIPO = 2 THEN producto.PRO_CANTIDAD
            ELSE NULL
        END AS 'Cantidad',
        compra.precio AS 'Precio'
    FROM 
        compra
    JOIN 
        producto ON compra.id_pro = producto.id_pro
    JOIN 
        usuario ON producto.id_usuario = usuario.id
    LEFT JOIN 
        cotizacion ON compra.id_coti = cotizacion.id_coti
    WHERE 
        (compra.fecha_compra BETWEEN fecha_inicio_param AND fecha_fin_param OR fecha_inicio_param IS NULL OR fecha_fin_param IS NULL)
        AND usuario.rol = 2
        AND usuario.id = id_usuario_param
        AND (categoria_param IS NULL OR producto.pro_categoria = categoria_param);

END //
-- FILTRO PRODUCTO 

DELIMITER //

CREATE PROCEDURE ConsultarProductosVendedor(
    IN categoria_param VARCHAR(255),
    IN id_usuario_param INT
)
BEGIN
    SELECT
        producto.pro_nombre AS 'Nombre del Producto',
        producto.pro_categoria AS 'Categoría',
        CASE
            WHEN producto.PRO_TIPO = 1 THEN cotizacion.PRO_CANTIDAD
            ELSE producto.PRO_CANTIDAD
        END AS 'Existencia Disponible',
        producto.PRO_PRECIOTOTAL AS 'Precio Total'
    FROM
        producto
    LEFT JOIN
        cotizacion ON producto.id_pro = cotizacion.id_pro
    WHERE
        (producto.pro_categoria = categoria_param OR categoria_param IS NULL)
        AND producto.id_usuario = id_usuario_param
    ORDER BY
        producto.pro_nombre;
END //

DELIMITER ;
CALL ConsultarProductosVendedor('Cotizables', 2);
CALL ConsultarComprasVendedor('2023-11-19', '2023-11-19', null, 2);
CALL ConsultarComprasVendedor('2023-11-19', '2023-11-19', 'Lacteos', 2);