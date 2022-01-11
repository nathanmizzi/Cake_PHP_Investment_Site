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

        <div class='row mt-3'>
            <p class='m-0'>Shares</p>
            <?= $this->Form->control("shares", ['placeholder' => "Eg. 2", 'label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Bought At</p>
            <?= $this->Form->control("boughtAt", ['placeholder' => "Bought At", 'label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Notes</p>
            <?= $this->Form->control("notes", ['placeholder' => "Not Required", 'label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Image</p>
            <?= $this->Form->control("imagePath", ['type' => 'file','label' => false, 'class' =>"form-control"]); ?>
        </div>

        <div class='row mt-3'>
            <p class='m-0'>Privacy</p>
            <?= $this->Form->control("privacy",["options" => ["Public","Private"],'label' => false, 'class' => "form-control"]); ?>
        </div>

        <div class="row text-center mt-3">
             <?= $this->Form->submit("Save", ['class' => 'btn btn-warning mt-3']); ?>
        </div>

    </div>

    <?= $this->Form->end();?>

    <?php

    $viewTrades = $this->Url->build("/investments/index");
    echo '<button href="'.$viewTrades.'" onclick="showInvestments()" class="btn btn-primary">View Trades</button>';

    ?>

    <script>
        var show = false;

        function showInvestments(){
            show = !show;

            var invCards = document.getElementById('invCards');

            if(show){
                invCards.classList.remove("d-none");
            }else{
                invCards.classList.add("d-none");
            }

        }
    </script>

    <div class="d-none" id="invCards">

        <h2 class="text-center">Your Trades</h2>

        <hr>

        <?php

            echo '<div class="row row-cols-1 row-cols-md-4 g-4 mt-3">';

            foreach($allInvestments as $investment){

                $totalSpent = $investment->shares * $investment->boughtAt;

                    echo '<div class="col">';
                        echo '<div class="card" style="width: 18rem;">';
                            echo '<img class="card-img-top" height="200" src="'.$investment->imagePath.'" alt="Image Not Found">';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title text-center">'.$investment->ticker->ticker_name.'</h5>';
                                echo '<p class="card-text">Shares: '.$investment->shares.' at $'.$investment->boughtAt.'</p>';
                                echo '<p class="card-text">Total Spent: $'.$totalSpent.'</p>';
                                echo '<hr>';

                                if($investment->notes != null){
                                    echo '<p class="card-text">Notes: '.$investment->notes.'</p>';
                                }else{
                                    echo '<p class="card-text">Notes: No Notes Available</p>';
                                }

                                $date = $investment->created;
                                $dateParsed = date('dS F Y H:i', strtotime($date));

                                echo '<p class="card-text bg bg-gray">Added On: '.$dateParsed.'</p>';

                                if($loggedInUser->role_id == 1){
                                    $getInvestmentsLink = $this->Url->build("/investments/get_user_investments/".$investment->user->id);
                                    echo '<a href="'.$getInvestmentsLink.'" class="btn btn-danger"><p class="card-text bg bg-gray">Trade Owner: '.$investment->user->firstName.' '.$investment->user->lastName.'</p></a>';
                                }else{
                                    echo '<p class="card-text bg bg-gray">Trade Owner: '.$investment->user->firstName.' '.$investment->user->lastName.'</p>';
                                }

                                if($loggedInUser->id == $investment->user_id){

                                    echo '<hr>';

                                    $deleteLink = $this->Url->build("/investments/delete/".$investment->id);
                                    echo '<a href="'.$deleteLink.'" class="btn btn-danger">Delete</a>';

                                    $editLink = $this->Url->build("/investments/edit/".$investment->id);
                                    echo '<a href="'.$editLink.'" class="btn btn-warning ms-2">Edit</a>';

                                    echo '<hr>';

                                    echo '<h4>Share With User\'s</h4>';

                                    ?>

                                    <?= $this->Form->create(null, ['url' => '/investments/share/'.$investment->id]);?>
                                    <?= $this->Form->control('user_id', ['options' => $allUsers, 'label' => false ,'class' => 'form-control']);?>
                                    <?=$this->Form->submit("Share", ['class' => "btn btn-primary mt-2"]);?>
                                    <?=$this->Form->end();?>

                                    <?php
                                }

                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

            }

            echo '</div>';
        ?>

    </div>

    

    <?php

}else{
    echo "Failed to generate tickers!";
}

?>