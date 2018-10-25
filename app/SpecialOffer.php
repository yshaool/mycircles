<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    /**
     * Get the User record associated with the SpecialOffer.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
