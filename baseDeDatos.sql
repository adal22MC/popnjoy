-- CREATE DATABASE POS;


create table usuarios(
  username varchar(250) PRIMARY KEY,
  password varchar(250)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

insert into usuarios values ('pop', 'pop');



CREATE TABLE categorias(
  id_categoria int NOT NULL AUTO_INCREMENT,
  descripcion varchar(150) COLLATE utf8_spanish_ci,
  primary key(id_categoria)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE clientes (
  id int NOT NULL AUTO_INCREMENT,
  nombre text COLLATE utf8_spanish_ci NOT NULL,
  tipo text COLLATE utf8_spanish_ci NOT NULL,
  email text COLLATE utf8_spanish_ci NOT NULL,
  telefono text COLLATE utf8_spanish_ci NOT NULL,
  direccion text COLLATE utf8_spanish_ci NOT NULL,
  porcentaje float NOT NULL,
  primary key(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

insert into clientes (nombre, tipo, email, telefono, direccion, porcentaje) 
values ('Cliente de Prueba', 3, 'cliente@cliente.com', '9621225878', 'DESCONOCIDA', 0);

CREATE TABLE datos_empresa(
  id int NOT NULL AUTO_INCREMENT,
  nombre text COLLATE utf8_spanish_ci NOT NULL,
  telefono text COLLATE utf8_spanish_ci NOT NULL,
  correo text COLLATE utf8_spanish_ci NOT NULL,
  direccion text COLLATE utf8_spanish_ci NOT NULL,
  pagina_web text COLLATE utf8_spanish_ci NOT NULL,
  primary key(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO datos_empresa (nombre,telefono,correo,direccion,pagina_web)
VALUES ('Popnjoy', '98653121213', 'popnjoy@pop.com','C. Matriz: Av Pacifico #2401 - Dpto. 708B', 'popnjoy.cl');


CREATE TABLE productos(
  id_producto int NOT NULL AUTO_INCREMENT,
  nombre text COLLATE utf8_spanish_ci NOT NULL,
  categoria int NOT NULL references categorias,
  stock int NOT NULL,
  stock_min int NOT NULL,
  stock_max int NOT NULL,
  precio_venta float NOT NULL,
  precio_compra float NOT NULL,
  observaciones text COLLATE utf8_spanish_ci NOT NULL,
  primary key(id_producto)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- TABLA VENTAS
create table ventas(
  idVenta int NOT NULL AUTO_INCREMENT, 
  cliente text COLLATE utf8_spanish_ci NOT NULL,
  fecha date DEFAULT CURRENT_DATE,
  hora time DEFAULT CURRENT_TIME,
  totalVendido float NOT NULL,
  primary key(idVenta)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- DETALLE VENTA
create table detalle_venta(
  cns int NOT NULL AUTO_INCREMENT,
  idventa int NOT NULL references ventas,
  nomProducto text COLLATE utf8_spanish_ci NOT NULL,
  cantidad int NOT NULL,
  precioU float NOT NULL,
  total float NOT NULL,
  categoria text COLLATE utf8_spanish_ci NOT NULL,
  codigo int NOT NULL,
  primary key(cns, idVenta)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- CIERRES DE DIA
create table cierres(
  id_c int NOT NULL AUTO_INCREMENT,
  fecha_c date DEFAULT CURRENT_DATE,
  hora time DEFAULT CURRENT_TIME,
  tv_dia float NOT NULL,
  primary key(id_c)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- DETALLE CIERRE DIA
create table detalle_cierre(
  cns int NOT NULL AUTO_INCREMENT,
  id_c int NOT NULL references cierres,
  id_venta int NOT NULL references ventas,
  primary key(cns, id_c)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
