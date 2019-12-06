/* Restrição de integridade 1 */
create or replace function zona_anomalia_trigger() returns trigger as
$$
declare zona1 box;
BEGIN
    SELECT zona INTO zona1 FROM anomalia WHERE id = new.id;
    
    if zona1 && new.zona2 then
        raise exception 'As zonas da anomalia não se podem sobrepor (RI-1).';
    end if;
END
$$ language plpgsql;

DROP TRIGGER IF EXISTS zona_anomalia on anomalia_traducao;
CREATE TRIGGER zona_anomalia AFTER INSERT ON anomalia_traducao 
FOR EACH ROW EXECUTE PROCEDURE zona_anomalia_trigger();


/* Restrição de integridade 4 */
create or replace function tipo_user_trigger() returns trigger as
$$
BEGIN
    if new.email not in (SELECT email FROM utilizador_qualificado UNION SELECT email FROM utilizador_regular) then
        raise exception 'Utilizador precisa de ser utilizador qualificado ou regular (RI-4).';
    end if;
    return new;
END
$$ language plpgsql;

DROP TRIGGER IF EXISTS tipo_user on utilizador;
create constraint trigger tipo_user AFTER insert on utilizador initially deferred
for each row execute procedure tipo_user_trigger();

/* Restrição de integridade 5 */
CREATE OR REPLACE FUNCTION qualificado_exclusivo_trigger() returns trigger as
$$
begin
    if new.email in (SELECT email FROM utilizador_regular) then
        raise exception 'Utilizador já é "Utilizador regular" (RI-5).';
    end if;
    return new;
end
$$ language plpgsql;

DROP TRIGGER IF EXISTS qualificado_exclusivo on utilizador_qualificado;
CREATE TRIGGER qualificado_exclusivo AFTER INSERT ON utilizador_qualificado
FOR EACH ROW EXECUTE PROCEDURE qualificado_exclusivo_trigger();

/* Restrição de integridade 6 */
CREATE OR REPLACE FUNCTION regular_exclusivo_trigger() returns trigger as
$$
begin
    if new.email in (SELECT email FROM utilizador_qualificado) then
        raise exception 'Utilizador já é "Utilizador qualificado" (RI-6).';
    end if;
    return new;
end
$$ language plpgsql;

DROP TRIGGER IF EXISTS regular_exclusivo on utilizador_regular;
CREATE TRIGGER regular_exclusivo AFTER INSERT ON utilizador_regular
FOR EACH ROW EXECUTE PROCEDURE regular_exclusivo_trigger();

/* Código de teste
DELETE FROM Utilizador WHERE email LIKE '%tiagoantunes%';
DELETE FROM Utilizador WHERE email LIKE '%asd%';

BEGIN TRANSACTION;
insert into utilizador values('tiagoantunes@gmail.com', '12345');
insert into utilizador_qualificado values('tiagoantunes@gmail.com');
insert into utilizador values('asd@gmail.com', '12345');
insert into utilizador_regular values('asd@gmail.com');
COMMIT TRANSACTION;
*/