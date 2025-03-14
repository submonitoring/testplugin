<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {

        return redirect(auth()->user()->getRedirectRoute());

        // return whatever you want as url
        // $url = 'blabla';

        // return redirect()->intended($url);

        // $panel = Auth::user()->panel_role_id;

        // // if ($panel == 1) {

        // //     // dd($panel);

        // //     return redirect('/submonitoring');
        // // } elseif ($panel == 2) {

        // //     return redirect('/jhpadmin');
        // // } elseif ($panel == 3) {

        // //     return redirect('/jhp');
        // // }

        // switch (true) {

        //     case ($panel == 1):

        //         return redirect('/submonitoring');

        //         break;

        //     case ($panel == 2):

        //         return redirect('/jhpadmin');

        //         break;

        //     case ($panel == 3):

        //         return redirect('/jhp');

        //         break;
        // }
    }
}
