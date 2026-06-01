-- Active: 1780259884966@@127.0.0.1@3306@nwdb
CREATE TABLE usuario (
    usercod BIGINT AUTO_INCREMENT PRIMARY KEY,
    useremail VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL,
    userpswd VARCHAR(255) NOT NULL,

    usertipo CHAR(3) NOT NULL COMMENT 'ADM, COC, CLI',

    userest CHAR(3) NOT NULL DEFAULT 'ACT',
    userfching DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE platos (
    platoId INT AUTO_INCREMENT PRIMARY KEY,

    platoNombre VARCHAR(100) NOT NULL,
    platoDescripcion TEXT,

    platoPrecio DECIMAL(10,2) NOT NULL,
    platoStock INT NOT NULL DEFAULT 0,

    platoEstado CHAR(3) NOT NULL DEFAULT 'ACT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE pedidos (
    pedidoId INT AUTO_INCREMENT PRIMARY KEY,

    usercod BIGINT NOT NULL,

    pedidoFecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    pedidoEstado CHAR(3) NOT NULL DEFAULT 'PEN',

    CONSTRAINT fk_pedidos_usuario
        FOREIGN KEY (usercod)
        REFERENCES usuario(usercod)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE pedidodetalle (
    detalleId INT AUTO_INCREMENT PRIMARY KEY,

    pedidoId INT NOT NULL,

    platoId INT NOT NULL,

    cantidad INT NOT NULL,

    precioUnitario DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_pedidodetalle_pedido
        FOREIGN KEY (pedidoId)
        REFERENCES pedidos(pedidoId)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_pedidodetalle_plato
        FOREIGN KEY (platoId)
        REFERENCES platos(platoId)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE pedidoestadolog (
    logId INT AUTO_INCREMENT PRIMARY KEY,

    pedidoId INT NOT NULL,

    estadoAnterior CHAR(3) NOT NULL,

    estadoNuevo CHAR(3) NOT NULL,

    fechaCambio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_pedidoestadolog_pedido
        FOREIGN KEY (pedidoId)
        REFERENCES pedidos(pedidoId)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO platos
(
    platoNombre,
    platoDescripcion,
    platoPrecio,
    platoStock,
    platoEstado
)
VALUES
(
    'Pizza Suprema',
    'Pizza con pepperoni y queso',
    250.00,
    10,
    'ACT'
);

INSERT INTO platos
(
    platoNombre,
    platoDescripcion,
    platoPrecio,
    platoStock,
    platoEstado
)
VALUES
(
    'Hamburguesa Especial',
    'Carne, queso y vegetales',
    180.00,
    15,
    'ACT'
);

INSERT INTO platos
(
    platoNombre,
    platoDescripcion,
    platoPrecio,
    platoStock,
    platoEstado
)
VALUES
(
    'Pollo Frito',
    'Pollo crujiente con papas',
    220.00,
    8,
    'ACT'
);

INSERT INTO platos
(
    platoNombre,
    platoDescripcion,
    platoPrecio,
    platoStock,
    platoEstado
)
VALUES
(
    'Limonada Natural',
    'Limonada fresca',
    50.00,
    20,
    'ACT'
);