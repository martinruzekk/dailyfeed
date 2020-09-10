<?php
require './includes/dbh.inc.php';

/*$nameday = file_get_contents('https://svatky.adresa.info/json');
$nameday = json_decode($nameday, true);

$holiday = json_decode(file_get_contents('https://date.nager.at/api/v2/publicholidays/2020/CZ'), true);
$holidayDate_now = date('Y-m-d');

foreach ($holiday as $val) {
    if ($holidayDate_now == $val['date']) {
        echo "
        <script>
        let holiday = true;
        </script>
        ";
    }
}*/

//TODO new weather api
//TODO cache počasí

/*function weather($index)
{
    $url = 'api.openweathermap.org/data/2.5/forecast?q=Karlovy%20Vary&appid={API KEY}&mode=json&units=metric';
    $weather = file_get_contents($url);
    //$weather = json_decode(file_get_contents('api.openweathermap.org/data/2.5/forecast?q=Karlovy%20Vary&appid={API KEY}&mode=json&units=metric'), true);

    $time = date('Y-m-d h:i:s');

    //return $api_result['current'][$index];
}*/

/*clear
    mist
    sunny
    overcast
    Moderate or heavy rain shower 
    Patchy rain possible
    Partly cloudy
    Light rain shower
    Light Rain
*/
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
include 'simple_html_dom.php';
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
            <p><span id="date"><?php echo $weekDay . ' ' . date('j.n.Y') ?></span> | <?php echo $nameday[0]['name'] ?>
                <?php
                /*switch (weather('weather_descriptions')[0]) {
                    case 'Clear':
                        echo '<i class="fas fa-moon"></i> ';
                        break;
                    case 'Mist':
                        echo '<i class="fas fa-smog"></i> ';
                        break;
                    case 'Sunny':
                        echo '<i class="fas fa-sun"></i> ';
                        break;
                    case 'Overcast':
                        echo '<i class="fas fa-cloud"></i> ';
                        break;
                    case 'Moderate or heavy rain shower':
                        echo '<i class="fas fa-cloud-showers-heavy"></i> ';
                        break;
                    case 'Patchy rain possible':
                        echo '<i class="fas fa-cloud-rain"></i> ';
                        break;
                    case 'Partly cloudy':
                        echo '<i class="fas fa-cloud-sun"></i> ';
                        break;
                    case 'Light rain shower':
                        echo '<i class="fas fa-cloud-rain"></i> ';
                        break;
                    case 'Light Rain':
                        echo '<i class="fas fa-cloud-rain"></i> ';
                        break;
                    default:
                        echo '<i class="far fa-sun"></i> ';
                        break;
                }
                echo weather('temperature');  */ ?></p>
        </header>
    </div>

    <main>
        <section class="covid">
            <div class="active">
                <?php
                $covidActive = json_decode(file_get_contents('https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/nakazeni-vyleceni-umrti-testy.json'), true);
                $covidActive = end($covidActive['data']);
                $covidActive = $covidActive['kumulativni_pocet_nakazenych'] - $covidActive['kumulativni_pocet_vylecenych'] - $covidActive['kumulativni_pocet_umrti'];

                echo '<h3>' . $covidActive . '</h3>';

                $covidDaily = json_decode(file_get_html('https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/nakaza.json'), true);
                $covidDaily = end($covidDaily['data']);
                ?>
                <p>Aktivních případů</p>
            </div>
            <div class="daily">
                <h3><?php echo $covidDaily['prirustkovy_pocet_nakazenych'] ?></h3>
                <p>Denní nárůst</p>
            </div>
        </section>
        <section class="podcast">
            <img src="./img/12.png" alt="Vinohradská 12">
            <div>
                <?php
                /*$vinohradska_URL = file_get_html('https://podcasts.apple.com/us/podcast/vinohradsk%C3%A1-12/id1458203948?ign-mpt=uo%3D4');
                $vinohradska = $vinohradska_URL->find('p[dir=false]', 2)->plaintext;
                $vinohradska_date = $vinohradska_URL->find('time', 0)->plaintext;
                echo '<h3>' . $vinohradska . '</h3>';
                echo '<p>' . $vinohradska_date . '</p>';*/
                ?>
            </div>
        </section>
        <section class="podcast">
            <img src="./img/studion.jpg" alt="Studio N">
            <div>
                <?php
                /*$studion_URL = file_get_html('https://podcasts.apple.com/cz/podcast/studio-n/id1476533600?l=cs');
                $studion = $studion_URL->find('p[dir=false]', 2)->plaintext;
                $studion_date = $studion_URL->find('time', 0)->plaintext;
                echo '<h3>' . $studion . '</h3>';
                echo '<p>' . $studion_date . '</p>';*/
                ?>
            </div>
        </section>
        <section class="podcast">
            <img src="./img/uks.jpg" alt="U Kulatého stolu">
            <div>
                <?php
                /*$uks_URL = file_get_html('https://podcasts.apple.com/us/podcast/u-kulat%C3%A9ho-stolu/id1461753576');
                $uks = $uks_URL->find('p[dir=false]', 2)->plaintext;
                $uks_date = $uks_URL->find('time', 0)->plaintext;
                echo '<h3>' . $uks . '</h3>';
                echo '<p>' . $uks_date . '</p>';*/
                ?>
            </div>
        </section>
        <section id="jidlo">
            <?php

            /*https: //spsostrov.cz/sites/default/files/2020-09/JL_07-11_09-2020.pdf*/
            $url = "https://spsostrov.cz/sites/default/files/" . date('Y-m/') . "JL_" . date('d-');
            echo $url;
            ?>
            <iframe src="" frameborder="0"></iframe>
        </section>
        <?php
        $cnb = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.xml';
        $cnb = simplexml_load_file($cnb);

        $sql = "SELECT date FROM currancy ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            if ($row = mysqli_fetch_assoc($result)) {
                //$currDate = explode('.', $row['date']);
                //$currDate = date_create($currDate[0] . '.' . $currDate[1] . '.' . $currDate[2]);
                //echo $currDate = date_format($currDate, 'Y-m-d');
                $currDate = $row['date'];

                $cnbDate = explode('.', $cnb['datum']);
                $cnbDate = date_create($cnbDate[2] . '-' . $cnbDate[1] . '-' . $cnbDate[0]);
                $cnbDate = date_format($cnbDate, 'Y-m-d');

                if ($currDate != $cnbDate) {
                    $EUR = str_replace(',', '.', $cnb->tabulka->radek[5]['kurz']);
                    $USD = str_replace(',', '.', $cnb->tabulka->radek[31]['kurz']);
                    $sql = "INSERT INTO currancy (currancy, rate, country, date, amount) VALUES 
                    ('" . $cnb->tabulka->radek[5]['kod'] . "', '" . $EUR . "', 
                    '" . $cnb->tabulka->radek[5]['zeme'] . "', '" . $cnbDate . "', 
                    '" . $cnb->tabulka->radek[5]['mnozstvi'] . "');";

                    mysqli_query($conn, $sql);

                    $sql = "INSERT INTO currancy (currancy, rate, country, date, amount) VALUES 
                    ('" . $cnb->tabulka->radek[31]['kod'] . "', '" . $USD . "', 
                    '" . $cnb->tabulka->radek[31]['zeme'] . "', '" . $cnbDate . "', 
                    '" . $cnb->tabulka->radek[31]['mnozstvi'] . "');";

                    mysqli_query($conn, $sql);
                }
            }
        }
        ?>

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
        /*
        $irozhlas_domov = 'https://www.irozhlas.cz/rss/irozhlas/section/zpravy-domov';
        $irozhlas_domov = simplexml_load_file($irozhlas_domov);

        for ($i = 0; $i < 5; $i++) {
            echo '<section class="irozhlas">';
            echo '<img src="' . $irozhlas_domov->channel->item[$i]->enclosure['url'] . '" class="irozhlas-img">';
            echo '<h4>' . date_format(date_create($irozhlas_domov->channel->item[$i]->pubDate), "j.n.Y H:i") . '</h4>';
            echo '<a href="' . $irozhlas_domov->channel->item[$i]->link . '" target="_blank"><h2>' . $irozhlas_domov->channel->item[$i]->title . '</h2></a>';
            echo '</section>';
        }

        $irozhlas_svet = 'https://www.irozhlas.cz/rss/irozhlas/section/zpravy-svet';
        $irozhlas_svet = simplexml_load_file($irozhlas_svet);
        for ($i = 0; $i < 5; $i++) {
            echo '<section class="irozhlas">';
            echo '<img src="' . $irozhlas_svet->channel->item[$i]->enclosure['url'] . '" class="irozhlas-img">';
            echo '<h4>' . date_format(date_create($irozhlas_svet->channel->item[$i]->pubDate), "j.n.Y H:i") . '</h4>';
            echo '<a href="' . $irozhlas_svet->channel->item[$i]->link . '" target="_blank"><h2>' . $irozhlas_svet->channel->item[$i]->title . '</h2></a>';
            echo '</section>';
        }

        $theVerge = simplexml_load_file('https://www.theverge.com/rss/index.xml');
        for ($i = 0; $i < 5; $i++) {
            echo '<section class="irozhlas">';
            echo '<img src="' . $theVerge->icon . '">';
            echo '<h4>' . date_format(date_create($theVerge->entry[$i]->published), "j.n.Y H:i") . '</h4>';
            echo '<a href="' . $theVerge->entry[$i]->link['href'] . '" target="_blank"><h2>' . $theVerge->entry[$i]->title . '</h2></a>';
            echo '</section>';
        }

*/

        ?>

        <!--//TODO
            iRozhlas -> https://www.irozhlas.cz/rss
            //!YouTube videa
            Vinohradská 12
            Studio N
            U Kulatého Stolu
            The Verge
            //!Radndom fact z historie
            Currancy rates
            Vyznačené svátky
            //!Reddit API
            //?Twitter (Filip Horký?)
            //!data.gov.cz
            //COVID
            //?Wikipedia článek
            //!stock prizes
        -->


    </main>

    <footer>
        <p>&copy; <?php echo date('Y') ?> Martin Růžek</p>
    </footer>


    <script src="./scripts/app.js"></script>
</body>

</html>