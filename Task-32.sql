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
ALTER TABLE Usuario ADD COLUMN Foto_U VARCHAR(255) DEFAULT 'img/default_profile.png';

-- Tabla: Administrador
CREATE TABLE Administrador (
    Id_Administrador INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_A VARCHAR(100) NOT NULL,
    Correo_e_A VARCHAR(100) NOT NULL UNIQUE,
    Contraseña_A VARCHAR(255) NOT NULL,
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

INSERT INTO Administrador (Nombre_A, Correo_e_A, Contraseña_A, Permisos_A) VALUES  
('Administrador', 'admin@gmail.com', '$2y$10$ao3O6n2kMM./r3N3EeQBFuoBwElmvsmZDkTY6mFYTK6IQDJX0lssu', 'admin');
-- Contraseña 1234Segura hasheada

INSERT INTO Administrador (Nombre_A, Correo_e_A, Contraseña_A, Permisos_A) VALUES  
('Edgar', 'edgar@gmail.com', '$2y$10$HpKAsfgUHhisIMm/4DDiUOrhw8Uz1vORX0D9DbSPqTNT/TQDUQ/Bu', 'admin');
-- Contraseña contra hasheada

INSERT INTO Producto (Nombre_P, Descripción_P, Precio_P, Categoría_P, Disponibilidad_P, Imagen_P, Id_Administrador) VALUES  
('Laptop HP 240 G9', 'Laptop con procesador Intel Celeron, 8GB RAM y 256GB SSD.', 5299.00, 'Computadoras Portátiles', 1, 'img/Laptop HP 240 G9.jpg', 1),  
('Laptop Dell XPS 13', 'Laptop premium con Intel i7, 16GB RAM y 512GB SSD.', 9999.00, 'Computadoras Portátiles', 1, 'img/Laptop Dell XPS 13.jpg', 1),  
('Laptop Lenovo IdeaPad', 'Laptop con Intel Core i5, 8GB RAM y 512GB SSD.', 6499.00, 'Computadoras Portátiles', 1, 'img/Laptop Lenovo IdeaPad.jpg', 1),  
('Laptop Acer Aspire 5', 'Laptop con AMD Ryzen 5, 8GB RAM y 256GB SSD.', 5799.00, 'Computadoras Portátiles', 1, 'img/Laptop Acer Aspire 5.jpg', 1),  
('Laptop HP Pavilion', 'Laptop con Intel i5, 8GB RAM y 1TB HDD.', 7199.00, 'Computadoras Portátiles', 1, 'img/Laptop HP Pavilion.jpg', 1),  
('Laptop Dell Inspiron 15', 'Laptop con Intel i3, 4GB RAM y 500GB HDD.', 4999.00, 'Computadoras Portátiles', 1, 'img/Laptop Dell Inspiron 15.jpg', 1),
('Monitor LG UltraGear 27"', 'Monitor Gamer de 27\" con resolución QHD y tasa de refresco de 144Hz.', 7499.00, 'Monitores', 1, 'img/Monitor LG UltraGear 27.jpg', 1),
('Mouse Logitech G502', 'Mouse gaming con sensor óptico de alta precisión y luces RGB personalizables.', 1599.00, 'Accesorios', 1, 'img/Mouse Logitech G502.jpg', 1),
('Teclado Mecánico Corsair K70', 'Teclado mecánico RGB con switches Cherry MX y marco de aluminio.', 2999.00, 'Accesorios', 1, 'img/Teclado Corsair K70.jpg', 1),  
('Audífonos HyperX Cloud II', 'Audífonos gamer con sonido envolvente 7.1 y almohadillas cómodas.', 1899.00, 'Accesorios', 1, 'img/Audífonos HyperX Cloud II.jpg', 1),  
('Cámara Web Logitech C920', 'Cámara web HD con micrófono integrado, ideal para videoconferencias.', 1499.00, 'Cámaras', 1, 'img/Cámara Logitech C920.jpg', 1),  
('SSD Samsung 970 EVO Plus 1TB', 'Unidad de almacenamiento SSD NVMe de alta velocidad con 1TB de capacidad.', 3599.00, 'Almacenamiento', 1, 'img/SSD Samsung 970 EVO Plus 1TB.jpg', 1),  
('Tarjeta Gráfica NVIDIA RTX 3060', 'Tarjeta gráfica con 12GB GDDR6, ideal para gaming y diseño gráfico.', 8499.00, 'Componentes', 1, 'img/Tarjeta Gráfica NVIDIA RTX 3060.jpg', 1),  
('Router TP-Link Archer AX50', 'Router WiFi 6 dual band con velocidad de hasta 3 Gbps.', 2699.00, 'Redes', 1, 'img/Router TP-Link Archer AX50.jpg', 1),  
('Impresora HP DeskJet 4155e', 'Impresora multifuncional inalámbrica con impresión a color y escáner.', 2499.00, 'Impresoras', 1, 'img/Impresora HP DeskJet 4155e.jpg', 1),  
('Tablet Samsung Galaxy Tab A7', 'Tablet de 10.4" con 64GB de almacenamiento y WiFi.', 3999.00, 'Tablets', 1, 'img/Tablet Samsung Galaxy Tab A7.jpg', 1),  
('Silla Gamer Razer Iskur', 'Silla ergonómica con diseño gamer y soporte lumbar ajustable.', 8999.00, 'Mobiliario', 1, 'img/Silla Gamer Razer Iskur.jpg', 1),  
('Fuente de Poder Corsair RM750', 'Fuente de alimentación modular de 750W con certificación 80+ Gold.', 1999.00, 'Componentes', 1, 'img/Fuente de Poder Corsair RM750.jpg', 1);

INSERT INTO Servicio (Nombre_S, Descripción_S, Precio_S, Categoría_S, Disponibilidad_S, Id_Administrador)  VALUES   
('Reparación de hardware', 'Diagnóstico y reparación de componentes físicos dañados o defectuosos en equipos electrónicos.', 150, 'Mantenimiento', 1, 1),  
('Reparación de software', 'Resolución de errores y problemas en sistemas operativos, aplicaciones y programas.', 100, 'Mantenimiento', 1, 1),  
('Mantenimiento preventivo', 'Limpieza y optimización de hardware y software para garantizar un funcionamiento adecuado y prevenir fallos.', 80, 'Mantenimiento', 1, 1),  
('Recuperación de datos', 'Recuperación de información perdida o inaccesible desde discos duros, memorias USB o sistemas dañados.', 200, 'Servicios Especializados', 1, 1),  
('Instalación y configuración', 'Instalación de software y configuración personalizada según las necesidades del cliente.', 120, 'Instalación', 1, 1),  
('Servicio de refrigeración líquida', 'Instalación y mantenimiento de sistemas de refrigeración líquida para mejorar el rendimiento de equipos de alto rendimiento.', 250, 'Mantenimiento', 1, 1),  
('Servicios de overclocking', 'Ajuste de componentes para aumentar su rendimiento de manera segura mediante overclocking.', 180, 'Optimización', 1, 1),  
('Análisis forense digital', 'Investigación y análisis de dispositivos para recopilar pruebas digitales en investigaciones legales o de ciberseguridad.', 350, 'Investigación', 1, 1),
('Soporte técnico remoto', 'Asistencia técnica para la resolución de problemas informáticos a través de conexión remota, sin necesidad de desplazamiento.', 90, 'Soporte Técnico', 1, 1),  
('Evaluación de seguridad cibernética', 'Análisis completo de la infraestructura de seguridad de sistemas informáticos para identificar vulnerabilidades y riesgos de seguridad.', 300, 'Seguridad', 1, 1),
('Configuración de redes', 'Instalación y configuración de redes LAN/WiFi para oficinas y hogares.', 250, 'Redes', 1, 1),  
('Diseño de páginas web', 'Creación de sitios web personalizados según las necesidades del cliente.', 1000, 'Desarrollo Web', 1, 1),  
('Ensamblado de PC a medida', 'Ensamble de equipos de escritorio según los requerimientos del cliente.', 300, 'Personalización', 1, 1),  
('Optimización de rendimiento', 'Optimización de hardware y software para mejorar la velocidad y eficiencia.', 150, 'Optimización', 1, 1),  
('Instalación de sistemas de vigilancia', 'Configuración de cámaras de seguridad y sistemas de monitoreo.', 500, 'Seguridad', 1, 1),  
('Capacitación en herramientas tecnológicas', 'Cursos personalizados sobre software o herramientas tecnológicas.', 200, 'Educación', 1, 1),  
('Auditoría de redes', 'Revisión completa de redes empresariales para identificar problemas o mejorar el rendimiento.', 350, 'Redes', 1, 1),  
('Soporte técnico in situ', 'Asistencia técnica en el lugar para resolver problemas complejos.', 120, 'Soporte Técnico', 1, 1),  
('Consultoría en ciberseguridad', 'Asesoramiento especializado en protección de datos y sistemas.', 400, 'Consultoría', 1, 1),  
('Implementación de servidores', 'Configuración y despliegue de servidores para empresas.', 1000, 'Infraestructura', 1, 1);  

select * from Administrador;
select * from Usuario;
select * from Producto;
select * from Servicio;
select * from Presupuesto;
select * from Incluye;