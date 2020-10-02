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
    <main>
        <section>
            <p id="update">Poslední aktualizace: <?php echo $json['update'] ?></p>
        </section>
        <section class="covid">
            <div class="covid-card">
                <h3>
                    <?php
                    //echo $json['covid']['active'];
                    echo number_format($json['covid']['active'], 0, ',', ' ')
                    ?>
                </h3>
                <p>Aktivních případů</p>
            </div>
            <div class="covid-card">
                <h3>
                    <?php
                    echo number_format($json['covid']['daily'], 0, ',', ' ')
                    ?>
                </h3>
                <p>Denní nárůst</p>
            </div>
            <div class="covid-card">
                <h3>
                    <?php
                    echo number_format($json['covid']['positiveTests'], 1, ',', ' ')
                    ?>
                </h3>
                <p>% pozitivních testů</p>
            </div>
            <!--<div class="covid-card">
                <h3>
                    <?php
                    //echo number_format($json['covid']['active'], 0, ',', ' ')
                    ?>
                </h3>
                <p>Počet nakažený v Karlovarském kraji</p>
            </div>
            <div class="covid-card">
                <h3>
                    <?php
                    //echo number_format($json['covid']['active'], 0, ',', ' ')
                    ?>
                </h3>
                <p>Počet nakažený v Okrese Karlovy Vary</p>
            </div>-->
        </section>
        <!--<section class="covid">
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
            <div class="daily">
                <h3>
                    <?php
                    echo $json['covid']['daily'];
                    ?>
                </h3>
                <p>Denní nárůst</p>
            </div>
            <div class="daily">
                <h3>
                    <?php
                    echo $json['covid']['daily'];
                    ?>
                </h3>
                <p>Denní nárůst</p>
            </div>
            <div class="daily">
                <h3>
                    <?php
                    echo $json['covid']['daily'];
                    ?>
                </h3>
                <p>Denní nárůst</p>
            </div>
            <div class="daily">
                <h3>
                    <?php
                    echo $json['covid']['daily'];
                    ?>
                </h3>
                <p>Denní nárůst</p>
            </div>
        </section>-->
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
            <!--<canvas id="USD"></canvas>
            <canvas id="EUR"></canvas>-->


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