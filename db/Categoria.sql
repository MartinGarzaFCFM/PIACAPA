
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

SELECT * FROM VistaCategorias;


