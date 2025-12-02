CREATE DATABASE ferreteria;
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);


CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    id_categoria INT,
    precio_compra DECIMAL(10,2) NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    unidad_medida VARCHAR(20),
    estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);


CREATE TABLE proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion TEXT
);


CREATE TABLE compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_proveedor INT,
    total DECIMAL(10,2),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
);


CREATE TABLE compras_detalles (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT,
    id_producto INT,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) AS (cantidad * precio) STORED,
    FOREIGN KEY (id_compra) REFERENCES compras(id_compra),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);


CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion TEXT
);


CREATE TABLE empleados (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    puesto VARCHAR(100),
    telefono VARCHAR(20)
);


CREATE TABLE metodos_pago (
    id_metodo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO metodos_pago (nombre) VALUES
('Efectivo'), ('Tarjeta'), ('Transferencia');


CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_cliente INT,
    id_empleado INT,
    id_metodo INT,
    total DECIMAL(10,2),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    FOREIGN KEY (id_metodo) REFERENCES metodos_pago(id_metodo)
);


CREATE TABLE ventas_detalles (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT,
    id_producto INT,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) AS (cantidad * precio) STORED,
    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);


INSERT INTO categorias (nombre, descripcion) VALUES
('Herramientas', 'Herramientas manuales y eléctricas'),
('Pinturas', 'Pinturas y accesorios'),
('Construcción', 'Materiales para construcción'),
('Electricidad', 'Artículos eléctricos'),
('Plomería', 'Artículos de plomería');


INSERT INTO productos (nombre, descripcion, id_categoria, precio_compra, precio_venta, stock, unidad_medida)
VALUES
('Martillo', 'Martillo de acero 16 oz', 1, 5.00, 8.50, 40, 'pieza'),
('Taladro eléctrico', 'Taladro de 600W', 1, 25.00, 39.90, 15, 'pieza'),
('Brocha 2"', 'Brocha para pintura', 2, 1.20, 2.50, 100, 'pieza'),
('Pintura blanca 1 galón', 'Pintura látex blanca', 2, 8.00, 13.00, 50, 'galón'),
('Cemento 50kg', 'Saco de cemento gris', 3, 6.50, 9.00, 80, 'saco'),
('Cable eléctrico 10m', 'Cable calibre 12', 4, 3.00, 5.50, 60, 'rollo'),
('Tubo PVC 1"', 'Tubo de PVC de 1 pulgada', 5, 2.00, 4.00, 70, 'pieza');


INSERT INTO proveedores (nombre, telefono, correo, direccion) VALUES
('Distribuidora Industrial S.A.', '555-1234', 'contacto@industrial.com', 'Av. Central 123'),
('Pinturas del Norte', '555-5678', 'ventas@pinturasnorte.com', 'Calle Azul 45'),
('Construmax', '555-9012', 'info@construmax.com', 'Av. Obreros 789');

INSERT INTO compras (id_proveedor, total) VALUES
(1, 150.75),
(2, 80.30),
(3, 200.00);

INSERT INTO compras_detalles (id_compra, id_producto, cantidad, precio) VALUES
(1, 1, 20, 5.00),
(1, 2, 5, 25.00),
(2, 3, 30, 1.20),
(2, 4, 10, 8.00),
(3, 5, 20, 6.50),
(3, 6, 15, 3.00);


INSERT INTO clientes (nombre, telefono, correo, direccion) VALUES
('Juan Pérez', '555-1111', 'juanp@gmail.com', 'Calle 10 #20'),
('María López', '555-2222', 'mlopez@hotmail.com', 'Av. Verde 33'),
('Construcciones Hermanos', '555-3333', 'compras@ch.com', 'Zona Industrial 12');


INSERT INTO empleados (nombre, puesto, telefono) VALUES
('Carlos Ramírez', 'Cajero', '555-4411'),
('Ana Torres', 'Vendedora', '555-5522'),
('Luis Méndez', 'Administrador', '555-6633');

INSERT INTO metodos_pago (nombre) VALUES
('Efectivo'), ('Tarjeta'), ('Transferencia');

INSERT INTO ventas (id_cliente, id_empleado, id_metodo, total) VALUES
(1, 1, 1, 25.50),
(2, 2, 2, 40.00),
(3, 3, 3, 120.00);

INSERT INTO ventas_detalles (id_venta, id_producto, cantidad, precio) VALUES
(1, 1, 2, 8.50),
(1, 3, 1, 2.50),
(2, 4, 2, 13.00),
(3, 5, 5, 9.00),
(3, 6, 4, 5.50);






