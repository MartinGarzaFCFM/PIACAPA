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
-- esta tabla acepta registrar productos repetidos a una lista.
-- create table LISTA_PRODUCTO (
-- PRO_LISTA_ID int primary key auto_increment,
-- ID_LISTA int,
-- ID_PRO int,
-- foreign key (ID_LISTA) references LISTA(ID_LISTA),
-- foreign key (ID_PRO) references PRODUCTO(ID_PRO)
-- );

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
ALTER TABLE LISTA_PRODUCTO
ADD COLUMN PRO_PRECIO_TOTAL_CALCULADO FLOAT(2) COMMENT 'Indica el precio total calculado';

-- ALTER TABLE LISTA_PRODUCTO
-- ADD COLUMN LISTA_PRO_CANTIDAD  INT;


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

-- CREATE VIEW VistaInformacionLista AS
-- SELECT ID_LISTA, LIST_NOMBRE, LIST_DESCRIPCION, LIST_PRIVACIDAD
-- FROM LISTA;


-- este muestra listas sin importar el id del usuario 
-- CREATE VIEW VistaInformacionLista AS
-- SELECT ID_LISTA, LIST_NOMBRE, LIST_DESCRIPCION, LIST_PRIVACIDAD 
-- FROM LISTA 
-- WHERE LIST_ESTADO = 0;

-- solo mostrara listas con el mismo id que hay en el sistema del usuario
CREATE VIEW VistaInformacionLista AS
SELECT ID_LISTA, LIST_CREADOR, LIST_NOMBRE, LIST_DESCRIPCION, LIST_PRIVACIDAD 
FROM LISTA 
WHERE LIST_ESTADO = 0;


SELECT * FROM VistaInformacionLista WHERE LIST_CREADOR = 18;



SELECT * FROM VistaInformacionLista WHERE ID_LISTA = 1;



-- este procedure acepta agregar productos repetidos a una misma losta y eso esta mal ya que para eso tenemos el atributo
-- cantidad de productos pero esto lo  arregle colocando la tabla producto lista como datos unicos-
-- DELIMITER //
-- CREATE PROCEDURE AgregarProductoAListaa(IN pIdLista INT, IN pIdProducto INT, IN pIdUsuario INT)
-- BEGIN
   -- DECLARE vUsuarioValido INT;

    -- Verifica si el usuario tiene permisos para agregar a la lista
   -- SELECT COUNT(*) INTO vUsuarioValido
   -- FROM VistaInformacionLista
 --   WHERE ID_LISTA = pIdLista AND LIST_CREADOR = pIdUsuario;

   -- IF vUsuarioValido > 0 THEN
        -- Usuario válido, procede con la inserción
   --     INSERT INTO LISTA_PRODUCTO (ID_LISTA, ID_PRO) VALUES (pIdLista, pIdProducto);
   --     SELECT 'Producto agregado a la lista con éxito.' AS mensaje;
  --  ELSE
        -- Usuario no válido, emite un mensaje de error
   --     SELECT 'Error: Usuario no autorizado para agregar a esta lista.' AS mensaje;
 --   END IF;
-- END //
-- DELIMITER ;


-- CREATE VIEW VistaListaProductos AS
-- SELECT
  --  LP.ID_LISTA,
  --  LP.ID_PRO,
   -- P.PRO_NOMBRE,
   -- P.PRO_DESCRIPCION,
   -- P.PRO_PRECIOTOTAL,
   -- P.PRO_CANTIDAD,
   -- IP.Imagen
-- FROM
 --   LISTA_PRODUCTO LP
-- JOIN
 --   LISTA L ON LP.ID_LISTA = L.ID_LISTA
-- JOIN
 --   PRODUCTO P ON LP.ID_PRO = P.ID_PRO
-- LEFT JOIN
 --   ImagenProducto IP ON P.ID_PRO = IP.FKProducto;

SELECT * FROM VistaListaProductoss WHERE ID_LISTA = 2;


-- CREATE VIEW VistaListaProductoss AS
-- SELECT
  --  LP.ID_LISTA,
  --  LP.ID_PRO,
 --   L.LIST_CREADOR AS ID_USUARIO_LISTA,
 --   P.PRO_NOMBRE,
 --   P.PRO_DESCRIPCION,
 --   P.PRO_PRECIOTOTAL,
  --  P.PRO_CANTIDAD,
  --  IP.Imagen
-- FROM
   -- LISTA_PRODUCTO LP
 -- JOIN
  --  LISTA L ON LP.ID_LISTA = L.ID_LISTA
 -- JOIN
  --  PRODUCTO P ON LP.ID_PRO = P.ID_PRO
-- LEFT JOIN
   -- ImagenProducto IP ON P.ID_PRO = IP.FKProducto;

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


