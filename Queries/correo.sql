CREATE SEQUENCE correo_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE correo (
    id INT NOT NULL,
    correo_electronico VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

ALTER TABLE correo
    ADD cliente_id INT DEFAULT NULL;

ALTER TABLE correo
    ADD CONSTRAINT FK_CLIENTE_CORREO
    FOREIGN KEY (cliente_id) REFERENCES client (id);

CREATE INDEX IDX_CLIENTE_CORREO ON correo (cliente_id);
