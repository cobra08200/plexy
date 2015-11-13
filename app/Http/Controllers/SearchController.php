<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $movies = $this->movie($request);
        $tv     = $this->tv($request);
        $music  = $this->musicAlbum($request);

        $part_one = array_merge($movies, $tv);
        $part_two['results'] = array_merge($part_one, $music);

        return json_encode($part_two);
    }

    public function movie(Request $request)
    {
        $parameters = array(
            'api_key'           => config('services.tmdb.token'),
            'include_adult'     => 'false',
            'search_type'       => 'ngram',
            'query'             => $request->input('query')
        );

        $url = "https://api.themoviedb.org/3/search/movie?" . http_build_query($parameters);

        $array = json_decode($this->c($url), true);

        $movie_array = array();

        foreach($array['results'] as $item) {
            $movie_array[] = array_add($item, 'type', 'movies');
        }

        return $movie_array;
    }

    public function tv(Request $request)
    {
        $parameters = array(
            'api_key'           => config('services.tmdb.token'),
            'include_adult'     => 'false',
            'search_type'       => 'ngram',
            'query'             => $request->input('query')
        );

        $url = "https://api.themoviedb.org/3/search/tv?" . http_build_query($parameters);

        $array = json_decode($this->c($url), true);

        $tv_array = array();

        foreach($array['results'] as $item) {
            $tv_array[] = array_add($item, 'type', 'tv');
        }

        return $tv_array;
    }

    public function tvSeries($id)
    {
        $parameters = array(
            'api_key' => config('services.tmdb.token')
        );

        $url = "https://api.themoviedb.org/3/tv/" . $id . "?" . http_build_query($parameters);

        $response = json_decode($this->c($url), true);

        return $response;
    }

    public function tvSeasonEpisodes($id, $season)
    {
        $parameters = array(
            'api_key' => config('services.tmdb.token')
        );

        $url = "https://api.themoviedb.org/3/tv/" . $id . "/season/". $season . "?" . http_build_query($parameters);

        $response = json_decode($this->c($url), true);

        $episodes = array_only($response, 'episodes');

        return $episodes;
    }

    public function musicArtist(Request $request)
    {

        $parameters = array(
            'client_id' => config('services.tmdb.token'),
            'type'      => 'artist',
            'limit'     => '8',
            'q'         => $request->input('query')
        );

        $url = "https://api.spotify.com/v1/search?" . http_build_query($parameters);

        $response = $this->c($url);

        return $response;
    }

    public function musicAlbum(Request $request)
    {
        $parameters = array(
            'client_id' => config('services.tmdb.token'),
            'type'      => 'album',
            'limit'     => '8',
            'market'    => 'US',
            'q'         => $request->input('query')
        );

        $url = "https://api.spotify.com/v1/search?" . http_build_query($parameters);

        $array = json_decode($this->c($url), true);

        $music_album_array = array();

        foreach($array['albums']['items'] as $item) {
            $music_album_array[] = array_add($item, 'type', 'music');
        }

        return $music_album_array;
    }

    public function musicAlbumTracks($id)
    {
        $url = "https://api.spotify.com/v1/albums/" . $id;

        $tracks_response = json_decode($this->c($url), true);

        $tracks = array_only($tracks_response, 'tracks');

        return $tracks['tracks']['items'];
    }

    public function c($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
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
