-- Script para crear la base de datos y las tablas
CREATE DATABASE IF NOT EXISTS Task32;
USE Task32;

-- Tabla: Usuario
CREATE TABLE Usuario (
    Id_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_U VARCHAR(100) NOT NULL,
    Correo_e_U VARCHAR(100) NOT NULL UNIQUE,
    Teléfono_U VARCHAR(15) NOT NULL UNIQUE,
    Fecha_n_U DATE NOT NULL,
    Contraseña_U VARCHAR(255) NOT NULL
);

-- Tabla: Administrador
CREATE TABLE Administrador (
    Id_Administrador INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_A VARCHAR(100) NOT NULL,
    Correo_e_A VARCHAR(100) NOT NULL UNIQUE,
    Permisos_A VARCHAR(50) NOT NULL
);

-- Tabla: Producto
CREATE TABLE Producto (
    Id_Producto INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_P VARCHAR(100) NOT NULL,
    Descripción_P TEXT NOT NULL,
    Precio_P DECIMAL(10, 2) NOT NULL,
    Categoría_P VARCHAR(50) NOT NULL,
    Disponibilidad_P TINYINT(1) NOT NULL DEFAULT 1,
    Imagen_P VARCHAR(255),
    Id_Administrador INT NOT NULL,
    FOREIGN KEY (Id_Administrador) REFERENCES Administrador(Id_Administrador)
);

-- Tabla: Servicio
CREATE TABLE Servicio (
    Id_Servicio INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_S VARCHAR(100) NOT NULL,
    Descripción_S TEXT NOT NULL,
    Precio_S DECIMAL(10, 2) NOT NULL,
    Categoría_S VARCHAR(50) NOT NULL,
    Disponibilidad_S TINYINT(1) NOT NULL DEFAULT 1,
    Id_Administrador INT NOT NULL,
    FOREIGN KEY (Id_Administrador) REFERENCES Administrador(Id_Administrador)
);

-- Tabla: Presupuesto
CREATE TABLE Presupuesto (
    Id_Presupuesto INT AUTO_INCREMENT PRIMARY KEY,
    Fecha_c_P DATETIME NOT NULL,
    Cantidad_a_P INT NOT NULL,
    Total_P DECIMAL(10, 2) NOT NULL,
    Id_Usuario INT NOT NULL,
    FOREIGN KEY (Id_Usuario) REFERENCES Usuario(Id_Usuario)
);

-- Tabla: Incluye (Intermedia entre Producto y Presupuesto)
CREATE TABLE Incluye (
    Id_Presupuesto INT NOT NULL,
    Id_Producto INT NOT NULL,
    PRIMARY KEY (Id_Presupuesto, Id_Producto),
    FOREIGN KEY (Id_Presupuesto) REFERENCES Presupuesto(Id_Presupuesto),
    FOREIGN KEY (Id_Producto) REFERENCES Producto(Id_Producto)
);

-- Tabla: Notificación
CREATE TABLE Notificación (
    Id_Notificación INT AUTO_INCREMENT PRIMARY KEY,
    Fecha_e_N DATETIME NOT NULL,
    Tipo_N VARCHAR(50) NOT NULL,
    Descripción_N TEXT NOT NULL,
    Id_Usuario INT NOT NULL,
    FOREIGN KEY (Id_Usuario) REFERENCES Usuario(Id_Usuario)
);

INSERT INTO Administrador (Nombre_A, Correo_e_A, Permisos_A) VALUES  
('Administrador', 'admin@gmail.com', 'admin');

