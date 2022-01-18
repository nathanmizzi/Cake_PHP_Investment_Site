<h1 class="text-center mt-4">Log In</h1>

<?= $this->Form->create(); ?>

<div class='row'>

    <div class='row'>
        <p class='m-0'>Email</p>
        <?= $this->Form->control('email', ['placeholder' => "Your Email Here", 'label' => false, 'class' =>"form-control", 'id' => 'emailField']); ?>
    </div>

    <div class='row mt-3'>
        <p class='m-0'>Password</p>
        <?= $this->Form->control("password", ['placeholder' => "Your Password Here", 'label' => false, 'class' =>"form-control", 'id' => 'passwordField']); ?>
    </div>

    <div class="row text-center mt-3">
            <?= $this->Form->submit(__('Login'), ['id' => 'submitBtn']); ?>
    </div>

</div>

<?= $this->Form->end(); ?>


<?php

$logInWithFbLink = $this->Url->build("/users/loginWithFb");
echo '<a class="btn btn-danger" onclick="sendAjax()">Log-In With Google</a>';

?>

<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-auth.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="..\webroot\js\googleAuth.js"></script>

<script type="text/javascript">

    function sendAjax(){

        googlePopup(function() {
            url = "http://localhost:900/Nathan_Mizzi_IT-SWD-6.2A-SSS-Home/users/loginWithGoogle";
            dataToSend = {firstname: nameFromGoogle, lastname: "Account", email: emailFromGoogle, roleId: 2, password: passwordFromGoogle};

            var xmlHttpRequest = $.post(url, dataToSend, function(data, status) {

                $('#emailField').val(dataToSend.email);
                $('#passwordField').val(dataToSend.password);
                $('#submitBtn').click();

            })
            .fail(function(error){
                console.log("Error: " + error);
            });
        });

    }
</script>
