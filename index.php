<?php

if (isset($_POST['url'])) {
    if (!filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
        $response = array(
            'error' => array(
                'message' => 'URL is invalid'
            )
        );
    }
    else {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_POST['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $parameters = array();
        foreach ($_POST['parameters']['keys'] as $i => $key) {
            $parameters[$key] = $_POST['parameters']['values'][$i];
        }        
        switch ($_POST['method']) {
            case 'GET':
                curl_setopt($ch, CURLOPT_URL, $_POST['url'] . '?' . http_build_query($parameters));
            break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            break;
        }
        $result = curl_exec($ch);
        if ($result === false) {
            $response = array(
                'error' => array(
                    'code' => curl_errno($ch),
                    'message' => curl_error($ch)
                )
            );
        }
        else {
            $response = array(
                'result' => $result
            );
        }
        curl_close($ch);
    }    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

include 'templates/http-client.tpl.php';