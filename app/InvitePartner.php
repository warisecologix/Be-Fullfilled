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

    public function my_partner()
    {
        return $this->belongsTo(User::class, 'partner_id', 'id');
    }

    public function me_partner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
