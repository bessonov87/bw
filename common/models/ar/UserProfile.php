<?php

namespace common\models\ar;

use common\models\UserProfile as BaseUserProfile;

class UserProfile extends BaseUserProfile
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'sex' => 'Пол',
            'surname' => 'Surname',
            'birth_date' => 'Birth Date',
            'country' => 'Country',
            'avatar' => 'Avatar',
            'info' => 'Info',
            'signature' => 'Signature',
            'last_visit' => 'Last Visit',
            'last_ip' => 'Last Ip',
        ];
    }
}
