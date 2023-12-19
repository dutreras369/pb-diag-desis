<?php
require "../config.php";
require "../common.php";

if (isset($_POST['getCityByRegion']) == "getCityByRegion") {
    $id_region = $_POST['id_region'];

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM cities WHERE id_region='$id_region'";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $cities   = $statement->fetchAll();
    $cityData = '<option value="">Seleccione Comuna</option>';

    foreach ($cities as $city) : 
        $cityData .= '<option value="'.$city["id_city"].'">'.$city["name"].'</option>';
    endforeach;

    echo "test^".$cityData;
}