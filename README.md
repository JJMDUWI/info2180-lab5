# INFO2180 Lab 5

This is Lab 5 for Jordan Morais-Duke on PHP and MySQL.

## Run with XAMPP / MAMP

1. Start Apache and MySQL.
2. Clone this repository into your server's `htdocs` directory.
3. Open phpMyAdmin and import `world.sql`. **This supplied script drops and recreates the `world` database**, so do not import it over a database you need to keep.
4. Run `setup.sql` as an administrative database user. It creates the lab account and includes the Exercise 1 practice queries.
5. Visit `http://localhost/info2180-lab5/` (use your server's port if different).

`world.php` uses PDO with the lab credentials `lab5_user` / `password123`, database `world`, and port 3306. These are local coursework credentials. If your database uses another port, set the `WORLD_DB_PORT` environment variable before starting PHP.

## Features

- Lookup returns Country Name, Continent, Independence Year and Head of State.
- Lookup Cities joins `countries` and `cities`, returning Name, District and Population.
- Both buttons support partial country names; a blank country lookup lists every country.
- JavaScript fetches HTML results without reloading the page. Enter also performs a country lookup.
- Prepared PDO statements bind search input; database text is escaped when rendered.
- Empty results and request failures have readable messages.

## Files

- `index.html`: search interface and results container.
- `world.css`: responsive page and table styling.
- `world.js`: AJAX requests and click/submit handlers.
- `world.php`: PDO connection, SQL queries and HTML table output.
- `world.sql`: unchanged lecturer-supplied database dump.
- `setup.sql`: lab account setup and practice queries.

The supplied database contains historical records. Names, populations and heads of state reflect that dataset.

## Git workflow

Implementation is on `php-mysql-implementation`, merged into `main` for submission.

## Validation

Tested locally with PHP/PDO and an isolated MariaDB server using the supplied database (239 countries, 4,079 cities and 984 language records). Browser checks passed for full and partial searches, blank country lookup, mixed case and whitespace, Jamaica's three city results, no matches, malformed requests, SQL/HTML input, Enter submission, request failure recovery, and a 375px mobile viewport.
