<h1 class="text-center mt-4">Edit an Investment</h1>

<?php

if(isset($tickers) && isset($investmentToEdit)){

     //pr($tickers); 
     //die; 

    ?>

    <?= $this->Form->create(null, ['enctype' => 'multipart/form-data']); ?>

    <div class='row'>

        <div class='row'>
            <p class='m-0'>Ticker</p>
            <?= $this->Form->control('ticker_id', ['options' => $tickers, 'label' => false ,'class' => 'form-control', 'default' => $investmentToEdit->ticker_id]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Shares</p>
            <?= $this->Form->control("shares", ['placeholder' => "Eg. 2", 'label' => false, 'class' =>"form-control", 'default' => $investmentToEdit->shares]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Bought At</p>
            <?= $this->Form->control("boughtAt", ['placeholder' => "Bought At", 'label' => false, 'class' =>"form-control", 'default' => $investmentToEdit->boughtAt]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Notes</p>
            <?= $this->Form->control("notes", ['placeholder' => "Not Required", 'label' => false, 'class' =>"form-control", 'default' => $investmentToEdit->notes]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Image</p>
            <?= $this->Form->control("imagePath", ['type' => 'file','label' => false, 'class' =>"form-control", 'default' => $investmentToEdit->imagePath]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Privacy</p>
            <?= $this->Form->control("privacy",["options" => ["Public","Private"],'label' => false, 'class' => "form-control", 'default' => $investmentToEdit->privacy]); ?>
        </div>

        <div class="row text-center mt-3">
             <?= $this->Form->submit("Save", ['class' => 'btn btn-warning mt-3']); ?>
        </div>

    </div>

    <?= $this->Form->end(); ?>

    <?php

}else{
    pr($investmentToEdit); 
    die; 
} ?>