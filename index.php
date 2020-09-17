<?php

require './includes/dbh.inc.php';
$json = json_decode(file_get_contents('cache.json'), true);

$weekDay = '';
switch (date("D")) {
    case 'Mon':
        $weekDay = 'Pondělí';
        break;
    case 'Tue':
        $weekDay = 'Úterý';
        break;
    case 'Wed':
        $weekDay = 'Středa';
        break;
    case 'Thu':
        $weekDay = 'Čtvrtek';
        break;
    case 'Fri':
        $weekDay = 'Pátek';
        break;
    case 'Sat':
        $weekDay = 'Sobota';
        break;
    case 'Sun':
        $weekDay = 'Neděle';
        break;
    default:
        $weekDay = '';
        break;
}

?>


<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Feed</title>

    <link rel="stylesheet" href="./styles/style.css">
    <link rel="icon" href="./img/favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Noticia+Text:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/868ac28d90.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
</head>

<body>
    <div class="header-wrapper">
        <header>
            <h1>The Daily Feed</h1>
            <p><span id="date"><?php echo $weekDay . ' ' . date('j.n.Y') ?></span> | <?php echo $json['nameday'] ?></p>
        </header>
    </div>

    <?php

    ?>

    <main>
        <section class="covid">
            <div class="active">
                <h3>
                    <?php
                    echo $json['covid']['active'];
                    ?>
                </h3>
                <p>Aktivních případů</p>
            </div>
            <div class="daily">
                <h3>
                    <?php
                    echo $json['covid']['daily'];
                    ?>
                </h3>
                <p>Denní nárůst</p>
            </div>
        </section>
        <section class="podcast">
            <img src="./img/12.png" alt="Vinohradská 12">
            <div>
                <?php
                echo '<h3>' . $json['podcasty']['vinohradska']['title'] . '</h3>';
                echo '<p>' . $json['podcasty']['vinohradska']['date'] . '</p>';
                ?>
            </div>
        </section>
        <section class="podcast">
            <img src="./img/studion.jpg" alt="Studio N">
            <div>
                <?php
                echo '<h3>' . $json['podcasty']['studion']['title'] . '</h3>';
                echo '<p>' . $json['podcasty']['studion']['date'] . '</p>';
                ?>
            </div>
        </section>
        <section class="podcast">
            <img src="./img/uks.jpg" alt="U Kulatého stolu">
            <div>
                <?php
                echo '<h3>' . $json['podcasty']['uks']['title'] . '</h3>';
                echo '<p>' . $json['podcasty']['uks']['date'] . '</p>';
                ?>
            </div>
        </section>
        <section class="jidelna">
            <?php
            echo '<iframe src="' . $json['jidelna']['URL'] . '" frameborder="0"></iframe>';

            ?>
        </section>
        <section class="currancy">
            <canvas id="USD"></canvas>
            <canvas id="EUR"></canvas>

            <script>
                <?php

                ?>
                var USD = document.getElementById('USD').getContext('2d');
                var chart = new Chart(USD, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        labels: [<?php
                                    $sql = "SELECT * FROM currancy WHERE currancy='USD' ORDER BY date ASC LIMIT 10";
                                    $result = mysqli_query($conn, $sql);
                                    $resultCheck = mysqli_num_rows($result);
                                    if ($resultCheck > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "'" . $row['date'] . "', ";
                                        }
                                    }
                                    ?>],
                        datasets: [{
                            label: 'USD',
                            backgroundColor: 'rgb(144,238,144)',
                            borderColor: 'rgb(0,135,61)',
                            //data: [0, 10, 5, 2, 20, 30, 45]
                            data: [
                                <?php
                                $USD_rate = 0;
                                $sql = "SELECT * FROM currancy WHERE currancy='USD' ORDER BY date ASC LIMIT 10";
                                $result = mysqli_query($conn, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo $row['rate'] . ',' . "\n";
                                        $USD_rate = $row['rate'];
                                    }
                                }
                                ?>
                            ]
                        }]
                    },

                    // Configuration options go here
                    options: {
                        title: {
                            display: true,
                            text: 'Current USD rate: <?php echo $USD_rate ?>',
                            position: 'bottom',
                            fontSize: 15
                        }
                    }
                });
                var EUR = document.getElementById('EUR').getContext('2d');
                var chart = new Chart(EUR, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        labels: [<?php
                                    $sql = "SELECT * FROM currancy WHERE currancy='EUR' ORDER BY date ASC LIMIT 10";
                                    $result = mysqli_query($conn, $sql);
                                    $resultCheck = mysqli_num_rows($result);
                                    if ($resultCheck > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "'" . $row['date'] . "', ";
                                        }
                                    }
                                    ?>],
                        datasets: [{
                            label: 'EUR',
                            backgroundColor: 'rgb(144,238,144)',
                            borderColor: 'rgb(0,135,61)',
                            data: [
                                <?php
                                $EUR_rate = 0;
                                $sql = "SELECT * FROM currancy WHERE currancy='EUR' ORDER BY date ASC LIMIT 10";
                                $result = mysqli_query($conn, $sql);
                                $resultCheck = mysqli_num_rows($result);
                                if ($resultCheck > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo $row['rate'] . ',' . "\n";
                                        $EUR_rate = $row['rate'];
                                    }
                                }
                                ?>
                            ]
                        }]
                    },

                    // Configuration options go here
                    options: {
                        title: {
                            display: true,
                            text: 'Current EUR rate: <?php echo $EUR_rate ?>',
                            position: 'bottom',
                            fontSize: 15
                        }
                    }
                });
            </script>
        </section>
        <?php
        foreach ($json['news']['irozhlas'] as $val) {
            echo '<section class="irozhlas">';
            echo '<img src="./img/irozhlas_icon.png" class="ir-img">';
            echo '<h4>' . $val['date'] . '</h4>';
            echo '<a href="' . $val['link'] . '"><h2>' . $val['title'] . '</h2></a>';
            echo '</section>';
            //print_r($val);
        }
        foreach ($json['news']['verge'] as $val) {
            echo '<section class="irozhlas">';
            echo '<img src="./img/verge_icon.png">';
            echo '<h4>' . $val['date'] . '</h4>';
            echo '<a href="' . $val['link'] . '"><h2>' . $val['title'] . '</h2></a>';
            echo '</section>';
            //print_r($val);
        }
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y') ?> Martin Růžek</p>
    </footer>
</body>

</html>