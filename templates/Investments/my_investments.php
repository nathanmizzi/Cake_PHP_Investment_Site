<?php

echo '<h1 class="text-center">Your Investments: '.count($allInvestments).'</h1>';

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

                        if($loggedInUser->role_id == 1){
                            $getInvestmentsLink = $this->Url->build("/investments/get_user_investments/".$investment->user->id);
                            echo '<a href="'.$getInvestmentsLink.'" class="btn btn-danger"><p class="card-text bg bg-gray">Trade Owner: '.$investment->user->firstName.' '.$investment->user->lastName.'</p></a>';
                        }else{
                            echo '<p class="card-text bg bg-gray">Trade Owner: '.$investment->user->firstName.' '.$investment->user->lastName.'</p>';
                        }

                        if($loggedInUser->id == $investment->user_id){

                            $likes = 0;

                            foreach($allLikes as $like){
                                if($like->investment_id == $investment->id){
                                    $likes++;
                                }
                            }

                            echo '<hr>';

                            $listLikedUsersLink = $this->Url->build("/investments/listLikedUsers/".$investment->id);

                            if($likes != 0){
                                echo '<p>Investment Likes: <a href="'.$listLikedUsersLink.'">'.$likes.'</a></p>';
                            }else{
                                echo '<p>Investment Likes: '.$likes.'</p>';
                            }

                            echo '<hr>';

                            $deleteLink = $this->Url->build("/investments/delete/".$investment->id);
                            echo '<a href="'.$deleteLink.'" class="btn btn-danger">Delete</a>';

                            $editLink = $this->Url->build("/investments/edit/".$investment->id);
                            echo '<a href="'.$editLink.'" class="btn btn-warning ms-2">Edit</a>';
                        }

                    echo '</div>';
                echo '</div>';
            echo '</div>';

    }

echo '</div>';

?>