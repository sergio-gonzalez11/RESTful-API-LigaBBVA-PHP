<?php
  
    include 'Api.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>RESTful API - Liga Bbva - Sergio González Ruano</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="page-header mb-4 mt-4">
            <h1>RESTful API - PHP - Liga Bbva - Sergio González Ruano</h1>
        </div>

        <?php
            $api = new Api();
            echo "<p><hr><p>";    
        ?>

        <h3>Partidos anteriores a la jornada actual</h3>
        <table class="table table-sm">
            <tr class="table-success">
                <th>Local</th>
                <th></th>
                <th>Visitante</th>
                <th colspan="3">Resultado</th>
            </tr>
            <?php foreach ($api->buscarPartidosAnterioresJornadaActual(2014, 2)->matches as $match) { ?>
            <tr>
                <td><?php echo $match->homeTeam->name; ?></td>
                <td>-</td>
                <td><?php echo $match->awayTeam->name; ?></td>
                <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                <td>:</td>
                <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
            </tr>
            <?php } ?>
        </table>


        <div class="container" style="margin-top:100px;">
            <div class="jumbotron jumbotron-fluid" style="margin-bottom:0px;">
                <div class="container">
                    <h1 class="display-4">Liga BBVA - clasificación</h1>
                </div>
            </div>
            <table class="table table-striped">
                <tr class="table-primary">
                    <th>Posicion</th>
                    <th>Equipo</th>
                    <th>P/jugados</th>
                    <th>Ganados</th>
                    <th>Empate</th>
                    <th>Perdidos</th>
                    <th>Goles a favor</th>
                    <th>Goles en contra</th>
                    <th>Diferencia de goles</th>
                    <th>Puntos</th>
                </tr>

                <?php foreach ($api->clasificacionGeneral(2014)->standings as $standing) { 
                          if ($standing->type == 'TOTAL') { 
                              foreach ($standing->table as $standingRow) {
                    ?>
                <tr>
                    <td><?php echo $standingRow->position; ?></td>
                    <td><?php echo $standingRow->team->name; ?></td>
                    <td><?php echo $standingRow->playedGames; ?></td>
                    <td><?php echo $standingRow->won; ?></td>
                    <td><?php echo $standingRow->draw; ?></td>
                    <td><?php echo $standingRow->lost; ?></td>
                    <td><?php echo $standingRow->goalsFor; ?></td>
                    <td><?php echo $standingRow->goalsAgainst; ?></td>
                    <td><?php echo $standingRow->goalDifference; ?></td>
                    <td><?php echo $standingRow->points; ?></td>
                </tr>
                <?php }}} ?>
                <tr>
                </tr>
            </table>
        </div>

        <?php
                echo "<p><hr><p>";

                $now = new DateTime();
                $end = new DateTime(); $end->add(new DateInterval('P3D'));
                $response = $api->buscarPartidosPorFecha($now->format('Y-m-d'), $end->format('Y-m-d'));
        ?>

        <div class="container" style="margin-top:100px;">
            <h3>Próximos partidos de los equipos de la liga bbva</h3>
            <table class="table table-sm">
                <tr class="table-success">
                    <th>Local</th>
                    <th></th>
                    <th>Visitante</th>
                    <th colspan="3">Resultado</th>
                </tr>
                <?php foreach ($response->matches as $match) { ?>
                <tr>
                    <td><?php echo $match->homeTeam->name; ?></td>
                    <td>-</td>
                    <td><?php echo $match->awayTeam->name; ?></td>
                    <td><?php echo $match->score->fullTime->homeTeam; ?></td>
                    <td>:</td>
                    <td><?php echo $match->score->fullTime->awayTeam; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

</body>

</html>