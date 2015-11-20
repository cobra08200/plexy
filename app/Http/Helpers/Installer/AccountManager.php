<?php

namespace App\Http\Helpers\Installer;

use App\User;
use Exception;
use Illuminate\Http\Request;

class AccountManager
{
    /**
     * Create main admin account.
     *
     * @return array
     */
    public function createAdmin($request, $authenticationResponse)
    {
        try{
            $user = new User;
            $user->name     = $authenticationResponse['user']['username'];
            $user->email    = $authenticationResponse['user']['email'];
            $user->password = $request->input('plex_password');
            $user->verified = true;
            $user->save();
            $user->makeRole('admin');
        }
        catch(Exception $e){
            return $this->response($e->getMessage());
        }

        return $this->response(trans('messages.account.finished'), 'success');
    }

    /**
     * Return a formatted error messages.
     *
     * @param $message
     * @param string $status
     * @return array
     */
    private function response($message, $status = 'danger')
    {
        return array(
            'status'    => $status,
            'message'   => $message
        );
    }
}
