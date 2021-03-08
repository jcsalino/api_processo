<?php

namespace tests\unit\models;

use Yii;
use app\modules\nodbt\models\Wallet;
use yii\web\BadRequestHttpException;

class WalletTest extends \Codeception\Test\Unit
{
    public function testWithdraw()
    {
        expect_that($wallet = Wallet::findOne(2));
        $wallet->balance = 100.00;
        $wallet->save();
        $wallet->withdraw(10);
        expect($wallet->balance)->equals(90.00);
        $wallet->balance = 100.00;
        $wallet->save();
        expect_that($wallet = Wallet::findOne(1));
        $this->expectExceptionObject(new BadRequestHttpException("The payer's balance is not sufficient for this transaction"));
        $wallet->withdraw(1);

    }
    
    public function testDeposit()
    {
        expect_that($wallet = Wallet::findOne(1));
        $wallet->balance = 0.00;
        $wallet->save();
        $wallet->deposit(10);
        expect($wallet->balance)->equals(10.00);

    }
    public function testRevertWithdraw()
    {
        expect_that($wallet = Wallet::findOne(2));
        $wallet->balance = 100.00;
        $wallet->save();
        $wallet->withdraw(10);
        $wallet->revertWithdraw(10);
        expect($wallet->balance)->equals(100.00);

    }
   
    public function testRevertDeposit()
    {
        expect_that($wallet = Wallet::findOne(1));
        $wallet->balance = 0.00;
        $wallet->save();
        $wallet->deposit(10);
        $wallet->revertDeposit(10);
        expect($wallet->balance)->equals(00.00);

    }
    

}
