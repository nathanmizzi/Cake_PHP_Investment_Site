<?php

echo '<h1 class="text-center">Your investments: '.count($allInvestments).'</h1>';

echo '<hr>';

//pr($allInvestments);
//die;

$totalPortfolio = 0;

echo '<div class="row row-cols-1 row-cols-md-4 g-4">';

    foreach($allInvestments as $investment){

        $totalSpent = $investment->shares * $investment->boughtAt;
        $totalPortfolio += $totalSpent;

            echo '<div class="col">';
                echo '<div class="card" style="width: 18rem;">';
                    echo '<img class="card-img-top" src="'.$investment->imagePath.'" alt="Image Not Found">';
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

                        echo '<p class="card-text bg bg-gray">Added On: '.$investment->created.'</p>';
                        echo '<hr>';
                        $deleteLink = $this->Url->build("/investments/delete/".$investment->id);
                        echo '<a href="'.$deleteLink.'" class="btn btn-danger">Delete</a>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

    }

echo '</div>';

echo "<div class='alert alert-info mt-4'>Total portfolio: $".$totalPortfolio."</div>";

?>