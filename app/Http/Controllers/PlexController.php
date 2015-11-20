<?php

namespace App\Http\Controllers;

use App\User;
use Storage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class PlexController extends Controller
{

    public function plexAuthorize($plexUsernameOrEmail, $plexPassword)
    {
        $host = "https://plex.tv/users/sign_in.json";
        $header = array(
            'Content-Type: application/json',
            'Content-Length: 0',
            'X-Plex-Platform: Laravel',
            'X-Plex-Platform-Version: 5.1',
            'X-Plex-Client-Identifier: ' . uniqid() . '',
            'X-Plex-Product: Plexy',
            'X-Plex-Version: v1.0',
            'X-Plex-Device: PHP',
            'X-Plex-Device-Name: Plexy',
            );
        $process = curl_init($host);
        curl_setopt($process, CURLOPT_HTTPHEADER, $header);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($process, CURLOPT_USERPWD, $plexUsernameOrEmail . ":" . $plexPassword);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($process);
        $curlError = curl_error($process);
        $json = json_decode($data, true);

        return $json;
    }

    public function plexFriends()
    {
        $parameters = array(
            'X-Plex-Token' => config('services.plex.token')
        );

        $url = "https://plex.tv/pms/friends/all?" . http_build_query($parameters);

        $xml = simplexml_load_string($this->c($url));

        $json = json_encode($xml);

        $friends = json_decode($json, true);

        return $friends;
    }

    public function plexVerifyFriend($usernameOrEmail)
    {
        if (User::where('name', '=', $usernameOrEmail)->where('id', '=', 1)->exists() || User::where('email', '=', $usernameOrEmail)->where('id', '=', 1)->exists()) {
            return true;
        }

        $friends = $this->plexFriends();

        // Check if the login attempt is a friend of the server owner or the server owner.
        foreach ($friends['User'] as $f) {
            foreach ($f['@attributes'] as $key => $value) {
                // If the authenticated user is a friend of the server owner, add them as a user with their Plex credentials.
                if ($key == 'email' && strtolower($value) == $usernameOrEmail) {
                    return true;
                } elseif ($key == 'username' && strtolower($value) == $usernameOrEmail) {
                    return true;
                }
            }
        }

        return false;
    }

    public function plexServerInfo()
    {
        $parameters = array(
            'X-Plex-Token' => config('services.plex.token')
        );

        $url = config('services.plex.url') . "?" . http_build_query($parameters);

        return json_decode($this->c($url), true);
    }

    public function plexTranscodeSessions()
    {
        $parameters = array(
            'X-Plex-Token' => config('services.plex.token')
        );

        $url = config('services.plex.url') . "/transcode/sessions?" . http_build_query($parameters);

        return json_decode($this->c($url), true);
    }

    // This is not working via curl
    public function plexDeleteTranscodeSession($transcodeSessionKey)
    {
        $parameters = array(
            'X-Plex-Token'  => config('services.plex.token'),
        );

        $url = config('services.plex.url') . "/transcode/sessions/" . $transcodeSessionKey . "?" . http_build_query($parameters);

        return json_decode($this->c_delete($url), true);
    }

    public function plexServerSearch(Request $request)
    {
        $parameters = array(
            'X-Plex-Token'  => config('services.plex.token'),
            'query'         => $request->input('query'),
        );

        $url = config('services.plex.url') . "/search?" . http_build_query($parameters);

        $array = json_decode($this->c($url), true);

        // Add id key to array so Select2 can highlight and select.
        $id = 1;

        foreach ($array['_children'] as &$item) {

            // Check if the search element has an associated thumbnail, if so, save it.
            // We do this so images can be accessed later without plex server token authentication.
            if (isset($item['thumb'])) {

                // Directly access the thumbnail on the Plex server and save it the URL as a variable.
                $thumbPath = config('services.plex.url') . $item['thumb'] . '?X-Plex-Token='. config('services.plex.token');

                // Plex stripes the filetype extension. This finds out what it should be.
                $thumbExtension = image_type_to_extension(exif_imagetype($thumbPath));

                // // Base64 Example. Warning: this generates a massive base64 string.
                // $item['thumb'] = $base64 = 'data:image/' . $thumbType . ';base64,' . base64_encode($thumbData);

                // Check if thumb has already been saved
                if (!Storage::exists('plex/thumbs/'.$item['ratingKey'].$thumbExtension)) {
                    // Save thumb to plex/thumbs/{ratingKey}.{extension}
                    Storage::put(
                        'plex/thumbs/'.$item['ratingKey'].$thumbExtension,
                        file_get_contents($thumbPath)
                    );
                }

                $item['thumb'] = url('plex/thumbs/'.$item['ratingKey'].$thumbExtension);
                // $item['thumb'] = route('plex.thumb.preview', ['ratingKey' => $item['ratingKey'], 'thumbExtension' => $thumbExtension]);

            }

            // Add results_from key to array so Select2 can filter.
            $item['results_from'] = 'plex_server';

            // Add id key to array so Select2 can highlight and select.
            $item['id'] = $id;

            // Iterate the ID for each item.
            $id++;

        }

        // Final touches for Select2 data reults array.
        $plexFinalArray['results'] = $array['_children'];

        return $plexFinalArray;
    }

    public function previewPlexThumb($ratingKey, $thumbExtension)
    {
        // // This single line will display an image if a route hits this with a 200 response
        // return response()->download(storage_path('app/plex/thumbs/'.$ratingKey.'.'.$thumbExtension), null, [], null);

        // This will return a 200 image response, and a 304 if it is cached
        $path = storage_path('app/plex/thumbs/'.$ratingKey.'.'.$thumbExtension);
        $handler = new \Symfony\Component\HttpFoundation\File\File($path);

        $lifetime = 31556926; // One year in seconds

        /**
        * Prepare some header variables
        */
        $file_time = $handler->getMTime(); // Get the last modified time for the file (Unix timestamp)

        $header_content_type = $handler->getMimeType();
        $header_content_length = $handler->getSize();
        $header_etag = md5($file_time . $path);
        $header_last_modified = gmdate('r', $file_time);
        $header_expires = gmdate('r', $file_time + $lifetime);

        $headers = array(
            'Content-Disposition' => 'inline; filename="' . $ratingKey.$thumbExtension . '"',
            'Last-Modified' => $header_last_modified,
            'Cache-Control' => 'must-revalidate',
            'Expires' => $header_expires,
            'Pragma' => 'public',
            'Etag' => $header_etag
        );

        // Is the resource cached?
        $h1 = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == $header_last_modified;
        $h2 = isset($_SERVER['HTTP_IF_NONE_MATCH']) && str_replace('"', '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) == $header_etag;

        if ($h1 || $h2) {
            return Response::make('', 304, $headers); // File (image) is cached by the browser, so we don't have to send it again
        }

        $headers = array_merge($headers, array(
            'Content-Type' => $header_content_type,
            'Content-Length' => $header_content_length
        ));

        return Response::make(file_get_contents($path), 200, $headers);
    }

    public function updatePlexThumbnail($thumbKey, $thumbExtension)
    {
        $thumbPath = config('services.plex.url') . '/library/metadata/' . $thumbKey . '/thumb' . '?X-Plex-Token='. config('services.plex.token');

        // I could potentially update the item in the DB to allow the correct file extension
        // but for now I will replace the existing file with the old extention
        // $thumbExtension = image_type_to_extension(exif_imagetype($thumbPath));

        Storage::put(
            'plex/thumbs/' . $thumbKey . '.' . $thumbExtension,
            file_get_contents($thumbPath)
        );

        return Redirect::to('/');
    }

    public function plexTVShowEpisodes($ratingKey)
    {
        $parameters = array(
            'X-Plex-Token'  => config('services.plex.token'),
        );

        $url = config('services.plex.url') . "/library/metadata/" . $ratingKey . "/allLeaves?" . http_build_query($parameters);

        $array = json_decode($this->c($url), true);

        return $array['_children'];
    }

    public function plexTVShowSeasonEpisodes($ratingKey, $seasonNumber)
    {
        $seasonEpisodes = $this->plexTVShowEpisodes($ratingKey);

        foreach ($seasonEpisodes as $episode) {
            if ($episode['parentIndex'] == $seasonNumber) {
                $seasonNumberEpisodes[] = $episode;
            }
        }

        return $seasonNumberEpisodes;
    }

    public function plexAlbumTracks($ratingKey)
    {
        $parameters = array(
            'X-Plex-Token'  => config('services.plex.token'),
        );

        $url = config('services.plex.url') . "/library/metadata/" . $ratingKey . "/children?" . http_build_query($parameters);

        $array = json_decode($this->c($url), true);

        return $array['_children'];
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

    public function c_delete($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
