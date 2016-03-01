-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO roles (name, admin) VALUES ('Admin', true);
INSERT INTO users (name, email, password, role_id) VALUES ('Kristian Lauttamus', 'kristian.lauttamus@gmail.com', 'admin', 1);
INSERT INTO users (name, email, password, role_id) VALUES ('Kristian Lauttamus', 'kristian.lauttamus@helsinki.fi', 'testisalasana', null);