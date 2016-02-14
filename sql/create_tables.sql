-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE hospitals(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL
);

CREATE TABLE roles(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  admin boolean DEFAULT false
);

CREATE TABLE users(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  role_id INTEGER REFERENCES roles (id)
);

CREATE TABLE hospital_users(
  hospital_id INTEGER REFERENCES hospitals (id),
  user_id INTEGER REFERENCES users (id)
);