INSERT INTO Producto (Nombre_P, Descripción_P, Precio_P, Categoría_P, Disponibilidad_P, Imagen_P, Id_Administrador) VALUES  
('Laptop HP 240 G9', 'Laptop con procesador Intel Celeron, 8GB RAM y 256GB SSD.', 5299.00, 'Computadoras Portátiles', 1, 'img/Laptop HP 240 G9.jpg', 1),  
('Laptop Dell XPS 13', 'Laptop premium con Intel i7, 16GB RAM y 512GB SSD.', 9999.00, 'Computadoras Portátiles', 1, 'img/Laptop Dell XPS 13.jpg', 1),  
('Laptop Lenovo IdeaPad', 'Laptop con Intel Core i5, 8GB RAM y 512GB SSD.', 6499.00, 'Computadoras Portátiles', 1, 'img/Laptop Lenovo IdeaPad.jpg', 1),  
('Laptop Acer Aspire 5', 'Laptop con AMD Ryzen 5, 8GB RAM y 256GB SSD.', 5799.00, 'Computadoras Portátiles', 1, 'img/Laptop Acer Aspire 5.jpg', 1),  
('Laptop HP Pavilion', 'Laptop con Intel i5, 8GB RAM y 1TB HDD.', 7199.00, 'Computadoras Portátiles', 1, 'img/Laptop HP Pavilion.jpg', 1),  
('Laptop Dell Inspiron 15', 'Laptop con Intel i3, 4GB RAM y 500GB HDD.', 4999.00, 'Computadoras Portátiles', 1, 'img/Laptop Dell Inspiron 15.jpg', 1),
('Monitor LG UltraGear 27"', 'Monitor Gamer de 27\" con resolución QHD y tasa de refresco de 144Hz.', 7499.00, 'Monitores', 1, 'img/Monitor LG UltraGear 27.jpg', 1),
('Mouse Logitech G502', 'Mouse gaming con sensor óptico de alta precisión y luces RGB personalizables.', 1599.00, 'Accesorios', 1, 'img/Mouse Logitech G502.jpg', 1);

INSERT INTO Servicio (Nombre_S, Descripción_S, Precio_S, Categoría_S, Disponibilidad_S, Id_Administrador)  
VALUES   
('Reparación de hardware', 'Diagnóstico y reparación de componentes físicos dañados o defectuosos en equipos electrónicos.', 150, 'Mantenimiento', 1, 1),  
('Reparación de software', 'Resolución de errores y problemas en sistemas operativos, aplicaciones y programas.', 100, 'Mantenimiento', 1, 1),  
('Mantenimiento preventivo', 'Limpieza y optimización de hardware y software para garantizar un funcionamiento adecuado y prevenir fallos.', 80, 'Mantenimiento', 1, 1),  
('Recuperación de datos', 'Recuperación de información perdida o inaccesible desde discos duros, memorias USB o sistemas dañados.', 200, 'Servicios Especializados', 1, 1),  
('Instalación y configuración', 'Instalación de software y configuración personalizada según las necesidades del cliente.', 120, 'Instalación', 1, 1),  
('Servicio de refrigeración líquida', 'Instalación y mantenimiento de sistemas de refrigeración líquida para mejorar el rendimiento de equipos de alto rendimiento.', 250, 'Mantenimiento', 1, 1),  
('Servicios de overclocking', 'Ajuste de componentes para aumentar su rendimiento de manera segura mediante overclocking.', 180, 'Optimización', 1, 1),  
('Análisis forense digital', 'Investigación y análisis de dispositivos para recopilar pruebas digitales en investigaciones legales o de ciberseguridad.', 350, 'Investigación', 1, 1),
('Soporte técnico remoto', 'Asistencia técnica para la resolución de problemas informáticos a través de conexión remota, sin necesidad de desplazamiento.', 90, 'Soporte Técnico', 1, 1),  
('Evaluación de seguridad cibernética', 'Análisis completo de la infraestructura de seguridad de sistemas informáticos para identificar vulnerabilidades y riesgos de seguridad.', 300, 'Seguridad', 1, 1);

select * from Administrador;
select * from Usuario;
select * from Producto;
select * from Servicio;
select * from Presupuesto;
select * from Incluye;

select * from Usuario;
select * from Presupuesto;
select * from Incluye;