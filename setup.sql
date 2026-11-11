-- Run as an administrative user after importing world.sql.
CREATE USER IF NOT EXISTS 'lab5_user'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON world.* TO 'lab5_user'@'localhost';

-- Exercise 1: try these queries in phpMyAdmin's SQL tab.
SELECT * FROM countries;
SELECT * FROM cities WHERE country_code = 'JAM';
SELECT DISTINCT language FROM languages WHERE official = 'T' ORDER BY language DESC;
SELECT c.id, c.name AS city, c.country_code, cs.name AS country, c.population
FROM cities c JOIN countries cs ON c.country_code = cs.code
WHERE c.population > 6300000;
