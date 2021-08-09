<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitePartner extends Model
{
    protected $fillable = [
        'user_id',
        'partner_id',
        'status',
        'date_invitation',
        'accept_invitation'
    ];
}
