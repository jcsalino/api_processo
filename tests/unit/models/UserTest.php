<?php

namespace tests\unit\models;

use Yii;
use app\modules\security\models\User;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->email)->equals('user1@apiprocesso.teste');

        expect_not(User::findIdentity(999));
    }
    public function testFindUserByEmail()
    {
        expect_that($user = User::findByEmail('user1@apiprocesso.teste'));
        expect_not(User::findByEmail('not-admin'));
    }

    public function testFindUserByAccessToken()
    {
        Yii::$app->jwt->getConfiguration()
        ->setValidationConstraints(
            new LooseValidAt(SystemClock::fromSystemTimezone()),
            new SignedWith(
                Yii::$app->jwt->getConfiguration()->signer(),
                Yii::$app->jwt->getConfiguration()->signingKey()
            ),
        );
        $user1 = User::findIdentity(1);
        $token = $user1->generateToken(); 
        expect_that($user = User::findIdentityByAccessToken($token));
        expect($user->email)->equals('user1@apiprocesso.teste');

        expect_not(User::findIdentityByAccessToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI0ZjFnMjNhMTJhYSIsImlhdCI6IjE2MTUxNzc4MTAuNzM5NDUzIiwibmJmIjoiMTYxNTE3NzgxMC43Mzk0NTMiLCJleHAiOiIxNjE1MjY0MjEwLjczOTQ1MyIsInRva2VuIjoiZjBkZTU3MmZjNDkxMTQwMTUzNjM2ZDA0NDk2YjlmYmYifQ.pQiSWVdFltfeOt8NrynTd_9Hiclp8H-Fgck7SpdcjZk'));        
    }

}
