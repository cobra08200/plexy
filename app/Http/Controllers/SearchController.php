<?php

namespace App\Http\Controllers;

// use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function movie(Request $request)
    {

        $parameters = array(
            'api_key'           => \Config::get('services.tmdb.token'),
            'include_adult'     => 'false',
            'search_type'       => 'ngram',
            'query'             => $request->input('query')
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.themoviedb.org/3/search/movie?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function tv($query)
    {
        $parameters = array(
            'api_key'           => \Config::get('services.tmdb.token'),
            'include_adult'     => 'false',
            'search_type'       => 'ngram',
            'query'             => $query
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.themoviedb.org/3/search/tv?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function tvSeries($id)
    {
        // base series info
        $parameters = array(
            'api_key' => \Config::get('services.tmdb.token')
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.themoviedb.org/3/tv/" . $id . "?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $series_response = curl_exec($ch);
        curl_close($ch);

        // $series_json_decoded = json_decode($series_response, true);
        $series_json_decoded = json_decode($series_response);

        // bundle series info to response
        $response['series_info'] = $series_json_decoded;

        // loop seasons to grab episode info
        foreach($series_json_decoded->seasons as $season )
        {
            // series episode info
            $parameters = array(
                'api_key' => \Config::get('services.tmdb.token')
            );

            $ch = curl_init();

            // curl_setopt($ch, CURLOPT_URL, "https://api.themoviedb.org/3/tv/" . $id . "/season/". $season['season_number'] . "?" . http_build_query($parameters));
            curl_setopt($ch, CURLOPT_URL, "https://api.themoviedb.org/3/tv/" . $id . "/season/". $season->season_number . "?" . http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Accept: application/json"
            ));

            $episodes_response = curl_exec($ch);
            curl_close($ch);

            // $episodes_json_decoded = json_decode($episodes_response, true);
            $episodes_json_decoded = json_decode($episodes_response);

            // bundle episode info to response
            // $response['season_'.$season['season_number'].'_episode_info'] = $episodes_json_decoded;
            $response['season_'.$season->season_number.'_episode_info'] = $episodes_json_decoded;

        }

        return $response;
    }

    public function musicArtist($query)
    {

        $parameters = array(
            'client_id' => \Config::get('services.tmdb.token'),
            'type'      => 'artist',
            'limit'     => '8',
            'q'         => $query
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function musicAlbum($query)
    {

        $parameters = array(
            'client_id' => \Config::get('services.tmdb.token'),
            'type'      => 'album',
            'limit'     => '8',
            'market'    => 'US',
            'q'         => $query
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?" . http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function musicAlbumTracks($query)
    {

        // $parameters = array(
        //     'client_id' => \Config::get('services.tmdb.token'),
        //     'type'      => 'album',
        //     'limit'     => '8',
        //     'market'    => 'US',
        //     'q'         => $query
        // );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/albums/" . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
