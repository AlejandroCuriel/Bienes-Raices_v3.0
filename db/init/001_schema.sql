CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS vendedores (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  imagen VARCHAR(120) NOT NULL,
  nombre VARCHAR(60) NOT NULL,
  apellido VARCHAR(60) NOT NULL,
  telefono CHAR(10) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS propiedades (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(120) NOT NULL,
  precio DECIMAL(12,2) NOT NULL,
  imagen VARCHAR(120) NOT NULL,
  descripcion TEXT NOT NULL,
  habitaciones TINYINT UNSIGNED NOT NULL,
  wc TINYINT UNSIGNED NOT NULL,
  estacionamiento TINYINT UNSIGNED NOT NULL,
  vendedorId INT UNSIGNED NOT NULL,
  creado DATE NOT NULL,
  PRIMARY KEY (id),
  KEY idx_propiedades_vendedorId (vendedorId),
  CONSTRAINT fk_propiedades_vendedor
    FOREIGN KEY (vendedorId) REFERENCES vendedores(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO usuarios (email, password)
VALUES ('correo@correo.com', '$2y$12$zz1pg3AA4.kEBj0jjL85peJwb9.tRr2JIGxFaUu6/lFE1niTUO.KO');
