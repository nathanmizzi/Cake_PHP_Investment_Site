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

$logInWithFbLink = $this->Url->build("/users/loginWithFb");
echo '<a class="btn btn-danger" href="#" onclick="sendAjax()">Log-In With Google</a>';

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">

    function sendAjax(){
        url = "http://localhost:900/Nathan_Mizzi_IT-SWD-6.2A-SSS-Home/users/loginWithFb";
        dataToSend = {firstname: "test", lastname: "test", email:"email@gmail.com"};

        var provider = new firebase.auth.GoogleAuthProvider();

        var xmlHttpRequest = $.post(url, dataToSend, function(data, status) {
            console.log("Data: " + data + "\nStatus: " + status);

            if(data == 1){
            alert("Ok");
        }

        })
        .fail(function(error){
            console.log("Error: " + error);
        });

    }
</script>