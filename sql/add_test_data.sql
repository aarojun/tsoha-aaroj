-- Lisää INSERT INTO lauseet tähän tiedostoon

-- User, Moderator-taujen testidata
INSERT INTO Customer (name, password) VALUES ('Aaro', 'asd');
INSERT INTO Moderator (name, password) VALUES ('Juhani', 'dvorak');

-- ProductType-taulun testidata
INSERT INTO ProductType (name) VALUES ('testi');

-- Product-taulun testidata
INSERT INTO Product (name, type, count, price, description) VALUES ('Toblerone suklaa', 'testi', 7, 3.00, 'nam');
INSERT INTO Product (name, type, count, price) VALUES ('Kirja', 'testi', 7, 3.00);