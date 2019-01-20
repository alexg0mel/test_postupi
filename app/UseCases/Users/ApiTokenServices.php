<?php
/**
 * Created by PhpStorm.
 * User: alexgomel
 * Date: 4.10.18
 * Time: 19.53
 */

namespace App\UseCases\Users;

use App\Entity\User;
use Illuminate\Support\Facades\DB;

class ApiTokenServices
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function GenerateNewToken()
    {
        /** @var User $user */
        $user = $this->user;
        $user->api_token = str_random(128);
        $timestamps = $user->timestamps;
        $user->timestamps = false;
        $user->save();
        $user->timestamps=$timestamps;
    }

    public function findViaToken(string $token)
    {
        return DB::table('users')->where(['api_token'=>$token])->first();
    }

    public function getToken()
    {
        return $this->user->api_token;
    }

}