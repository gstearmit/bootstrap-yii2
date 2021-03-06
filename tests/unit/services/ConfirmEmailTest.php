<?php

namespace app\tests\unit\services;

use app\tests\fixtures\UserFixture;
use app\models\User;
use app\services\ConfirmEmail;

class ConfirmEmailTest extends \Codeception\Test\Unit
{
    // @codingStandardsIgnoreFile
    protected function _before()
    {
        $this->tester->haveFixtures([
             'user' => UserFixture::class,
        ]);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid token for activate account
     */
    public function testWrongToken()
    {
        $form = new ConfirmEmail();
        expect_not($form->setConfirmed('notexistingtoken_1391882543'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid token for activate account
     */
    public function testEmptyToken()
    {
        $form = new ConfirmEmail();
        expect_not($form->setConfirmed(''));
    }

    public function testSuccess()
    {
        $user = User::find()->email('superuser@example.com')->one();
        expect_not($user->isConfirmed());

        $form = new ConfirmEmail();
        $form->setConfirmed($user->email_confirm_token);

        $user = User::find()->email($user->email)->one();
        expect($user->email_confirm_token)->isEmpty();
        expect_that($user->isConfirmed());
    }
}
