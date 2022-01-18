<h1 class="text-center mt-4">Add User</h1>


<?= $this->Form->create(); ?>

<div class='row'>

    <div class='row'>
        <p class='m-0'>First Name</p>
        <?= $this->Form->control('firstName', ['placeholder' => "Your Name", 'label' => false, 'class' =>"form-control"]); ?>
    </div>

    <div class='row mt-3'>
        <p class='m-0'>Last Name</p>
        <?= $this->Form->control("lastName", ['placeholder' => "Your Surname", 'label' => false, 'class' =>"form-control"]); ?>
    </div>

    <div class='row mt-3'>
        <p class='m-0'>Email</p>
        <?= $this->Form->control('email', ['placeholder' => "Your Email",'label' => false, 'class' =>"form-control"]); ?>
    </div>

    <div class='row mt-3'>
        <p class='m-0'>Password</p>
        <?= $this->Form->control("password", ['placeholder' => "Your Password",'label' => false, 'class' =>"form-control"]); ?>
    </div>

    <div class="row text-center mt-3">
            <?= $this->Form->submit(__('Add'), ['class' =>"btn btn-primary"]); ?>
    </div>

</div>

<?= $this->Form->end(); ?>

