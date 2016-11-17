<?php

namespace app\models\forms;

use Yii;
use yii\base\DynamicModel;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\User;

class SignupProviderForm extends \yii\base\Model
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var \app\models\User
     */
    private $user = null;

    /**
     * @param User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app.validators', 'This email address has already been taken')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return (new User())->attributeLabels();
    }

    /**
     * Create manually UploadedFile instance by file path
     *
     * @param string $path file path
     * @return UploadedFile
     */
    private function makeUploadedFile($path)
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'app');
        file_put_contents($tmpFile, file_get_contents($path));

        $uploadedFile = new UploadedFile();
        $uploadedFile->name = pathinfo($path, PATHINFO_BASENAME);
        $uploadedFile->tempName = $tmpFile;
        $uploadedFile->type = FileHelper::getMimeType($tmpFile);
        $uploadedFile->size = filesize($tmpFile);
        $uploadedFile->error = 0;

        return $uploadedFile;
    }

    /**
     * Save photo
     *
     * @param \app\models\UserProfile $profile
     * @param string $photo
     * @return void
     */
    private function savePhoto($profile, $photo)
    {
        $file = $this->makeUploadedFile($photo);
        $model = new DynamicModel(compact('file'));
        $model->addRule('file', 'image', $profile->fileRules('photo', true))->validate();
        if (!$model->hasErrors()) {
            $profile->createFile('photo', $file->tempName, $model->file->name);
        }
    }

    /**
     * Signs user up
     *
     * @param bool $checkExistEmail
     * @return \app\models\User
     */
    public function signup($checkExistEmail = true)
    {
        if ($this->validate($checkExistEmail ? null : [])) {
            $this->user->email = $this->email;

            $profile = $this->user->profile;
            if ($profile->isNewRecord && !empty($profile->photo)) {
                $this->savePhoto($profile, $profile->photo);
            }

            if ($this->user->save()) {
                if ($this->user->authorize(true)) {
                    return $this->user;
                }
            } // @codeCoverageIgnore
        } // @codeCoverageIgnore

        return false;
    }

    /**
     * Sends an email with a link, for confirm the email
     *
     * @return boolean
     */
    public function sendEmail()
    {
        if (!User::isTokenValid($this->user->email_confirm_token)) {
            $this->user->generateEmailConfirmToken();
            $this->user->updateAttributes([
                'email_confirm_token' => $this->user->email_confirm_token,
                'date_confirm' => $this->user->date_confirm,
            ]);
        }

        return Yii::$app->notify->sendMessage(
            $this->email,
            Yii::t('app', 'Activate Your Account'),
            'emailConfirmToken',
            ['user' => $this->user]
        );
    }
}
