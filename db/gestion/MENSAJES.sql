use linea;

-- -------------------------------------------------------------------------------------------------lina CORRELOS 16-11-2023
CREATE TABLE CONVERSACION (
    id_conversacion INT PRIMARY KEY AUTO_INCREMENT,
    usuario1 INT,
    usuario2 INT,
    producto_id INT,
    
    FOREIGN KEY (usuario1) REFERENCES usuario (id),
    FOREIGN KEY (usuario2) REFERENCES usuario (id),
    FOREIGN KEY (producto_id) REFERENCES PRODUCTO (ID_PRO)
);
CREATE TABLE MENSAJE (
    MSJ_ID INT PRIMARY KEY AUTO_INCREMENT,
    MSJ_MENSAJE VARCHAR(200),
    MSJ_REMITENTE INT,
    MSJ_DESTINATARIO INT,
    MSJ_FECHA TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    MSJ_LEIDO BOOLEAN DEFAULT FALSE,
    conversacion_id INT,
      producto_id INT,
    FOREIGN KEY (MSJ_REMITENTE) REFERENCES usuario (id),
    FOREIGN KEY (MSJ_DESTINATARIO) REFERENCES usuario (id),
    FOREIGN KEY (conversacion_id) REFERENCES CONVERSACION (id_conversacion),
    FOREIGN KEY (producto_id) REFERENCES PRODUCTO (ID_PRO)
);
ALTER TABLE MENSAJE ADD COLUMN producto_id INT;
ALTER TABLE MENSAJE ADD FOREIGN KEY (producto_id) REFERENCES PRODUCTO (ID_PRO);

ALTER TABLE CONVERSACION ADD COLUMN producto_id INT;
ALTER TABLE CONVERSACION ADD FOREIGN KEY (producto_id) REFERENCES PRODUCTO (ID_PRO);


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


-- funciona para verificar si ya existe una conversacion con esos usuarios y productos
CREATE VIEW vista_conversacion_existente AS
SELECT
    usuario1,
    usuario2,
    producto_id,
    id_conversacion
FROM
    conversacion;


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
SELECT *
FROM VistaMensajesConversacion
WHERE usuario1 = 16 AND usuario2 = 19 AND conversacion_id = 1;
SELECT * FROM VistaMensajesConversacion WHERE conversimagenproductoacion_id = 1 
ORDER BY MSJ_FECHA desc



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

CALL sp_insertar_mensaje('Prueba de mensaje', 16, 19, 1);

CREATE VIEW VistaParaVerUsuYconversacion AS
SELECT
    C.id_conversacion,
    C.usuario1 AS remitente,
    C.usuario2 AS destinatario,
    C.producto_id
FROM
    conversacion C;

SELECT *
FROM VistaParaVerUsuYconversacion;







-- -------------------- para que le salga la charla pendiente al vendedor ----------------------------------------------------------
CREATE VIEW vista_conversaciones_info AS
SELECT 
    C.*,
    (SELECT Nombre FROM usuario WHERE id = C.usuario1) as RemitenteNombre,
    (SELECT Nombre FROM usuario WHERE id = C.usuario2) as DestinatarioNombre,
    P.PRO_NOMBRE as ProductoNombre
FROM CONVERSACION C
INNER JOIN producto P ON C.producto_id = P.ID_PRO
WHERE C.usuario2 = C.usuario2;

SELECT *
FROM vista_conversaciones_info;
SELECT * FROM vista_conversaciones_info WHERE usuario2 = 18;



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
-- -------
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
 
