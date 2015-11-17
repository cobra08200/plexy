<?php

namespace App\Http\Controllers\Installer;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Installer\AccountManager;

class AccountController extends Controller
{

    /**
     * @var AccountManager
     */
    private $accountManager;

    /**
     * @param AccountManager $accountManager
     */
    public function __construct(AccountManager $accountManager)
    {
        $this->accountManager = $accountManager;
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
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function createAdminAccount(Request $request)
    {
        $response = $this->accountManager->createAdmin($request);

        return redirect()->route('LaravelInstaller::final')
                         ->with(['message' => $response]);
    }
}
