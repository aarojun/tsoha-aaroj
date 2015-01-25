-- Lisää INSERT INTO lauseet tähän tiedostoon

-- Customer, Administrator-taulujen testidata
INSERT INTO Customer (name, password) VALUES ('Aaro', 'asd');
INSERT INTO Administrator (name, password) VALUES ('Juhani', 'dvorak');

-- FlightInformation-taulujen testidata
INSERT INTO FlightInformation (flightid, seat) VALUES ('BEO-027', 56);

-- ProductType-taulun testidata
INSERT INTO ProductType (name) VALUES ('testi');

-- Product-taulun testidata
INSERT INTO Product (name, type, available, price, added) VALUES ('Toblerone suklaa', 'testi', 7, 3.00, NOW());
INSERT INTO Product (name, type, available, price, added) VALUES ('Kirja', 'testi', 7, 3.00, NOW());

-- Tilaus-taulun testidata
