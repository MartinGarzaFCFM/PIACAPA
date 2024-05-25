use linea;




create table PRODUCTO (
ID_PRO INT AUTO_INCREMENT PRIMARY KEY,
PRO_NOMBRE VARCHAR (255) NOT NULL,
PRO_DESCRIPCION VARCHAR (255) NOT NULL,
PRO_TIPO INT ,
PRO_PRECIOTOTAL FLOAT(2),
PRO_CANTIDAD INT NOT NULL,
PRO_ESTADO BIT DEFAULT 0,
PRO_FECHALTA  DATE NOT NULL,
PRO_CATEGORIA VARCHAR(255),

id_usuario int,
foreign key (id_usuario) references usuario (id)
);
create table VideoProducto(
IDVideo INT AUTO_INCREMENT PRIMARY KEY,
Video VARCHAR(255) NOT NULL,
FKProducto int not null COMMENT 'Indica el producto al cual pertenece ese video',
foreign key(FKProducto) references Producto (ID_PRO)
);

CREATE TABLE ImagenProducto(
IDImagen INT auto_increment primary key,
Imagen VARCHAR(255) NOT NULL,
FKProducto int not null COMMENT 'Indica el producto el cual pertenece esta imagen',
foreign key (FKProducto) references Producto(ID_PRO)
);

DELIMITER //

