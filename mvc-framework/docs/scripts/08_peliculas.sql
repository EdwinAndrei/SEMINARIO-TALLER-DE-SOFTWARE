-- Active: 1772215977095@@localhost@3306@ecommerce
CREATE TABLE peliculas(  
    peliculaId int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    titulo VARCHAR(255) NOT NULL COMMENT 'Título de la pelicula',
    resumen VARCHAR(255) NOT NULL UNIQUE COMMENT 'Resumen de la pelicula, debe ser único',
    autor VARCHAR(255) NOT NULL COMMENT 'Nombre del autor de la pelicula',
    fecha_publicacion DATE NOT NULL COMMENT 'Fecha de publicación de la pelicula',
    genero VARCHAR(100) NOT NULL COMMENT 'Género literario de la pelicula',
    precio DECIMAL(10, 2) NOT NULL COMMENT 'Precio de la pelicula'
);


