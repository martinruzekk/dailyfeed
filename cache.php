<?php

if (isset($_GET['key']) && $_GET['key'] == 'qQ7xy6+bsE9q3Kz6+cadEeKh7TC+#x3sfX+Yb*sHKc6mFckEP7B%s7q35mAk4uSJqFHNPs_F%@Y66xCyA%p5?aT6AjMR=QGR+vvXmsuXjXuzUqExh&MbuKKD9Aj4uPkB') {
    require './includes/dbh.inc.php';
    require 'simple_html_dom.php';

    // Nameday

    $namedayURL = file_get_contents('https://svatky.adresa.info/json');
    $namedayURL = json_decode($namedayURL, true);

    $nameday = $namedayURL[0]['name'];

    // Holiday

    $holidayURL = json_decode(file_get_contents('https://date.nager.at/api/v2/publicholidays/2020/CZ'), true);
    $holidayDate_now = date('Y-m-d');

    $holidayState = false;

    foreach ($holidayURL as $val) {
        if ($holidayDate_now == $val['date']) {
            $holidaySate = true;
        }
    }

    $holiday = $holidayState;

    // Covid

    $covidActive = json_decode(file_get_contents('https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/nakazeni-vyleceni-umrti-testy.json'), true);
    $covidActive = end($covidActive['data']);
    $covidActive = $covidActive['kumulativni_pocet_nakazenych'] - $covidActive['kumulativni_pocet_vylecenych'] - $covidActive['kumulativni_pocet_umrti'];

    $covidDaily = json_decode(file_get_html('https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/nakaza.json'), true);
    $covidDaily = end($covidDaily['data']);

    $covid = array(
        "active" => $covidActive,
        "daily" => $covidDaily['prirustkovy_pocet_nakazenych']
    );


    // Podcasty

    $vinohradskaURL = file_get_html('https://podcasts.google.com/feed/aHR0cHM6Ly9hcGkucm96aGxhcy5jei9kYXRhL3YyL3BvZGNhc3Qvc2hvdy83ODAzODI4LnJzcw');
    $uksURL = file_get_html('https://podcasts.google.com/feed/aHR0cHM6Ly9hbmNob3IuZm0vcy9hZjU2YWI4L3BvZGNhc3QvcnNz');
    $studionURL = file_get_html('https://podcasts.google.com/feed/aHR0cHM6Ly9mZWVkLnBvZGJlYW4uY29tL2Rlbmlrbi9mZWVkLnhtbA');

    $vinohradskaTitle = $vinohradskaURL->find('div[class="e3ZUqe"]', 0)->plaintext;
    $vinohradskaDate = $vinohradskaURL->find('div[class="OTz6ee"]', 0)->plaintext;

    $uksTitle = $uksURL->find('div[class="e3ZUqe"]', 0)->plaintext;
    $uksDate = $uksURL->find('div[class="OTz6ee"]', 0)->plaintext;

    $studionTitle = $studionURL->find('div[class="e3ZUqe"]', 0)->plaintext;
    $studionDate = $studionURL->find('div[class="OTz6ee"]', 0)->plaintext;

    $podcasty = array(
        "vinohradska" => array(
            "title" => $vinohradskaTitle,
            "date" => $vinohradskaDate
        ),
        "uks" => array(
            "title" => $uksTitle,
            "date" => $uksDate
        ),
        "studion" => array(
            "title" => $studionTitle,
            "date" => $studionDate
        )
    );
    // Jidelna

    $jidloURL = file_get_html('https://spsostrov.cz/skolni-jidelna');
    $jidelniListek = $jidloURL->find('span[class="file-link"] a', 0);
    $pdfLink = $jidelniListek->href;

    $jidelna = array(
        "URL" => $pdfLink
    );

    // Currancy
    $cnb = simplexml_load_file('https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.xml');

    $sql = "SELECT date FROM currancy ORDER BY date DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
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

    // News

    $news = array();

    // iRozhlas

    $irozhlas_domov = simplexml_load_file('https://www.irozhlas.cz/rss/irozhlas/section/zpravy-domov');
    $irozhlas_svet = simplexml_load_file('https://www.irozhlas.cz/rss/irozhlas/section/zpravy-svet');

    $news['irozhlas'] = array();

    for ($i = 0; $i < 5; $i++) {
        $irArray = array(
            "img" => (string)$irozhlas_domov->channel->item[$i]->enclosure['url'],
            "title" => (string)$irozhlas_domov->channel->item[$i]->title,
            "date" => date_format(date_create($irozhlas_domov->channel->item[$i]->pubDate), "j.n.Y H:i"),
            "link" => (string)$irozhlas_domov->channel->item[$i]->link,
            "source" => "home"
        );
        array_push($news['irozhlas'], $irArray);
    }

    for ($i = 0; $i < 5; $i++) {
        $irArray = array(
            "img" => (string)$irozhlas_svet->channel->item[$i]->enclosure['url'],
            "title" => (string)$irozhlas_svet->channel->item[$i]->title,
            "date" => date_format(date_create($irozhlas_svet->channel->item[$i]->pubDate), "j.n.Y H:i"),
            "link" => (string)$irozhlas_svet->channel->item[$i]->link,
            "source" => "world"
        );
        array_push($news['irozhlas'], $irArray);
    }


    // The Verge

    $theVerge = simplexml_load_file('https://www.theverge.com/rss/index.xml');
    $news['verge'] = array();

    for ($i = 0; $i < 5; $i++) {
        $veArray = array(
            "title" => (string)$theVerge->entry[$i]->title,
            "date" => date_format(date_create($theVerge->entry[$i]->published), "j.n.Y H:i"),
            "link" => (string)$theVerge->entry[$i]->link['href']
        );
        array_push($news['verge'], $veArray);
    }

    //Finalization

    $final = array(
        "nameday" => $nameday,
        "holiday" => $holiday,
        "covid" => $covid,
        "jidelna" => $jidelna,
        "podcasty" => $podcasty,
        "news" => $news
    );

    file_put_contents('cache.json', json_encode($final));
}
