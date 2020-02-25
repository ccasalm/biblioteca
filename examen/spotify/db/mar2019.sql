DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
    id       bigserial    PRIMARY KEY
  , nombre   varchar(255) NOT NULL UNIQUE
  , email    varchar(255) NOT NULL UNIQUE
  , password varchar(255) NOT NULL
);

DROP TABLE IF EXISTS temas CASCADE;

CREATE TABLE temas
(
    id       bigserial    PRIMARY KEY
  , titulo   varchar(255) NOT NULL
  , duracion interval
  , ruta     varchar(255)
);

DROP TABLE IF EXISTS albumes CASCADE;

CREATE TABLE albumes
(
    id     bigserial    PRIMARY KEY
  , titulo varchar(255) NOT NULL
  , anyo   numeric(4)   NOT NULL
);

DROP TABLE IF EXISTS artistas CASCADE;

CREATE TABLE artistas
(
    id     bigserial    PRIMARY KEY
  , nombre varchar(255) NOT NULL
);

DROP TABLE IF EXISTS albumes_temas CASCADE;

CREATE TABLE albumes_temas
(
    album_id bigint REFERENCES albumes (id) ON DELETE NO ACTION ON UPDATE NO ACTION
  , tema_id  bigint REFERENCES temas (id) ON DELETE NO ACTION ON UPDATE NO ACTION
  , PRIMARY KEY (album_id, tema_id)
);

DROP TABLE IF EXISTS artistas_temas CASCADE;

CREATE TABLE artistas_temas
(
    artista_id bigint REFERENCES artistas (id) ON DELETE NO ACTION ON UPDATE NO ACTION
  , tema_id    bigint REFERENCES temas (id) ON DELETE NO ACTION ON UPDATE NO ACTION
  , PRIMARY KEY (artista_id, tema_id)
);