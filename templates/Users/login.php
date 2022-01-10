<h1 class="text-center mt-4">Log In</h1>

<?= $this->Form->create(); ?>

<div class='row'>

    <div class='row'>
        <p class='m-0'>Email</p>
        <?= $this->Form->control('email', ['placeholder' => "Your Email Here", 'label' => false, 'class' =>"form-control"]); ?>
    </div>

    <div class='row mt-3'>
        <p class='m-0'>Password</p>
        <?= $this->Form->control("password", ['placeholder' => "Your Password Here", 'label' => false, 'class' =>"form-control"]); ?>
    </div>

    <div class="row text-center mt-3">
            <?= $this->Form->submit(__('Login')); ?>
    </div>

</div>

<?= $this->Form->end(); ?>

<?php

?>