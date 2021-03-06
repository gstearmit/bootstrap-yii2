<?php

namespace app\tests\functional\admin;

use app\tests\fixtures\UserFixture;
use app\tests\fixtures\UserProfileFixture;

class UsersCest
{
    protected $url = '/admin/users';

    // @codingStandardsIgnoreFile
    public function _before($I)
    {
        $I->haveFixtures([
             'profile' => UserProfileFixture::class,
             'user' => UserFixture::class,
        ]);
        $I->amLoggedInAs($I->grabFixture('user', 'user-1'));
        $I->amOnRoute($this->url);
    }

    public function testOpenIndexPage($I)
    {
        $I->seeResponseCodeIs(200);
    }

    public function testOpenCreatePage($I)
    {
        $I->amOnRoute($this->url . '/edit');
        $I->seeResponseCodeIs(200);
    }

    public function testOpenEditPage($I)
    {
        $I->amOnRoute($this->url . '/edit', ['id' => 1]);
        $I->seeResponseCodeIs(200);
    }

    public function testOpenEdit404($I)
    {
        $I->amOnRoute($this->url . '/edit', ['id' => 999]);
        $I->seeResponseCodeIs(404);
    }

    public function testOpenProfilePage($I)
    {
        $I->amOnRoute($this->url . '/profile', ['id' => 1]);
        $I->seeResponseCodeIs(200);
    }

    public function testOpenProfile404($I)
    {
        $I->amOnRoute($this->url . '/profile', ['id' => 999]);
        $I->seeResponseCodeIs(404);
    }
}
