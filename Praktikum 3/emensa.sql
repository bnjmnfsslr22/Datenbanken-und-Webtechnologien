-- Datenbank erstellen
CREATE DATABASE emensa;

-- Tabelle für Newsletter-Anmeldungen
CREATE TABLE newsletter_signups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    language VARCHAR(50)
);

-- Tabelle für Gerichte
CREATE TABLE dishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT
);

-- Tabelle für Besucherzähler
CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(50),
    visit_date DATE
);
