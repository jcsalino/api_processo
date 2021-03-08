<?php

class TransactionApiCest
{
    public function create(ApiTester $I)
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
        $I->sendPost('/noauth/login', [
          'password' => 'teste', 
          'email' => 'user2@apiprocesso.teste'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $token = $I->grabDataFromResponseByJsonPath('$.data.token');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($token[0]);

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
        $I->sendPost('/noauth/login', [
          'password' => 'teste', 
          'email' => 'user2@apiprocesso.teste'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $token = $I->grabDataFromResponseByJsonPath('$.data.token');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($token[0]);
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
        $I->sendPost('/noauth/login', [
          'password' => 'teste', 
          'email' => 'user2@apiprocesso.teste'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $token = $I->grabDataFromResponseByJsonPath('$.data.token');

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->amBearerAuthenticated($token[0]);
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
