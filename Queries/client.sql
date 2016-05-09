CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE client (
    id INT NOT NULL,
    fechaNacimiento VARCHAR(255) DEFAULT NULL,
    nit VARCHAR(10) NOT NULL,
    frecuente BOOLEAN DEFAULT NULL,
    nombres VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) DEFAULT NULL,
    estadoCivil VARCHAR(255) NOT NULL,
    fotoCliente VARCHAR(255) DEFAULT NULL,
    sexo VARCHAR(255) DEFAULT NULL,
    profesion VARCHAR(255) DEFAULT NULL,
    dpi VARCHAR(14) DEFAULT NULL,
    nacionalidad VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY(id)
);

ALTER TABLE client
    ADD tipo_membresia_id INT DEFAULT NULL;

ALTER TABLE client
    ADD CONSTRAINT FK_C74404553D81FAA9
    FOREIGN KEY (tipo_membresia_id)
    REFERENCES tipo_membresia (id) NOT DEFERRABLE INITIALLY IMMEDIATE;

CREATE INDEX IDX_C74404553D81FAA9 ON client (tipo_membresia_id);
