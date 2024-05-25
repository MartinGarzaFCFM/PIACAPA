CREATE DATABASE Linea;
USE Linea;


CREATE TABLE usuario (
id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(40) NOT NULL,
    contrasena VARCHAR(40) NOT NULL,
   correo VARCHAR(70) NOT NULL,
    Nombre VARCHAR(255) NOT NULL,
    nacimiento DATE NOT NULL,
    sexo VARCHAR(15) NOT NULL, 
    creacion DATE NOT NULL,
   rol  INT NOT NULL,
   UsuImagenes TEXT,
   Privacidad BOOLEAN NOT NULL,
   estado BIT NOT NULL DEFAULT 0,
   
    FOREIGN KEY (rol) REFERENCES roles(id)
 
);

--

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL, -- Nombre del rol (por ejemplo, "Cliente" o "Vendedor")
  valor_num INT NOT NULL -- Valor numérico del rol (0 para "Cliente", 1 para "Vendedor", etc.)
);

--

create table CATEGORIAS(
CAT_ID int primary key auto_increment  COMMENT 'PK DE CATEGORIAS',
CAT_NOMBRE varchar(40) COMMENT 'NOMBRE DE LA CATEGORIA',
CAT_DESC varchar(70)  COMMENT 'DESCRIPCION DE LA CATEGORIA',
CAT_CREADOR int COMMENT 'PK DE TABLA USUARIOS',
   CAT_ESTADO BIT NOT NULL DEFAULT 0  COMMENT 'ESTADO DE LA TABLA',
   CAT_ALTA  DATE NOT NULL COMMENT 'FECHA EN QUE SE CREO LA CATEGORIA',
foreign key (CAT_CREADOR)references usuario (id)
);

--

create table CATEGORIA_PRODUCTO(
ID_CATPRO int primary key auto_increment,
CAT_ID int   COMMENT 'PK DE CATEGORIAS',
ID_PRO int  COMMENT 'PK DE PRODUCTO',
foreign key (CAT_ID)references CATEGORIAS (CAT_ID),
foreign key (ID_PRO)references PRODUCTO (ID_PRO) 
);

-- 

create table PRODUCTO (
ID_PRO INT AUTO_INCREMENT PRIMARY KEY,
PRO_NOMBRE VARCHAR (255) NOT NULL,
PRO_DESCRIPCION VARCHAR (255) NOT NULL,
PRO_TIPO INT ,
PRO_PRECIOTOTAL FLOAT(2) COMMENT 'Indica el precio unitario',
PRO_CANTIDAD INT NOT NULL,
PRO_ESTADO BIT DEFAULT 0,
PRO_FECHALTA  DATE NOT NULL,
PRO_CATEGORIA VARCHAR(255),
-- PRO_PRECIO_TOTAL_CALCULADO FLOAT(2) COMMENT 'Indica el precio total calculado, es decir, PRO_PRECIOTOTAL multiplicado por PRO_CANTIDAD del servidor php',
id_usuario int,
foreign key (id_usuario) references usuario (id)
);

--

create table VideoProducto(
IDVideo INT AUTO_INCREMENT PRIMARY KEY,
Video  MEDIUMTEXT NOT NULL,
FKProducto int not null COMMENT 'Indica el producto al cual pertenece ese video',
foreign key(FKProducto) references Producto (ID_PRO)
);

--
CREATE TABLE PRODUCTO_COTIZADO (
    ID_COTI INT AUTO_INCREMENT PRIMARY KEY,
    PRO_PRECIOUNITARIO FLOAT(2),
    
    PRO_MATERIAL VARCHAR(70),
    PRO_MEDIDAS VARCHAR(70),
    PRO_CADUCIDAD DATE,
    PRO_APROBADO BIT DEFAULT 0,
    FOREIGN KEY (ID_COTI) REFERENCES PRODUCTO (ID_PRO)
);

--

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

--


CREATE TABLE ImagenProducto(
IDImagen INT auto_increment primary key,
Imagen MEDIUMBLOB  NOT NULL,
FKProducto int not null COMMENT 'Indica el producto el cual pertenece esta imagen',
foreign key (FKProducto) references Producto(ID_PRO)
);

--

create table LISTA(
ID_LISTA int primary key auto_increment,
LIST_NOMBRE varchar (40),
LIST_DESCRIPCION varchar(70),
LIST_ESTADO BIT DEFAULT 0,
LIST_CREADOR int,
LIST_PRIVACIDAD int,
foreign key (LIST_CREADOR) references usuario (id)

);

--

CREATE TABLE LISTA_PRODUCTO (
    ID_LISTA INT,
    ID_PRO INT,
    LISTA_PRO_CANTIDAD  INT,
    PRO_PRECIO_TOTAL_CALCULADO FLOAT(2) COMMENT 'Indica el precio total calculado',
    PRIMARY KEY (ID_LISTA, ID_PRO),
    FOREIGN KEY (ID_LISTA) REFERENCES LISTA(ID_LISTA),
    FOREIGN KEY (ID_PRO) REFERENCES PRODUCTO(ID_PRO)
);

--

CREATE TABLE COTIZACION (
    ID_COTI INT AUTO_INCREMENT PRIMARY KEY,
    Vendedor INT,
     Cliente INT,
   
    ID_PRO INT,
    FECHA_COTIZACION DATE,
    PRO_PRECIOUNITARIO FLOAT(2),
    PRO_MATERIAL VARCHAR(70),
    PRO_MEDIDAS VARCHAR(70),
    PRO_CADUCIDAD DATE,
     PRO_CANTIDAD INT,
     COTIZACION_ESTADO BIT DEFAULT 0,
    PRO_APROBADO BIT DEFAULT 0,
    FOREIGN KEY (ID_PRO) REFERENCES PRODUCTO (ID_PRO),
    FOREIGN KEY (Vendedor) REFERENCES usuario (id),
    FOREIGN KEY (Cliente) REFERENCES usuario (id)
);

--

CREATE TABLE CARRITO (
    ID_CARRITO INT AUTO_INCREMENT PRIMARY KEY,
    ID_USUARIO INT NOT NULL,
    ID_PRODUCTO INT NOT NULL,
    ID_COTI INT,  -- Nueva columna para relacionar con la cotización
    CARR_CANTIDAD INT NOT NULL,
     CARR_PRECIO_UNITARIO FLOAT(2),  -- Precio unitario de la cotización
     PRO_PRECIO_TOTAL_CALCULADO FLOAT(2),  -- Se calculará en base a CANTIDAD * PRECIO_UNITARIO
     CARR_FECHA_AGREGADO DATE NOT NULL,
    FOREIGN KEY (ID_USUARIO) REFERENCES usuario (id),
    FOREIGN KEY (ID_PRODUCTO) REFERENCES PRODUCTO (ID_PRO),
    FOREIGN KEY (ID_COTI) REFERENCES COTIZACION (ID_COTI)
);

--

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

--

CREATE TABLE CONVERSACION (
    id_conversacion INT PRIMARY KEY AUTO_INCREMENT,
    usuario1 INT,
    usuario2 INT,
    producto_id INT,
    
    FOREIGN KEY (usuario1) REFERENCES usuario (id),
    FOREIGN KEY (usuario2) REFERENCES usuario (id),
    FOREIGN KEY (producto_id) REFERENCES PRODUCTO (ID_PRO)
);