<h1 class="text-center mt-4">Add an Investment</h1>

<?php

if(isset($tickers)){

     //pr($tickers); 
     //die; 

    ?>

    <?= $this->Form->create(null, ['enctype' => 'multipart/form-data']); ?>

    <div class='row'>

        <div class='row'>
            <p class='m-0'>Ticker</p>
            <?= $this->Form->control('ticker_id', ['options' => $tickers, 'label' => false ,'class' => 'form-control']); ?>
        </div>

        <div class='row'>
            <p class='m-0'>Shares</p>
            <?= $this->Form->control("shares", ['placeholder' => "Eg. 2", 'label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class='row'>
            <p class='m-0'>Bought At</p>
            <?= $this->Form->control("boughtAt", ['placeholder' => "Bought At", 'label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class='row'>
            <p class='m-0'>Notes</p>
            <?= $this->Form->control("notes", ['placeholder' => "Not Required", 'label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class='row'>
            <p class='m-0'>Image</p>
            <?= $this->Form->control("imagePath", ['type' => 'file','label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class="row text-center mt-3">
             <?= $this->Form->submit("Save", ['class' => 'btn btn-warning mt-3']); ?>
        </div>

    </div>



    <?= $this->Form->end(); ?>

    <?php

}else{
    echo "Failed to generate tickers!";
}

?>