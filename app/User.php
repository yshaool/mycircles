<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the CommunityMembers records associated with the User.
     */
    public function communityMembers()
    {
        return $this->hasMany('App\CommunityMember');
    }

    /**
     * Get the specialOfferss records associated with the User.
     */
    public function specialOffers()
    {
        return $this->hasMany('App\SpecialOffer');
    }

    /**
     * Get all of the Communities for the User.
     */

    public function communities()
    {
        return $this->hasManyThrough(
            'App\Community',
            'App\CommunityMember',
            'user_id', // Foreign key on members table...
            'id', // Foreign key on communities table...
            'id', // Local key on users table...
            'community_id' // Local key on community_members table...
        );
        //return $this->hasManyThrough('App\Community', 'App\CommunityMember');
    }

}
