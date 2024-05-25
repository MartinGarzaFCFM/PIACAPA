
create table CATEGORIAS(
CAT_ID int primary key auto_increment  COMMENT 'PK DE CATEGORIAS',
CAT_NOMBRE varchar(40) COMMENT 'NOMBRE DE LA CATEGORIA',
CAT_DESC varchar(70)  COMMENT 'DESCRIPCION DE LA CATEGORIA',
CAT_CREADOR int COMMENT 'PK DE TABLA USUARIOS',
   CAT_ESTADO BIT NOT NULL DEFAULT 0  COMMENT 'ESTADO DE LA TABLA',
   CAT_ALTA  DATE NOT NULL COMMENT 'FECHA EN QUE SE CREO LA CATEGORIA',
foreign key (CAT_CREADOR)references usuario (id)
);

create table CATEGORIA_PRODUCTO(
ID_CATPRO int primary key auto_increment,
CAT_ID int   COMMENT 'PK DE CATEGORIAS',
ID_PRO int  COMMENT 'PK DE PRODUCTO',
foreign key (CAT_ID)references CATEGORIAS (CAT_ID),
foreign key (ID_PRO)references PRODUCTO (ID_PRO) 
);

DELIMITER //
CREATE PROCEDURE FiltrarProductosPorCategoria(IN categoria VARCHAR(255))
BEGIN
    SELECT * FROM PRODUCTO WHERE PRO_CATEGORIA = categoria;
END //
DELIMITER ;
CALL FiltrarProductosPorCategoria('VideoJuegos');


SELECT p.ID_PRO, p.PRO_NOMBRE, p.PRO_DESCRIPCION, p.PRO_PRECIOTOTAL, ip.Imagen
FROM PRODUCTO AS p
LEFT JOIN ImagenProducto AS ip ON p.ID_PRO = ip.FKProducto
WHERE p.PRO_CATEGORIA = 'nombre_de_la_categoria';





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
    IP.Imagen AS ImagenProducto
FROM
    PRODUCTO P
JOIN
    CATEGORIAS C ON P.PRO_CATEGORIA = C.CAT_NOMBRE
LEFT JOIN
    ImagenProducto IP ON P.ID_PRO = IP.FKProducto
WHERE
    C.CAT_ESTADO = 0
    AND P.PRO_ESTADO = 0;

-- 11 18 2023

-- CREATE VIEW Vista_Productos_Categoria AS
-- SELECT
 --   P.ID_PRO,
 --   P.PRO_NOMBRE,
 --   P.PRO_DESCRIPCION,
  --  P.PRO_PRECIOTOTAL
 -- FROM
  --  PRODUCTO P
-- JOIN
  --  CATEGORIAS C ON P.PRO_CATEGORIA = C.CAT_NOMBRE
-- WHERE
 --   C.CAT_ESTADO = 0
  --  AND P.PRO_ESTADO = 0;

SELECT * FROM Vista_Productos_Categoria;
-- CREATE VIEW Vista_Productos_Categoria AS
-- SELECT
 --   P.ID_PRO,
 --   P.PRO_NOMBRE,
 --   P.PRO_DESCRIPCION,
  --  P.PRO_PRECIOTOTAL,
  --  C.CAT_ID
-- FROM
 --   PRODUCTO P
-- JOIN
  --  CATEGORIAS C ON P.PRO_CATEGORIA = C.CAT_NOMBRE
-- WHERE
 --   C.CAT_ESTADO = 0
   -- AND P.PRO_ESTADO = 0;
 

-- ----------------------------














CREATE VIEW Vista_Categorias AS
SELECT CAT_ID, CAT_NOMBRE, CAT_DESC, CAT_CREADOR
FROM CATEGORIAS
 WHERE CAT_ESTADO = 0;

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

