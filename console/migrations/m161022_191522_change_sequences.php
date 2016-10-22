<?php

use yii\db\Migration;

class m161022_191522_change_sequences extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        // user
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%user}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE user_id_seq RESTART WITH '.$maxVal)->execute();

        // user_profile user_profile_user_id_seq
        Yii::$app->db->createCommand('ALTER SEQUENCE user_profile_user_id_seq RESTART WITH '.$maxVal)->execute();

        // post
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%post}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE post_id_seq RESTART WITH '.$maxVal)->execute();

        // comment
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%comment}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE comment_id_seq RESTART WITH '.$maxVal)->execute();

        // advert
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%advert}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE advert_id_seq RESTART WITH '.$maxVal)->execute();

        // auth
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%auth}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE auth_id_seq RESTART WITH '.$maxVal)->execute();

        // category category_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%category}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE category_id_seq RESTART WITH '.$maxVal)->execute();

        // favorite_posts favorite_posts_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%favorite_posts}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE favorite_posts_id_seq RESTART WITH '.$maxVal)->execute();

        // files files_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%files}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE files_id_seq RESTART WITH '.$maxVal)->execute();

        // images images_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%images}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE images_id_seq RESTART WITH '.$maxVal)->execute();

        // moon_cal moon_cal_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%moon_cal}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE moon_cal_id_seq RESTART WITH '.$maxVal)->execute();

        // moon_dni moon_dni_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%moon_dni}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE moon_dni_id_seq RESTART WITH '.$maxVal)->execute();

        // moon_fazy moon_fazy_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%moon_fazy}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE moon_fazy_id_seq RESTART WITH '.$maxVal)->execute();

        // moon_znaki moon_znaki_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%moon_znaki}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE moon_znaki_id_seq RESTART WITH '.$maxVal)->execute();

        // posts_rating posts_rating_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%posts_rating}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE posts_rating_id_seq RESTART WITH '.$maxVal)->execute();

        // usergroups usergroups_id_seq
        $result = Yii::$app->db->createCommand('SELECT MAX(id) as max_id FROM {{%usergroups}}')->queryAll();
        $maxVal = $result[0]['max_id'] + 1;
        Yii::$app->db->createCommand('ALTER SEQUENCE usergroups_id_seq RESTART WITH '.$maxVal)->execute();

    }

    public function safeDown()
    {

    }
}
