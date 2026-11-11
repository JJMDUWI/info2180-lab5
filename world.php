<?php
header('Content-Type: text/html; charset=utf-8');
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? 'countries';
if (!is_string($country) || !is_string($lookup)) {
    http_response_code(400);
    exit('<p>Please enter a valid country name.</p>');
}
$country = trim($country);
$host = '127.0.0.1';
$port = getenv('WORLD_DB_PORT') ?: '3306';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';
try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($lookup === 'cities') {
        $sql = 'SELECT cities.name, cities.district, cities.population
                FROM cities JOIN countries ON cities.country_code = countries.code
                WHERE countries.name LIKE :country ORDER BY cities.name';
        $columns = ['name' => 'Name', 'district' => 'District', 'population' => 'Population'];
    } else {
        $sql = 'SELECT name, continent, independence_year, head_of_state
                FROM countries WHERE name LIKE :country ORDER BY name';
        $columns = ['name' => 'Country Name', 'continent' => 'Continent',
                    'independence_year' => 'Independence Year', 'head_of_state' => 'Head of State'];
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute(['country' => '%' . $country . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    http_response_code(500);
    error_log($exception->getMessage());
    exit('<p>Unable to load results. Please check that the database is running and try again.</p>');
}
if (!$results) {
    exit('<p>No results found. Try another country name.</p>');
}
?>
<p class="result-count"><?= count($results) ?> result<?= count($results) === 1 ? '' : 's' ?> found</p>
<div class="table-scroll">
<table>
    <caption><?= $lookup === 'cities' ? 'City lookup results' : 'Country lookup results' ?></caption>
    <thead><tr>
        <?php foreach ($columns as $heading): ?>
        <th scope="col"><?= $heading ?></th>
        <?php endforeach; ?>
    </tr></thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <?php foreach ($columns as $key => $heading): ?>
            <td><?= htmlspecialchars((string) ($row[$key] ?? 'N/A'), ENT_QUOTES, 'UTF-8') ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
