<?php
use yii\helpers\Html;
?>
<li>
  <a href="<?= $model->fileUrl('gallery', $file)?>" target="_blank">
    <img src="<?= $model->thumbUrl('gallery', '80x80', $file)?>"></a>
  <a class="btn btn-lg"><span class="glyphicon glyphicon-remove remove-item" data-remove-item="li"></span></a>
  <?= Html::hiddenInput(Html::getInputName($model, $attribute) . '[]', $file->id, [
      'class' => 'form-control',
  ])?>
  <?= Html::activeTextInput($model, $attribute.'Titles[' . $file->id .']', [
    'class' => 'form-control',
    'value' => $file->title
  ]) ?>
</li>
