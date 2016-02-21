-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE hospitals(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL
);

CREATE TABLE roles(
  id SERIAL PRIMARY KEY,
  weight INTEGER NOT NULL DEFAULT(0),
  name varchar(50) NOT NULL,
  admin boolean DEFAULT false
);

CREATE TABLE importances(
  id SERIAL PRIMARY KEY
);

CREATE TABLE hours(
  id SERIAL PRIMARY KEY,
  at INTEGER NOT NULL,
  hospital_id INTEGER REFERENCES hospitals (id),
  importance_id INTEGER REFERENCES importances (id)
);

CREATE TABLE importance_role(
  id SERIAL PRIMARY KEY,
  needed INTEGER NOT NULL,
  importance_id INTEGER REFERENCES importances (id),
  role_id INTEGER REFERENCES roles (id)
);

CREATE TABLE users(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  role_id INTEGER REFERENCES roles (id)
);

CREATE TABLE hour_users(
  hour_id INTEGER REFERENCES hours (id),
  user_id INTEGER REFERENCES users (id)
);

CREATE TABLE hospital_users(
  hospital_id INTEGER REFERENCES hospitals (id),
  user_id INTEGER REFERENCES users (id)
);