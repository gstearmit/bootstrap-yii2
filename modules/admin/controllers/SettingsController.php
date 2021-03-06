<?php

namespace app\modules\admin\controllers;

use Yii;
use app\traits\ModelTrait;
use app\modules\admin\models\forms\SettingsForm;

class SettingsController extends \yii\web\Controller
{
    use ModelTrait;

    public function actionIndex()
    {
        $model = new SettingsForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                Yii::$app->settings->load($model->getAttributes());
                Yii::$app->session->setFlash('success', Yii::t('app.msg', 'Saved successfully'));
                return $this->refresh();
            }
            if (Yii::$app->request->isAjax) {
                return $this->asJson($this->collectErrors($model));
            }
        }

        $model->setAttributes(Yii::$app->settings->all());

        return $this->render('index', ['model' => $model]);
    }
}
