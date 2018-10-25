<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    /**
     * Get the User record associated with the CommunityMember.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the User record associated with the CommunityMember.
     */
    public function community()
    {
        return $this->belongsTo('App\Community');
    }
}
