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

select * from usuario;