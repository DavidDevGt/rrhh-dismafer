CREATE DATABASE rrhh_dismafer;

USE rrhh_dismafer;

-- Tabla de Empleados
CREATE TABLE
    empleados (
        id_empleado INT AUTO_INCREMENT PRIMARY KEY,
        nombres VARCHAR(50) NOT NULL,
        apellidos VARCHAR(50) NOT NULL,
        dpi VARCHAR(15) UNIQUE NOT NULL,
        fecha_nacimiento DATE,
        direccion VARCHAR(100),
        telefono VARCHAR(15),
        email VARCHAR(100),
        estado_civil ENUM ('soltero', 'casado', 'divorciado', 'viudo'),
        numero_dependientes INT DEFAULT 0,
        fecha_inicio DATE,
        sueldo_base DECIMAL(10, 2),
        activo TINYINT DEFAULT 1 NOT NULL,
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Horarios
CREATE TABLE
    horarios (
        id_horario INT AUTO_INCREMENT PRIMARY KEY,
        id_empleado INT,
        fecha DATE,
        hora_entrada TIME,
        hora_salida TIME,
        horas_extra DECIMAL(5, 2) DEFAULT 0,
        activo TINYINT DEFAULT 1 NOT NULL,
        FOREIGN KEY (id_empleado) REFERENCES empleados (id_empleado),
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Ausencias
CREATE TABLE
    ausencias (
        id_ausencia INT AUTO_INCREMENT PRIMARY KEY,
        id_empleado INT,
        tipo ENUM ('enfermedad', 'personal', 'vacaciones'),
        fecha_inicio DATE,
        fecha_fin DATE,
        aprobado BOOLEAN,
        comentario TEXT,
        activo TINYINT DEFAULT 1 NOT NULL,
        FOREIGN KEY (id_empleado) REFERENCES empleados (id_empleado),
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Vacaciones
CREATE TABLE
    vacaciones (
        id_vacacion INT AUTO_INCREMENT PRIMARY KEY,
        id_empleado INT,
        fecha_inicio DATE,
        fecha_fin DATE,
        aprobado BOOLEAN,
        comentario TEXT,
        activo TINYINT DEFAULT 1 NOT NULL,
        FOREIGN KEY (id_empleado) REFERENCES empleados (id_empleado),
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Llamadas de Atención
CREATE TABLE
    llamadas_atencion (
        id_llamada INT AUTO_INCREMENT PRIMARY KEY,
        id_empleado INT,
        fecha DATE,
        motivo TEXT,
        medidas TEXT,
        activo TINYINT DEFAULT 1 NOT NULL,
        FOREIGN KEY (id_empleado) REFERENCES empleados (id_empleado),
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Pagos y Sueldos
CREATE TABLE
    pagos (
        id_pago INT AUTO_INCREMENT PRIMARY KEY,
        id_empleado INT,
        fecha_pago DATE,
        monto DECIMAL(10, 2),
        tipo ENUM ('sueldo', 'bonificacion', 'deduccion', 'adelanto'),
        descripcion TEXT,
        activo TINYINT DEFAULT 1 NOT NULL,
        FOREIGN KEY (id_empleado) REFERENCES empleados (id_empleado),
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla Adicional para Adelantos
CREATE TABLE
    adelantos (
        id_adelanto INT AUTO_INCREMENT PRIMARY KEY,
        id_empleado INT,
        fecha_solicitud DATE,
        monto DECIMAL(10, 2),
        descripcion TEXT,
        activo TINYINT DEFAULT 1 NOT NULL,
        FOREIGN KEY (id_empleado) REFERENCES empleados (id_empleado),
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Usuarios del Sistema
CREATE TABLE
    usuarios_sistema (
        id_usuario INT AUTO_INCREMENT PRIMARY KEY,
        nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
        contraseña_hash VARCHAR(255) NOT NULL,
        activo TINYINT DEFAULT 1 NOT NULL,
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Sesiones
CREATE TABLE
    sesiones (
        id_sesion INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT,
        token VARCHAR(255) NOT NULL,
        fecha_inicio_sesion DATETIME DEFAULT CURRENT_TIMESTAMP,
        fecha_cerrar_sesion DATETIME,
        FOREIGN KEY (id_usuario) REFERENCES usuarios_sistema (id_usuario)
    );

-- Tabla de Candidatos
CREATE TABLE
    candidatos (
        id_candidato INT AUTO_INCREMENT PRIMARY KEY,
        nombres VARCHAR(50) NOT NULL,
        apellidos VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        telefono VARCHAR(15),
        direccion VARCHAR(100),
        cv_url VARCHAR(255), -- URL donde se almacena el CV
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Vacantes
CREATE TABLE
    vacantes (
        id_vacante INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(100) NOT NULL,
        descripcion TEXT NOT NULL,
        departamento VARCHAR(50),
        estado ENUM ('abierta', 'cerrada') DEFAULT 'abierta',
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Tabla de Postulaciones
CREATE TABLE
    postulaciones (
        id_postulacion INT AUTO_INCREMENT PRIMARY KEY,
        id_candidato INT,
        id_vacante INT,
        fecha_postulacion DATE,
        estado ENUM ('pendiente', 'aceptado', 'rechazado') DEFAULT 'pendiente',
        FOREIGN KEY (id_candidato) REFERENCES candidatos (id_candidato),
        FOREIGN KEY (id_vacante) REFERENCES vacantes (id_vacante),
        creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
        actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- Índices para la tabla empleados
ALTER TABLE empleados ADD INDEX idx_nombre_apellido (nombres, apellidos);

ALTER TABLE empleados ADD INDEX idx_dpi (dpi);

ALTER TABLE empleados ADD INDEX idx_fecha_nacimiento (fecha_nacimiento);

-- Índices para la tabla horarios
ALTER TABLE horarios ADD INDEX idx_horario_empleado (id_empleado);

ALTER TABLE horarios ADD INDEX idx_fecha_horario (fecha);

-- Índices para la tabla ausencias
ALTER TABLE ausencias ADD INDEX idx_ausencia_empleado_tipo (id_empleado, tipo);

ALTER TABLE ausencias ADD INDEX idx_fecha_ausencia (fecha_inicio, fecha_fin);

-- Índices para la tabla vacaciones
ALTER TABLE vacaciones ADD INDEX idx_vacacion_empleado (id_empleado);

ALTER TABLE vacaciones ADD INDEX idx_fecha_vacacion (fecha_inicio, fecha_fin);

-- Índices para la tabla llamadas_atencion
ALTER TABLE llamadas_atencion ADD INDEX idx_llamada_empleado_fecha (id_empleado, fecha);

-- Índices para la tabla pagos
ALTER TABLE pagos ADD INDEX idx_pago_empleado (id_empleado);

ALTER TABLE pagos ADD INDEX idx_fecha_pago (fecha_pago);

-- Índice para la tabla candidatos
ALTER TABLE candidatos ADD INDEX idx_nombre_apellido_candidato (nombres, apellidos);

-- Índice para la tabla vacantes
ALTER TABLE vacantes ADD INDEX idx_titulo_vacante (titulo);

-- Índice para la tabla postulaciones
ALTER TABLE postulaciones ADD INDEX idx_postulacion_candidato_vacante (id_candidato, id_vacante);

# Este SQL es posterior a la creacion de la base de datos inicial, me falto normalizar esto:

-- Creación de la Tabla de Puestos
CREATE TABLE puestos (
    id_puesto INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    departamento VARCHAR(50),
    activo TINYINT DEFAULT 1 NOT NULL,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Modificación de la Tabla de Empleados para incluir el puesto
ALTER TABLE empleados ADD COLUMN id_puesto INT,
    ADD FOREIGN KEY (id_puesto) REFERENCES puestos (id_puesto);

-- Modificación de la Tabla de Candidatos para incluir el puesto aplicado
ALTER TABLE candidatos ADD COLUMN id_puesto_aplicado INT,
    ADD FOREIGN KEY (id_puesto_aplicado) REFERENCES puestos (id_puesto);

-- Índices para la tabla Puestos
ALTER TABLE puestos ADD INDEX idx_titulo_puesto (titulo);