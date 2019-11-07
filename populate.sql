-- populate local_publico
INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (0.596836, 120.265897, 'Instituto Superior Técnico');

INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (56.596836, -120.265897, 'How you doin?');

INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (-80.596836, 30.265897, 'Kebab Time');


-- populate utilizador
INSERT INTO proj.utilizador(email, password)
VALUES ('xptomail@gmail.com', '1234');

INSERT INTO proj.utilizador(email, password)
VALUES ('xptomail@hotmail.com', '1234');

INSERT INTO proj.utilizador(email, password)
VALUES ('wassuppeeps@outlook.com', '1234');

INSERT INTO proj.utilizador(email, password)
VALUES ('420time@gmail.com', '1234');

INSERT INTO proj.utilizador(email, password)
VALUES ('ahoy@gmail.com', '1234');


-- populate utilizador_regular

INSERT INTO proj.utilizador_regular(email)
VALUES ('xptomail@gmail.com');

INSERT INTO proj.utilizador_regular(email)
VALUES ('wassuppeeps@outlook.com');

INSERT INTO proj.utilizador_regular(email)
VALUES ('xptomail@hotmail.com');


-- populate utilizador_qualificado

INSERT INTO proj.utilizador_qualificado(email)
VALUES ('420time@gmail.com');

INSERT INTO proj.utilizador_qualificado(email)
VALUES ('ahoy@gmail.com');


-- populate item

INSERT INTO proj.item(descricao, localizacao, latitude, longitude)
VALUES ('Clearly you know nothing about german...', 'XXXXX', 56.596836, -120.265897);




