<?php

namespace App\Http\ViewComposers\Backend;

use Illuminate\View\View;

use Auth;

class UserComposer
{

    public function compose(View $view)
    {
        $user = Auth::guard('admins')->user();
        $view->with('userAuth', $user);
    }
}