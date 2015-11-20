<?php

namespace App\Http\Helpers\Installer;

use Exception;
use Illuminate\Http\Request;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * @var string
     */
    private $envTempPath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
        $this->envTempPath = base_path('.env.tmp');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Save the edited content to the file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFile(Request $input)
    {
        $message = trans('messages.environment.success');

        try {
            file_put_contents($this->envPath, $input->get('envConfig'));
        }
        catch(Exception $e) {
            $message = trans('messages.environment.errors');
        }

        return $message;
    }

    /**
     * Save the Plex token to the file.
     *
     * @param Request $input
     * @return string
     */
    public function saveToken($authenticationResponse)
    {
        $message = trans('messages.environment.successToken');

        try {
            $reading = fopen($this->envPath, 'r');
            $writing = fopen($this->envTempPath, 'w');

            $replaced = false;

            while (!feof($reading)) {
                $line = fgets($reading);

                if (stristr($line,'PLEX_TOKEN=')) {
                $line = "PLEX_TOKEN=" . $authenticationResponse['user']['authentication_token'] . "\n";
                $replaced = true;
                }

                fputs($writing, $line);
            }

            fclose($reading);
            fclose($writing);

            // If token was saved, save new .env
            if ($replaced)
            {
                rename($this->envTempPath, $this->envPath);
            } else {
                unlink($this->envTempPath);
            }
        }
        catch(Exception $e) {
            $message = trans('messages.environment.errors');
        }

        return $message;
    }
}
