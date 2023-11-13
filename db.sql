CREATE DATABASE rrhh_dismafer;
USE rrhh_dismafer;

-- Tabla de Empleados
CREATE TABLE empleados (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    dpi VARCHAR(15) UNIQUE NOT NULL,
    fecha_nacimiento DATE,
    direccion VARCHAR(100),
    telefono VARCHAR(15),
    email VARCHAR(100),
    estado_civil ENUM('soltero', 'casado', 'divorciado', 'viudo'),
    numero_dependientes INT DEFAULT 0,
    fecha_inicio DATE,
    sueldo_base DECIMAL(10,2),
    activo TINYINT DEFAULT 1 NOT NULL,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Horarios
CREATE TABLE horarios (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT,
    fecha DATE,
    hora_entrada TIME,
    hora_salida TIME,
    horas_extra DECIMAL(5,2) DEFAULT 0,
    activo TINYINT DEFAULT 1 NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Ausencias
CREATE TABLE ausencias (
    id_ausencia INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT,
    tipo ENUM('enfermedad', 'personal', 'vacaciones'),
    fecha_inicio DATE,
    fecha_fin DATE,
    aprobado BOOLEAN,
    comentario TEXT,
    activo TINYINT DEFAULT 1 NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Vacaciones
CREATE TABLE vacaciones (
    id_vacacion INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    aprobado BOOLEAN,
    comentario TEXT,
    activo TINYINT DEFAULT 1 NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Llamadas de Atención
CREATE TABLE llamadas_atencion (
    id_llamada INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT,
    fecha DATE,
    motivo TEXT,
    medidas TEXT,
    activo TINYINT DEFAULT 1 NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Pagos y Sueldos
CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT,
    fecha_pago DATE,
    monto DECIMAL(10,2),
    tipo ENUM('sueldo', 'bonificacion', 'deduccion', 'adelanto'),
    descripcion TEXT,
    activo TINYINT DEFAULT 1 NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla Adicional para Adelantos
CREATE TABLE adelantos (
    id_adelanto INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT,
    fecha_solicitud DATE,
    monto DECIMAL(10,2),
    descripcion TEXT,
    activo TINYINT DEFAULT 1 NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de Usuarios del Sistema
CREATE TABLE usuarios_sistema (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    contraseña_hash VARCHAR(255) NOT NULL,
    activo TINYINT DEFAULT 1 NOT NULL,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
