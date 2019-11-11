-- populate local_publico
INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (39.504609, -8.813860, 'Parque Natural das Serras de Aire e Candeeiros');

INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (40.202017, -8.433941, 'Portugal dos Pequenitos');

INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (38.737618, -9.138667, 'Instituto Superior Técnico');

INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (38.662957, -9.205546, 'Faculdade de Ciências e Tecnologia');

INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (38.778138, -9.135320, 'Aeroporto de Lisboa');

INSERT INTO proj.local_publico(latitude, longitude, nome)
VALUES (39.517208, -8.967171, 'Faculdade de Ciências e Tecnologia');


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
VALUES ('Ṕoster da tuna.', 'XXXXX', 38.662957, -9.205546);

INSERT INTO proj.item(descricao, localizacao, latitude, longitude)
VALUES ('Anúncio de quarto para alugar.', 'XXXXX', 38.662957, -9.205546);

INSERT INTO proj.item(descricao, localizacao, latitude, longitude)
VALUES ('Anúncio de quarto para alugar.', 'XXXXX', 38.737618, -9.138667);

INSERT INTO proj.item(descricao, localizacao, latitude, longitude)
VALUES ('Poster da tuna.', 'XXXXX', 38.662957, -9.205546);

INSERT INTO proj.item(descricao, localizacao, latitude, longitude)
VALUES ('Anúncio de festival.', 'XXXXX', 40.202017, -8.433941);

INSERT INTO proj.item(descricao, localizacao, latitude, longitude)
VALUES ('Placar informativo dos horários dos voos de partida.', 'XXXXX', 38.778138, -9.135320);

INSERT INTO proj.item(descricao, localizacao, latitude, longitude)
VALUES ('Placar informativo sobre flora local.', 'XXXXX', 39.504609, -8.813860);

-- populate duplicado

INSERT INTO proj.duplicado(item1, item2)
VALUES (1, 3);


-- populate anomalia

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(1, 2), (5, 4)', 'https://something.com', 'Português', '2019-02-01 15:26:30', 'Erro gramatical.', FALSE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(1, 2.6), (6, 3.6)', 'https://image.com', 'Inglês', '2019-09-22 17:16:33', 'Má tradução.', TRUE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(5, 2), (8, 3)', 'https://wtv.com', 'Português', '2019-10-06 11:26:30', 'Erro gramatical.', FALSE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(1, 2), (5, 4)', 'https://something.com', 'Português', '2019-10-22 15:26:30', 'Má tradução.', TRUE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(5, 2), (8, 3)', 'https://nothing.com', 'Português', '2019-10-25 09:26:45', 'Má tradução.', TRUE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(1, 2), (5, 4)', 'https://sup.com', 'Português', '2019-11-05 19:32:16', 'Má tradução.', TRUE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(2, 2), (5, 4)', 'https://hey.com', 'Inglês', '2019-11-8 12:20:21', 'Erro gramatical.', FALSE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(1, 2.6), (6, 3.6)', 'https://dude.com', 'Inglês', '2019-11-10 12:20:21', 'Erro gramatical.', FALSE);

INSERT INTO proj.anomalia(zona, imagem, lingua, ts, descricao, tem_anomalia_traducao)
VALUES ('(2, 2), (5, 4)', 'https://yo.com', 'Inglês', '2019-11-11 13:14:21', 'Erro gramatical.', FALSE);


-- populate anomalia_traducao

INSERT INTO proj.anomalia_traducao(id, zona2, lingua2)
VALUES (2, '(1, 0.6),(6, 1.6)', 'Alemão');

INSERT INTO proj.anomalia_traducao(id, zona2, lingua2)
VALUES (4, '(8, 2),(12, 2)', 'Inglês');

INSERT INTO proj.anomalia_traducao(id, zona2, lingua2)
VALUES (5, '(5, 4),(8, 5)', 'Inglês');

INSERT INTO proj.anomalia_traducao(id, zona2, lingua2)
VALUES (6, '(1, 5),(5, 7)', 'Alemão');


-- populate incidendia

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (1, 5, 'xptomail@gmail.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (2, 7, 'xptomail@gmail.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (3, 1, '420time@gmail.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (4, 2, 'ahoy@gmail.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (5, 3, 'wassuppeeps@outlook.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (6, 4, 'xptomail@hotmail.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (7, 6, 'wassuppeeps@outlook.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (8, 7, 'ahoy@gmail.com');

INSERT INTO proj.incidencia(anomalia_id, item_id, email)
VALUES (9, 6, 'ahoy@gmail.com');




-- populate proposta_de_correcao

INSERT INTO proj.proposta_de_correcao(email, nro, data_hora, texto)
VALUES ('420time@gmail.com', 1, '2019-10-06 11:35:33', 'Trocar o artigo no plural por um no singular.');

INSERT INTO proj.proposta_de_correcao(email, nro, data_hora, texto)
VALUES ('ahoy@gmail.com', 1, '2019-11-10 12:25:01', 'Trocar o artigo no plural por um no singular.');

INSERT INTO proj.proposta_de_correcao(email, nro, data_hora, texto)
VALUES ('ahoy@gmail.com', 2, '2019-11-11 13:20:21', 'Trocar o artigo masculino por um feminino.');


-- populate correcao

INSERT INTO proj.correcao(email, nro, anomalia_id)
VALUES ('420time@gmail.com', 1, 3);

INSERT INTO proj.correcao(email, nro, anomalia_id)
VALUES ('ahoy@gmail.com', 1, 8);

INSERT INTO proj.correcao(email, nro, anomalia_id)
VALUES ('ahoy@gmail.com', 2, 9);
