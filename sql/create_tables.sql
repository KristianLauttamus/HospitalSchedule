-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE users(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  role_id INTEGER REFERENCES roles(id)
);

CREATE TABLE roles(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL
);