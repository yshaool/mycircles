<?php

namespace App\Mail;

use App\Community;
use App\CommunityMember;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MemberInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $community;
    public $communityMember;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Community $community, CommunityMember $communityMember)
    {
        $this->community=$community;
        $this->communityMember=$communityMember;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.memberinvite')->text('emails.text.memberinvite');;
    }
}
