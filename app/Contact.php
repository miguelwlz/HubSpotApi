<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //

    public function getContacts($mail = '')
    {
        return Contact::where('mail', 'like', '%' . $mail . '%')->get();
    }
}
