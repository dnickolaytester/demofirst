<?php

function doRequest($URL) {
    if(!function_exists('curl_init')) {
        die ("Curl PHP package not installedn");
    }

    /*Initializing CURL*/
    $curlHandle = curl_init();

    /*The URL to be downloaded is set*/
    curl_setopt($curlHandle, CURLOPT_URL, $URL);
    /*Return the HTTP headers*/
    curl_setopt($curlHandle, CURLOPT_HEADER, true);
    /*Now execute the CURL, download the URL specified*/
    $response = curl_exec($curlHandle);

    return $response;
}


function isCorrectAnswer($body, $tagName, $value) {

    $dom = new DOMDocument;
    $dom->loadXML($body);
    $books = $dom->getElementsByTagName($tagName);

    $valueFromXML = null;
    if($books->length) {
        //echo PHP_EOL;
        //print_r($books);

        foreach ($books as $book) {
            //echo $book->nodeValue, PHP_EOL;
            $valueFromXML = $book->nodeValue;
        }
    }

    //echo '[' . $valueFromXML . '] & [' . $value .']' . PHP_EOL;

    if(strcasecmp($value, $valueFromXML) == 0) {
        //echo 'strings are equal' . PHP_EOL;
        return true;
    } else {
        //echo 'strings are not equal' . PHP_EOL;
    }


    return false;
}


function doSave($info) {
    $dt = $info[0];
    $wait = $info[1];
    $state = $info[2];
    $body = $info[3];
    $headers = $info[4];

    $conn = pg_connect("host=localhost dbname=mydb user=postgres password=pg1234")
        or die('Could not connect: ' . pg_last_error());


    $query = 'select max(id_req) from main';

    //print_r($query);

    $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
    $line = pg_fetch_array($result, null, PGSQL_ASSOC);

    $max_id = isset($line['max']) ? $line['max'] : 0;
    //print_r($max_id);

    $max_id = $max_id + 1;
    $insert = 'INSERT INTO main (id_req, dt_ex, wait, state)';
    $insert = $insert . 'VALUES (' . $max_id .', ' . $dt . ', ' . $wait .', ' . $state . ');';

    //print_r($insert);
    $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
    //print_r($result);

    $insert = 'INSERT INTO response(id_req, body, headers)';
    $insert = $insert . 'VALUES (' . $max_id .', ' . $body . ', ' . $headers . ');';

    //print_r($insert);
    $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
    //print_r($result);


    pg_free_result($result);
    pg_close($conn);
}