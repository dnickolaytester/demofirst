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


function isCorrectAnswer($answer) {

    return true;
}
