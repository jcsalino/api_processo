<?php

class UserApiCest
{
    public function list(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/noauth/login', [
          'password' => 'teste', 
          'email' => 'user2@apiprocesso.teste'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $token = $I->grabDataFromResponseByJsonPath('$.data.token');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($token[0]);
        $I->sendGet('/user');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'users'=> 'array'
        ]);
    }
    public function view(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/noauth/login', [
          'password' => 'teste', 
          'email' => 'user2@apiprocesso.teste'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $token = $I->grabDataFromResponseByJsonPath('$.data.token');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($token[0]);
        $I->sendGet('/user/2');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id'=> 'integer',
            'full_name'=> 'string',
            'cpf_cnpj'=> 'string',
            'email'=> 'string:email',
            'type'=> 'integer',
            'typeString'=>  'string',
            'wallet'=> [
                'id'=> 'integer',
                'user_id'=> 'integer',
                'balance'=> 'integer|string',
                'created_at'=> 'integer',
                'updated_at'=> 'integer'
            ],
            'created_at'=> 'integer',
            'updated_at'=> 'integer'
        ]);
    }
    public function viewNotYourId(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/noauth/login', [
          'password' => 'teste', 
          'email' => 'user2@apiprocesso.teste'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $token = $I->grabDataFromResponseByJsonPath('$.data.token');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($token[0]);
        $I->sendGet('/user/1');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id'=> 'integer',
            'full_name'=> 'string',
            'cpf_cnpj'=> 'string',
            'email'=> 'string:email',
            'type'=> 'integer',
            'typeString'=>  'string',
            'created_at'=> 'integer',
            'updated_at'=> 'integer'
        ]);
    }
}
