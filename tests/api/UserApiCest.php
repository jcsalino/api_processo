<?php

class UserApiCest
{
    public string $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI0ZjFnMjNhMTJhYSIsImlhdCI6IjE2MTUyMzM5MDguNDI5ODcyIiwibmJmIjoiMTYxNTIzMzkwOC40Mjk4NzIiLCJleHAiOiIxNjE1MzIwMzA4LjQyOTg3MiIsInRva2VuIjoiMTFmN2M2YmRhNWNhZDM1ZjkwMDFiOGEyMThlODJjZTEifQ.DFg3e4pW-bynay3i5VhNTAaU65kuFCfiKCOGF4awu6s";
    public function list(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->token);
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
        $I->amBearerAuthenticated($this->token);
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
        $I->amBearerAuthenticated($this->token);
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
