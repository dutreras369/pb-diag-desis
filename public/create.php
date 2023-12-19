<?php

/**
 * Use an HTML form to create a new entry in the
 * votacion table.
 *
 */

require "../config.php";
require "../common.php";

/**
  * Function to query select regions 
  *
  */
 
try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM regions";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $regiones = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

/**
  * Function to query select cities 
  *
  */
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM cities";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $comunas = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

/**
  * Function to query select candidatos 
  *
  */

try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM candidatos";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $candidatos = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

if (isset($_POST['submit'])) {

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_votacion = array(
            "name"              => $_POST['name'],
            "alias"             => $_POST['alias'],
            "rut"               => $_POST['rut'],
            "email"             => $_POST['email'],
            "id_region"         => $_POST['id_region'],
            "id_city"           => $_POST['id_city'],
            "id_candidato"      => $_POST['id_candidato'],
            "consulta"          => $_POST['consulta'],
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "votaciones",
                implode(", ", array_keys($new_votacion)),
                ":" . implode(", :", array_keys($new_votacion))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_votacion);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> Voto agregado correctamente </blockquote>
<?php } ?>

<section id="votacion" class="section-bg">

    <div class="section-header">
        <h3 class="text-center">Formulario De Votacion</h3>
    </div>

    <form method="POST" id="votacionForm">
        <div class="container d-flex justify-content-center">
            <div class="form">
                <div class="forms-row">
                    <div class="form-group p-2">
                        <input for="text" name="name" class="form-control" id="name" placeholder="Nombre Completo" data-rule="minlen:4" data-msg="Ingrese El nombre completo" />
                    </div>

                    <div class="form-group p-2">
                        <input type="text" class="form-control" name="alias" id="alias" placeholder="Alias" data-rule="minlen:4" data-msg="Ingrese alias"/>
                    </div>

                    <div class="form-group p-2">
                        <input type="text" class="form-control" name="rut" id="rut" placeholder="Rut" data-rule="minlen:4" data-msg="Ingrese Rut" />
                    </div>

                    <div class="form-group p-2">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="minlen:4" data-msg="Ingrese una dirección de correo electrónico" />
                    </div>

                    <div class="form-group p-2">
                        <select class="form-select" name="id_region" id="id_region" onchange="getCityByRegion();" aria-label="Seleccione una region">
                            <option value="" selected>Seleccione una region</option>
                            <?php foreach ($regiones as $region) : ?>
                                <option value="<?php echo escape($region["id_region"]); ?>"><?php echo escape($region["name"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                   
                    <div class="form-group p-2">
                        <select class="form-select" name="id_city" id="id_city" aria-label="Seleccione una comuna">
                            <option value="" selected>Seleccione una comuna</option>
                        </select>
                    </div>

                    <div class="form-group p-2">
                        <select class="form-select" name="id_candidato" id="id_candidato" aria-label="Seleccione un candidato">
                            <option value="" selected>Seleccione un candidato</option>
                            <?php foreach ($candidatos as $candidato) : ?>
                                <option value="<?php echo escape($candidato["id_candidato"]); ?>"><?php echo escape($candidato["name"]); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group p-2">
                        <label for="consulta">¿Como se entero de nosotros?</label>
                        <div class="row">
                            <div class="form-check col">
                                <input class="form-check-input" type="radio" name="consulta" id="consulta" value="web" checked>
                                <label class="form-check-label" for="consulta">
                                    Web
                                </label>
                            </div>
                            <div class="form-check col">
                                <input class="form-check-input" type="radio" name="consulta" id="consulta" value="tv" >
                                <label class="form-check-label" for="consulta">
                                    TV
                                </label>
                            </div>
                            <div class="form-check col">
                                <input class="form-check-input" type="radio" name="consulta" id="consulta" value="rss" >
                                <label class="form-check-label" for="consulta">
                                    RSS
                                </label>
                            </div>
                            <div class="form-check col">
                                <input class="form-check-input" type="radio" name="consulta" id="consulta" value="amigo" >
                                <label class="form-check-label" for="amigo">
                                    Amigo
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group p-2">
                        <input class="btn btn-primary text-center" type="submit" name="submit" value="Enviar">
                    </div>

                </div>

            </div>
        </div>

        </div>
    </form>
</section>

<?php include "templates/footer.php"; ?>