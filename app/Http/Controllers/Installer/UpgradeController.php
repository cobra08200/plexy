<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Installer\UpgradeManager;

class UpgradeController extends Controller
{
    /**
     * Display upgrade welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        $currentVersion = $this->getCurrentVersion();

        return view('installer.upgradeWelcome', compact('currentVersion'));
    }

    /**
     * Update database and seed tables.
     *
     * @param UpgradeManager $manager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(UpgradeManager $manager)
    {
        $response = $manager->updateDatabaseAndSeedTables();

        return redirect()->route('LaravelInstaller::final')
                         ->with(['message' => $response]);
    }

    /**
     * Get current installed version.
     *
     * @return string
     */
    private function getCurrentVersion()
    {
        return file_get_contents(storage_path('installed'));
    }

}
