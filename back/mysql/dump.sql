CREATE DATABASE IF NOT EXISTS MENU;
USE MENU;

CREATE TABLE  USUARIO(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    pass VARCHAR(10),
    email VARCHAR(30)
);

CREATE TABLE CATEGORIA(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)
);

create table PEDIDO(
    id INTEGER AUTO_INCREMENT PRIMARY KEY, 
    fecha TIMESTAMP,
    id_usuario INTEGER,
    total FLOAT DEFAULT 0.0,
    terminado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id)
);


CREATE TABLE PRODUCTO(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30),
    descripcion VARCHAR(100),
    foto VARCHAR(300),
    id_catego INTEGER,
    precio FLOAT,
    FOREIGN KEY (id_catego) REFERENCES CATEGORIA(id)
);

CREATE TABLE DETALLE_PEDIDO (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    id_producto INTEGER NOT NULL,
    cantidad INTEGER,
    FOREIGN KEY (id_pedido) REFERENCES PEDIDO(id),
    FOREIGN KEY (id_producto) REFERENCES PRODUCTO(id)
);


CREATE TABLE VALORACION(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    valor ENUM ('1','2','3','4','5') NOT NULL DEFAULT '5' ,
    id_producto INTEGER,
    id_usuario INTEGER,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id),
    FOREIGN KEY  (id_producto) REFERENCES PRODUCTO(id)
);

INSERT INTO USUARIO(nombre, email, pass)VALUES("pepe", "pepe@gmail.com", "123");
INSERT INTO USUARIO(nombre, email, pass)VALUES("maria", "maria@gmail.com", "456");

INSERT INTO CATEGORIA(nombre)VALUES("categoria");
INSERT INTO CATEGORIA(nombre)VALUES("categoria2");

INSERT INTO PRODUCTO(nombre, foto, descripcion, precio, id_catego)VALUES("prueba", "prueba.jpg", "descripcion producto prueba", 12.4, 1);
INSERT INTO PRODUCTO(nombre, foto, descripcion, precio, id_catego)VALUES("Yakitori", "foto.jpg", "descripcion del Producto 2", 20.49, 1);
INSERT INTO PRODUCTO(nombre, foto, descripcion, precio, id_catego)VALUES("producto 3", "foto3.jpg", "descripcion del producto 3", 3.33, 1);



INSERT INTO VALORACION(id_usuario, id_producto, valor)VALUES(1,2,3);

INSERT INTO VALORACION(id_producto, id_usuario, valor)VALUES(3, 1, 5);