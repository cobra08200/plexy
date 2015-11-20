<?php

namespace App\Http\Controllers\Installer;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Installer\AccountManager;
use App\Http\Helpers\Installer\EnvironmentManager;

class AccountController extends Controller
{

    /**
     * @var EnvironmentManager
     */
    protected $environmentManager;

    /**
     * @var AccountManager
     */
    private $accountManager;

    /**
     * @param AccountManager $accountManager
     */
    public function __construct(EnvironmentManager $environmentManager, AccountManager $accountManager)
    {
        $this->environmentManager   = $environmentManager;
        $this->accountManager       = $accountManager;
    }

    /**
     * Determine if the first account in the database has ever been created
     *
     * @return \Illuminate\View\View
     */
    public function adminCheck()
    {
        $admin = User::find(1);

        if (!empty($admin)) {
            return redirect()->route('LaravelInstaller::final')
                             ->with(['message' => $response]);
        }

        return view('installer.adminAccount');
    }

    /**
     * Create admin account and set Plex application Token.
     *
     * @return \Illuminate\View\View
     */
    public function createAdminAccount(Request $request)
    {
        $plexUsernameOrEmail = $request->input('plex_username_or_email');
        $plexPassword = $request->input('plex_password');

        // Authenticate the supplied credentials against Plex.
        $authenticationResponse = app('App\Http\Controllers\PlexController')->plexAuthorize($plexUsernameOrEmail, $plexPassword);

        // Deal with Plex authentication error before continuing.
        if (isset($authenticationResponse['error'])) {
            return redirect()->route('LaravelInstaller::admin.account')
                             ->with('danger', $authenticationResponse['error']);
        }

        // Save Plex Token to .env file
        $saveToken = $this->environmentManager->saveToken($authenticationResponse);

        // Create admin account with Plex credentials.
        $response = $this->accountManager->createAdmin($request, $authenticationResponse);

        return redirect()->route('LaravelInstaller::final')
                         ->with(['message' => $response]);
    }
}
