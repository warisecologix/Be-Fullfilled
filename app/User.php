<?php

namespace App;

use App\Http\Traits\Generic;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Generic;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'phone_number',
        'city',
        'zipcode',
        'street_address',
        'social_account_id',
        'social_account_type',
        'social_account_profile_image_url',
        'social_account_email',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function notes()
    {
        return $this->hasMany(Notes::class);
    }

    public function weeklyGoals()
    {
        return $this->hasMany(WeeklyGoal::class);
    }

    public function yourDays()
    {
        return $this->hasMany(YourDay::class);
    }

    function url_exists($url)
    {
        $headers = get_headers($url);
        if (stripos($headers[0], "200 OK")) {
            return true;
        } else {
            return false;
        }
    }

    public function getProfileAttribute($profile)
    {
        if ($this->social_account_profile_image_url != null) {
            return $this->social_account_profile_image_url;
        }
        $url = url('storage/' . $profile);
        $exists = $this->url_exists($url);
        if ($exists) {
            return $url;
        } else {
            return asset("thumbnail/avatar.png");
        }
    }

    public function getCustomizeDatesAttribute()
    {
        return $this->getCustomizeDate($this->created_at);
    }

    public function getDateAttribute($val)
    {
        return $this->getCustomizeDate($this->created_at);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shopping_carts()
    {
        return $this->hasMany(ShoppingCart::class);
    }

    public function daily_check_questions()
    {
        return $this->hasMany(DailyCheckQuestion::class);
    }

    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function my_partners(){
        return $this->hasMany(InvitePartner::class);
    }

    public function me_partners(){
        return $this->hasMany(InvitePartner::class, 'partner_id');
    }
}
