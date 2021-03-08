<?php

class AuthApiCest
{
    public function login(\ApiTester $I) 
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/noauth/login', [
          'password' => 'teste', 
          'email' => 'user1@apiprocesso.teste'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"status":"success"');
    }
    
}
