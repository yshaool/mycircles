<?php

namespace App\Mail;

use App\Community;
use App\CommunityMember;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $community;
    public $communityMember;
    public $communityOwner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Community $community, CommunityMember $communityMember,User $communityOwner)
    {
        $this->community=$community;
        $this->communityMember=$communityMember;
        $this->communityOwner=$communityOwner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.memberinvite')->text('emails.text.memberinvite')->subject('Invitation to join community - '.$this->community->name);
    }
}
