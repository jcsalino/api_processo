<?php

class TransactionApiCest
{
    public string $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI0ZjFnMjNhMTJhYSIsImlhdCI6IjE2MTUyMzM5MDguNDI5ODcyIiwibmJmIjoiMTYxNTIzMzkwOC40Mjk4NzIiLCJleHAiOiIxNjE1MzIwMzA4LjQyOTg3MiIsInRva2VuIjoiMTFmN2M2YmRhNWNhZDM1ZjkwMDFiOGEyMThlODJjZTEifQ.DFg3e4pW-bynay3i5VhNTAaU65kuFCfiKCOGF4awu6s";
    public function create(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->token);
        $I->sendPost('/transaction',[
            'value' => 1.0,
            'payer' => 2,
            'payee' => 1
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'name' => 'string',
            'message' => 'string',
            'status' => 'integer'
        ]);
    }
    public function list(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->token);
        $I->sendGet('/transaction');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'transactions'=> 'array'
        ]);
    }
    public function view(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->token);
        $I->sendGet('/transaction/2');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id'=> 'integer',
            'value'=> 'string|integer',
            'payer'=> 'integer',
            'payee'=> 'integer',
            'status'=> 'integer',
            'created_at'=> 'integer',
            'updated_at'=> 'integer'
        ]);
    }
    public function viewNotYourId(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($this->token);
        $I->sendGet('/transaction/3');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id'=> 'integer',
            'payer'=> 'integer',
            'payee'=> 'integer',
            'status'=> 'integer',
            'created_at'=> 'integer',
            'updated_at'=> 'integer'
        ]);
    }
}