CREATE PROCEDURE InsertarProducto(
    IN tipoProducto INT,
    IN nombreProducto VARCHAR(255),
    IN descripcionProducto VARCHAR(255),
    IN precioProducto FLOAT(2),
    IN cantidadProducto INT,
    IN categoriaProducto VARCHAR(255),  -- Debes definir cómo manejar la categoría en tu sistema
    IN videoProducto VARCHAR(255),
    IN imagenesProducto VARCHAR(255),  -- Debes definir cómo manejar las imágenes en tu sistema
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
CREATE PROCEDURE FiltrarProductosPorCategoria(IN categoria VARCHAR(255))
BEGIN
    SELECT * FROM PRODUCTO WHERE PRO_CATEGORIA = categoria;
END //
DELIMITER ;
CALL FiltrarProductosPorCategoria('Hogar');











-- Tabla para productos cotizados que hereda de PRODUCTO_BASE
CREATE TABLE PRODUCTO_COTIZADO (
    ID_COTI INT AUTO_INCREMENT PRIMARY KEY,
    PRO_PRECIOUNITARIO FLOAT(2),
    
    PRO_MATERIAL VARCHAR(70),
    PRO_MEDIDAS VARCHAR(70),
    PRO_CADUCIDAD DATE,
    PRO_APROBADO BIT DEFAULT 0,
    FOREIGN KEY (ID_COTI) REFERENCES PRODUCTO (ID_PRO)
);




CREATE TABLE COMENTARIO(
ID_COMENTARIO int primary key auto_increment,
OP_VALORACION INT NOT NULL,
OP_COMENTARIOS VARCHAR (255) NOT NULL,
fecha date,
activo bool,
	ID_PRO     int COMMENT 'PK DE PRODUCTOS',
    id     int COMMENT 'PK DE PRODUCTOS',
	foreign key (ID_PRO) references PRODUCTO (ID_PRO),
foreign key (id) references usuario (id)
);
CREATE TABLE MULTIMEDIA(
	ID_MEDIA    int primary key  AUTO_INCREMENT COMMENT 'PK DE MULTIMEDIA',
	ID_PRO     int COMMENT 'PK DE PRODUCTOS',
	MEDIA_REC   BLOB NOT NULL COMMENT 'RECURSO MULTIMEDIA',
	MEDIA_EXT   VARCHAR(10) NOT NULL COMMENT 'EXTENCION DEL RECURSO MULTIMEDIA',
	MEDIA_PESO  VARCHAR(50) NOT NULL COMMENT 'TAMANIO DEL RECURSO',
	MEDIA_TIPO  VARCHAR(10) NOT NULL COMMENT 'IMAGEN/VIDEO',
	foreign key (ID_PRO) references PRODUCTO (ID_PRO)

);

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
CREATE PROCEDURE InsertarProducto(
    IN p_Nombre VARCHAR(255),
    IN p_Descripcion VARCHAR(255),
    IN p_Tipo BIT,
    IN p_PrecioTotal FLOAT(2),
    IN p_Cantidad INT,
   
    IN p_FechaAlta DATE,
    IN p_UsuarioID INT,
    IN p_MultimediaRec BLOB,
    IN p_MultimediaExt VARCHAR(10),
    IN p_MultimediaPeso VARCHAR(50),
    IN p_MultimediaTipo VARCHAR(10),
    IN p_CategoriaID INT
)
BEGIN
    DECLARE productoID INT;

    -- Insertar el producto en la tabla PRODUCTO
    INSERT INTO PRODUCTO (
        PRO_NOMBRE, PRO_DESCRIPCION, PRO_TIPO, PRO_PRECIOTOTAL, 
        PRO_CANTIDAD,  PRO_FECHALTA, id_usuario
    ) VALUES (
        p_Nombre, p_Descripcion, p_Tipo, p_PrecioTotal, p_Cantidad,  p_FechaAlta, p_UsuarioID
    );

    -- Obtener el ID del producto recién insertado
    SET productoID = LAST_INSERT_ID();

    -- Insertar la información multimedia en la tabla MULTIMEDIA
    INSERT INTO MULTIMEDIA (
        ID_PRO, MEDIA_REC, MEDIA_EXT, MEDIA_PESO, MEDIA_TIPO
    ) VALUES (
        productoID, p_MultimediaRec, p_MultimediaExt, p_MultimediaPeso, p_MultimediaTipo
    );

    -- Insertar la categoría del producto en la tabla CATEGORIA_PRODUCTO
    INSERT INTO CATEGORIA_PRODUCTO (CAT_ID, ID_PRO)
    VALUES (p_CategoriaID, productoID);
END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE InsertarProductoCotizable(
    IN p_Nombre VARCHAR(255),
    IN p_Descripcion VARCHAR(255),
    IN p_Tipo BIT,
    IN p_PrecioTotal FLOAT(2),
    IN p_PRO_PRECIOUNITARIO FLOAT(2),
    IN p_FechaAlta DATE,
    IN p_UsuarioID INT,
    IN p_Material VARCHAR(70),
    IN p_Medidas VARCHAR(70),
    IN p_MultimediaRec BLOB,
    IN p_MultimediaExt VARCHAR(10),
    IN p_MultimediaPeso VARCHAR(50),
    IN p_MultimediaTipo VARCHAR(10),
    IN p_CategoriaID INT
)
BEGIN
    DECLARE productoCotizableID INT;
    DECLARE fechaCaducidad DATE;

    -- Calcular la fecha de caducidad como 5 días a partir de la fecha actual
    SET fechaCaducidad = DATE_ADD(CURDATE(), INTERVAL 5 DAY);

    -- Insertar el producto cotizable en la tabla PRODUCTO_COTIZADO
    INSERT INTO PRODUCTO_COTIZADO (
        PRO_NOMBRE, PRO_DESCRIPCION, PRO_TIPO, PRO_PRECIOTOTAL, p_PRO_PRECIOUNITARIO,
        PRO_FECHALTA, id_usuario, PRO_MATERIAL, PRO_MEDIDAS, PRO_CADUCIDAD
    ) VALUES (
        p_Nombre, p_Descripcion, p_Tipo, p_PrecioTotal, p_PRO_PRECIOUNITARIO, p_FechaAlta, p_UsuarioID, p_Material, p_Medidas, fechaCaducidad
    );

    -- Obtener el ID del producto cotizable recién insertado
    SET productoCotizableID = LAST_INSERT_ID();

    -- Insertar la información multimedia en la tabla MULTIMEDIA
    INSERT INTO MULTIMEDIA (
        ID_PRO, MEDIA_REC, MEDIA_EXT, MEDIA_PESO, MEDIA_TIPO
    ) VALUES (
        productoCotizableID, p_MultimediaRec, p_MultimediaExt, p_MultimediaPeso, p_MultimediaTipo
    );

    -- Insertar la categoría del producto cotizable en la tabla CATEGORIA_PRODUCTO
    INSERT INTO CATEGORIA_PRODUCTO (CAT_ID, ID_PRO)
    VALUES (p_CategoriaID, productoCotizableID);
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
