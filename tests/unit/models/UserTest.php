<?php
namespace tests\models;
use app\models\BasicUser;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = BasicUser::findIdentity(100));
        expect($user->username)->equals('admin');

        expect_not(BasicUser::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = BasicUser::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(BasicUser::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = BasicUser::findByUsername('admin'));
        expect_not(BasicUser::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = BasicUser::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    }

}
