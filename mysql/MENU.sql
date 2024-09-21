CREATE DATABASE IF NOT EXISTS MENU;
USE MENU;

CREATE TABLE  USUARIO(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(10) NOT NULL,
    pass VARCHAR(10)NOT NULL,
    email VARCHAR(100)UNIQUE NOT NULL
);

CREATE TABLE CATEGORIA(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)NOT NULL
);

create table PEDIDO(
    id INTEGER AUTO_INCREMENT PRIMARY KEY, 
    fecha TIMESTAMP NOT NULL,
    id_usuario INTEGER NOT NULL,
    total FLOAT DEFAULT 0.0 NOT NULL,
    terminado BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id)
);

CREATE TABLE PRODUCTO(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    descripcion VARCHAR(100),
    foto VARCHAR(300) NOT NULL,
    id_catego INTEGER NOT NULL,
    precio FLOAT NOT NULL,
    FOREIGN KEY (id_catego) REFERENCES CATEGORIA(id)
);

CREATE TABLE DETALLE_PEDIDO (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    id_producto INTEGER NOT NULL,
    cantidad INTEGER DEFAULT 1,
    FOREIGN KEY (id_pedido) REFERENCES PEDIDO(id),
    FOREIGN KEY (id_producto) REFERENCES PRODUCTO(id)
);

CREATE TABLE VALORACION(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    valor ENUM ('1','2','3','4','5') NOT NULL DEFAULT '5',
    id_producto INTEGER NOT NULL,
    id_usuario INTEGER NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id),
    FOREIGN KEY  (id_producto) REFERENCES PRODUCTO(id)
);


GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root' WITH GRANT OPTION;
FLUSH PRIVILEGES;