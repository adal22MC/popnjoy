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
  status int NOT NULL DEFAULT 1,
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
  categoria int NOT NULL,
  stock int NOT NULL,
  stock_min int NOT NULL,
  stock_max int NOT NULL,
  precio_venta float NOT NULL,
  observaciones text COLLATE utf8_spanish_ci NOT NULL,
  status int NOT NULL,
  FOREIGN KEY (categoria) REFERENCES categorias(id_categoria),
  primary key(id_producto)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE detalle_productos(
  cns int NOT NULL AUTO_INCREMENT,
  id_producto_dp int NOT NULL,
  stock int NOT NULL,
  precio_compra float NOT NULL,
  FOREIGN KEY (id_producto_dp) REFERENCES productos(id_producto),
  PRIMARY KEY (cns,id_producto_dp)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE producto_descuentos(

  id_descuento int NOT NULL AUTO_INCREMENT,
  id_producto_pd int NOT NULL,
  cantidad int NOT NULL,
  razon text COLLATE utf8_spanish_ci NOT NULL,
  FOREIGN KEY (id_producto_pd) REFERENCES productos(id_producto),
  PRIMARY KEY (id_descuento)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE insumos(
  id_insumo int NOT NULL AUTO_INCREMENT,
  nombre text COLLATE utf8_spanish_ci NOT NULL,
  stock float NOT NULL,
  stock_min int NOT NULL,
  stock_max int NOT NULL,
  um text COLLATE utf8_spanish_ci NOT NULL, -- unidad de medida
  status int NOT NULL,
  PRIMARY KEY (id_insumo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE detalle_insumos(

  cns int NOT NULL AUTO_INCREMENT,
  id_insumo_di int NOT NULL,
  stock float NOT NULL,
  precio_compra float NOT NULL,
  FOREIGN KEY (id_insumo_di) REFERENCES insumos (id_insumo),
  PRIMARY KEY (cns,id_insumo_di)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE insumo_descuentos(

  id_descuento int NOT NULL AUTO_INCREMENT,
  id_insumo_id int NOT NULL,
  cantidad int NOT NULL,
  razon text COLLATE utf8_spanish_ci NOT NULL,
  FOREIGN KEY (id_insumo_id) REFERENCES insumos(id_insumo),
  PRIMARY KEY (id_descuento)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- TABLA INSUMOS - PRODUCTOS
CREATE TABLE producto_insumos(
  producto int NOT NULL,
  insumo int NOT NULL,
  cantidad int NOT NULL,
  FOREIGN KEY (producto) REFERENCES productos (id_producto),
  FOREIGN KEY (insumo) REFERENCES insumos (id_insumo),
  PRIMARY KEY (producto, insumo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- TABLA VENTAS
create table ventas(
  id_venta int NOT NULL AUTO_INCREMENT, 
  cliente int NOT NULL,
  fecha date DEFAULT CURRENT_DATE,
  hora time DEFAULT CURRENT_TIME,
  total_venta float NOT NULL,
  total_costo float NOT NULL,
  ganancia float NOT NULL,
  FOREIGN KEY (cliente) REFERENCES clientes (id),
  primary key(id_venta)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE ventas_producto(
  id_venta int NOT NULL,
  id_producto int NOT NULL,
  total_venta float NOT NULL,
  total_costo float NOT NULL,
  ganancia float NOT NULL,
  FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
  FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
  PRIMARY KEY (id_venta, id_producto)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- DETALLE VENTA (LLAVES MALAS REFERENCIADAS)
create table detalle_venta(
  cns int NOT NULL AUTO_INCREMENT,
  id_venta int NOT NULL,
  id_producto int NOT NULL,
  cantidad int NOT NULL,
  precio_compra float NOT NULL, -- precio al que se vendio
  precio_costo float NOT NULL,
  total_compra float NOT NULL,
  total_costo float NOT NULL,
  ganancia float NOT NULL,
  FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
  FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
  PRIMARY KEY (cns,id_venta,id_producto)

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- CIERRES DE DIA
create table cierre_dia(
  id_cd int NOT NULL AUTO_INCREMENT,
  fecha date DEFAULT CURRENT_DATE,
  hora time DEFAULT CURRENT_TIME,
  venta float NOT NULL,
  ganancia float NOT NULL,
  PRIMARY KEY(id_cd)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- DETALLE CIERRE DIA
create table detalle_cierre_dia(
  cns int NOT NULL AUTO_INCREMENT,
  id_cd_dcd int NOT NULL references cierre_dia,
  id_venta int NOT NULL references ventas,
  primary key(cns, id_cd_dcd)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE cierre_mes(
  id_cm int NOT NULL AUTO_INCREMENT,
  fecha date DEFAULT CURRENT_DATE,
  hora time DEFAULT CURRENT_TIME,
  venta_total float NOT NULL,
  ganancia float NOT NULL,
  PRIMARY KEY (id_cm)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
