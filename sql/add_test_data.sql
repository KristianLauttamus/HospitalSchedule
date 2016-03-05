-- Roles
INSERT INTO roles (name, admin) VALUES ('Admin', true);
INSERT INTO roles (name, weight, admin) VALUES ('Lääkäri', 3,true);
INSERT INTO roles (name, weight, admin) VALUES ('Sairaanhoitaja', 2, true);
INSERT INTO roles (name, weight, admin) VALUES ('Perushoitaja', 1, true);

-- Admin
INSERT INTO users (name, email, password, role_id) VALUES ('Kristian Lauttamus', 'kristian.lauttamus@gmail.com', 'admin', 1);

-- Workforce
INSERT INTO users (name, email, password, role_id) VALUES ('Kristian Lauttamus', 'doctor@d.d', 'testi', 2);
INSERT INTO users (name, email, password, role_id) VALUES ('Mariatta Testaaja', 'mariatta@d.d', 'testi', 3);
INSERT INTO users (name, email, password, role_id) VALUES ('Testinenä', 'testi@d.d', 'testi', 4);
INSERT INTO users (name, email, password, role_id) VALUES ('Rooliton Christ', 'rooliton@d.d', 'testi', null);

-- Hospital
INSERT INTO hospitals (name, open_time, close_time) VALUES ('Testisairaala', 1, 24);
INSERT INTO importances DEFAULT VALUES;

-- 24 Hours
INSERT INTO hours (at, hospital_id, importance_id) VALUES (1, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (2, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (3, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (4, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (5, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (6, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (7, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (8, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (9, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (10, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (11, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (12, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (13, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (14, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (15, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (16, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (17, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (18, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (19, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (20, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (21, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (22, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (23, 1, 1);
INSERT INTO hours (at, hospital_id, importance_id) VALUES (24, 1, 1);

INSERT INTO hospital_users (user_id, hospital_id) VALUES (1, 1);

-- importance roles
INSERT INTO importance_roles (needed, role_id, importance_id) VALUES (1, 2, 1);
INSERT INTO importance_roles (needed, role_id, importance_id) VALUES (2, 3, 1);
INSERT INTO importance_roles (needed, role_id, importance_id) VALUES (3, 4, 1);

INSERT INTO hour_users (user_id, hour_id) VALUES (2, 1);
INSERT INTO hour_users (user_id, hour_id) VALUES (3, 1);
INSERT INTO hour_users (user_id, hour_id) VALUES (4, 1);
INSERT INTO hour_users (user_id, hour_id) VALUES (5, 1);