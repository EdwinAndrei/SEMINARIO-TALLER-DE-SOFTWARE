-- =====================================================
--  Sistema de gestión de pedidos — Restaurante
--  Compatible con phpMyAdmin / MySQL
-- =====================================================

CREATE DATABASE IF NOT EXISTS restaurante_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_spanish_ci;

USE restaurante_db;

-- ─────────────────────────────────────────
--  P1 · Auth
-- ─────────────────────────────────────────
CREATE TABLE usuarios (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nombre     VARCHAR(100)  NOT NULL,
  email      VARCHAR(150)  NOT NULL UNIQUE,
  password   VARCHAR(255)  NOT NULL,
  rol        ENUM('cliente','cocina','admin') NOT NULL DEFAULT 'cliente',
  creado_en  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ─────────────────────────────────────────
--  P2 · Menú / Cliente
-- ─────────────────────────────────────────
CREATE TABLE platos (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nombre      VARCHAR(100)  NOT NULL,
  descripcion TEXT,
  precio      DECIMAL(10,2) NOT NULL,
  stock       INT           NOT NULL DEFAULT 0,
  disponible  TINYINT(1)    NOT NULL DEFAULT 1,
  CONSTRAINT chk_stock  CHECK (stock  >= 0),
  CONSTRAINT chk_precio CHECK (precio >= 0)
);

-- ─────────────────────────────────────────
--  P3 · Cocina
-- ─────────────────────────────────────────
CREATE TABLE pedidos (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id  INT  NOT NULL,
  plato_id    INT  NOT NULL,
  cantidad    INT  NOT NULL DEFAULT 1,
  estado      ENUM('pendiente','en_proceso','listo','entregado','cancelado')
                   NOT NULL DEFAULT 'pendiente',
  version     INT  NOT NULL DEFAULT 1,
  creado_en   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_pedido_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  CONSTRAINT fk_pedido_plato   FOREIGN KEY (plato_id)   REFERENCES platos(id),
  CONSTRAINT chk_cantidad      CHECK (cantidad >= 1)
);

-- ─────────────────────────────────────────
--  Datos de prueba
-- ─────────────────────────────────────────
INSERT INTO usuarios (nombre, email, password, rol) VALUES
  ('Admin Demo',   'admin@restaurante.com',   'hash_aqui', 'admin'),
  ('Cocina Demo',  'cocina@restaurante.com',  'hash_aqui', 'cocina'),
  ('Cliente Demo', 'cliente@restaurante.com', 'hash_aqui', 'cliente');

INSERT INTO platos (nombre, descripcion, precio, stock) VALUES
  ('Pizza margarita',    'Tomate y mozzarella',       8.50, 1),
  ('Hamburguesa clásica','Carne, lechuga, tomate',    7.00, 3),
  ('Ensalada César',     'Pollo, crutones, aderezo',  6.00, 5),
  ('Limonada',           'Natural con hielo',          2.50, 0);

INSERT INTO pedidos (usuario_id, plato_id, cantidad, estado, version) VALUES
  (3, 2, 1, 'pendiente',  1),
  (3, 3, 2, 'en_proceso', 1),
  (3, 1, 1, 'listo',      2);