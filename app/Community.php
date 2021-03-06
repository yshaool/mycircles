<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    /**
     * Get the CommunityMembers records associated with the Community.
     */
    public function communityMembers()
    {
        return $this->hasMany('App\CommunityMember');
    }

    public function isUserOwner($user_id){
        return $this->user_id==$user_id;
    }
}
