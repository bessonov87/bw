<?php
namespace app\components;


class GlobalHelper
{
    public static function avatarSrc($user){
        $avatar = $user['profile']['avatar'];
        if(is_null($avatar)){
            $avatarPath = '/bw15/images/';
            $avatar = ($user['profile']['sex'] == 'm') ? 'noavatar_male.png' : 'noavatar_female.png';
        } else {
            $avatarPath = '/uploads/fotos/';
        }
        return $avatarPath.$avatar;
    }
}