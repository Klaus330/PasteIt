<?php
$this->setTitle("Contact");
?>
<div class="row">
    <div class="row mt-3">
        <?php $form = \app\forms\Form::begin('/contact', "POST", "register-form simple-form") ?>
            <?php echo $form->inputField($model, 'fromUsername') ?>
            <?php echo $form->inputField($model, 'fromEmail') ?>
            <?php echo $form->inputField($model, 'toUsername') ?>
            <?php echo $form->inputField($model, 'toPaste') ?>
            <?php echo $form->textarea($model, 'message', 'contact-message')?>
            <?php echo $form->submitButton('Send', 'form-group login-buttons', 'btn btn-succes') ?>
        <?php \app\forms\Form::end() ?>
    </div>
</div>
