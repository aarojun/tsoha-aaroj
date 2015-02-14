-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE FlightInformation(
  id SERIAL PRIMARY KEY,
  flightid varchar(50) NOT NULL,
  seat INTEGER NOT NULL,
  active BOOLEAN DEFAULT TRUE
);

CREATE TABLE Customer(
  id SERIAL PRIMARY KEY,
  name varchar(50) UNIQUE NOT NULL,
  password varchar(50) NOT NULL,
  flightseating INTEGER REFERENCES FlightInformation(id)
);

CREATE TABLE Administrator(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE ProductType(
  id SERIAL PRIMARY KEY,
  name varchar(10) UNIQUE NOT NULL
);

CREATE TABLE Product(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL ,
  type varchar(50) REFERENCES ProductType(id),
  price NUMERIC,
  available INTEGER NOT NULL,
  producer varchar(50),
  description varchar(400),
  countryoforigin varchar(50),
  added DATE,
  updated DATE
);

CREATE TABLE Tilaus(
  id SERIAL PRIMARY KEY,
  product INTEGER REFERENCES Product(id) NOT NULL,
  customer INTEGER REFERENCES Customer(id) NOT NULL,
  quantity INTEGER NOT NULL
);