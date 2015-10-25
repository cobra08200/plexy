<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlexController extends Controller
{

    public function plexAuthorize()
    {
        $host = "https://plex.tv/users/sign_in.json";
        $username = \Config::get('services.plex.username');
        $password = \Config::get('services.plex.password');
        $header = array(
            'Content-Type: application/xml; charset=utf-8',
            'Content-Length: 0',
            'X-Plex-Client-Identifier: 8334-8A72-4C28-FDAF-29AB-479E-4069-C3A3',
            'X-Plex-Product: Test',
            'X-Plex-Version: v1_06',
            );
        $process = curl_init($host);
        curl_setopt($process, CURLOPT_HTTPHEADER, $header);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($process);
        $curlError = curl_error($process);
        $json = json_decode($data, true);

        return $json;
    }

    public function plexServerInfo()
    {
        $parameters = array(
            'X-Plex-Token' => \Config::get('services.plex.token')
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, \Config::get('services.plex.url') . "?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function plexServerSessions()
    {
        $parameters = array(
            'X-Plex-Token' => \Config::get('services.plex.token')
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, \Config::get('services.plex.url') . "status/sessions?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

}
