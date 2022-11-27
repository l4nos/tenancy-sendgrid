<?php

namespace Lanos\SendgridTenancy\Concerns;

use Lanos\SendgridTenancy\Models\EmailSender;

/**
 * @property-read EmailSender|\Illuminate\Database\Eloquent\Model $emailSenders
 */
trait SendsEmail
{

    public function email_senders(){
        return $this->hasOne(EmailSender::class);
    }

    public function createEmailSender($data): EmailSender
    {
        $class = config('tenancy.email_model');

        if (! is_array($data)) {
            $data = ['domain' => $data];
        }

        $sender = (new $class)->fill($data);
        $sender->tenant()->associate($this);
        $sender->save();

        return $sender;
    }
}
