-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE Customer(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE Moderator(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE ProductType(
  id SERIAL PRIMARY KEY,
  name varchar(50) UNIQUE NOT NULL
);

CREATE TABLE Product(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL ,
  type varchar(50) REFERENCES ProductType(name),
  count INTEGER NOT NULL,
  price NUMERIC,
  description varchar(400),
  producer varchar(50),
  added DATE,
  updated DATE
);