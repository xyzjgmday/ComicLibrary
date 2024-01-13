<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;

class LastLoginEvent
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
