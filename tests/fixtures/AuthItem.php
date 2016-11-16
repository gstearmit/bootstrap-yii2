<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

/**
 * AuthItem fixture
 */
class AuthItem extends ActiveFixture
{
    public $modelClass = 'app\models\AuthItem';
    public $dataFile = '@tests/_data/models/auth_item.php';
}
