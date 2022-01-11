<?php

echo '<h1 class="text-center">Public Investments: '.count($allInvestments).'</h1>';

echo '<hr>';

//pr($allInvestments);
//die;

echo '<div class="row row-cols-1 row-cols-md-4 g-4">';

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
                        echo '<p class="card-text bg bg-gray">Trade Owner: '.$investment->user->firstName.' '.$investment->user->lastName.'</p>';

                        echo '<hr>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

    }

echo '</div>';

?>