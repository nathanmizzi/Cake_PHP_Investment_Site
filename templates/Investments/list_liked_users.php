<h1 class="text-center mt-4">Liked By:</h1>

    <?php

        if(count($likedBy) > 0){
            
            //pr($allUsers);
            //die;

            echo '<div class="container mt-4 text-center">';

                echo '<div class="row row-cols-1 row-cols-md-4 g-4">';

                    foreach ($likedBy as $userThatLiked) {
                        echo '<div class="col">';
                            echo '<div class="card text-center" style="width: 18rem;">';
                                echo '<div class="card-top">';

                                    if($loggedInUser->role_id == 1){
                                        $getInvestmentsLink = $this->Url->build("/investments/get_user_investments/".$userThatLiked->user->id);
                                        echo '<a href="'.$getInvestmentsLink.'" class="btn btn-danger mt-4"><h5 class="card-title text-center">'.$userThatLiked->user->firstName." ".$userThatLiked->user->lastName.'</h5></a>';
                                    }else{
                                        echo'<h5 class="card-title mt-4">'.$userThatLiked->user->firstName." ".$userThatLiked->user->lastName.'</h5>';
                                    }

                                echo '</div>';

                                echo '<div class="card-body">';



                                    echo '<hr>';
                                    echo '<p class="card-text">Email: '.$userThatLiked->user->email.'</p>';

                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }

                echo '</div>';

                $homepageLink = $this->Url->build("/investments/homepage");
                echo '<a class="btn btn-primary mt-5" href="'.$homepageLink.'">Back To Homepage</a>';

            echo '<div>';
           
        }else{
            echo "No users liked this post";
        }

    ?>



