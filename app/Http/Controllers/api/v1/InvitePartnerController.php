<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvitePartnerResource;
use App\Http\Resources\MePartnerResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitePartnerController extends Controller
{
    public function index()
    {
        $partner = [];
        $user = Auth::user();
        $partner['my_partner'] = InvitePartnerResource::collection($user->my_partners);
        $partner['me_partner'] = MePartnerResource::collection($user->me_partners);
        return $this->success('Partner list', $partner);
    }
}
