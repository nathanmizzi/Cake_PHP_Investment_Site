<h1 class="text-center mt-4">Users</h1>

    <?php

        if(count($allUsers) > 0){
            
            //pr($allUsers);
            //die;

            echo '<div class="container mt-4">';

                echo '<div class="row row-cols-1 row-cols-md-4 g-4">';

                    foreach ($allUsers as $user) {
                        echo '<div class="col">';
                            echo '<div class="card" style="width: 18rem;">';
                                echo'<img class="card-img-top" src="../webroot/img/profile.png" alt="Error Loading Image">';
                                echo '<div class="card-body">';

                                    if($loggedInUser->role_id == 1){
                                        $getInvestmentsLink = $this->Url->build("/investments/get_user_investments/".$user->id);
                                        echo '<a href="'.$getInvestmentsLink.'" class="btn btn-danger"><h5 class="card-title text-center">'.$user->firstName." ".$user->lastName.'</h5></a>';
                                    }else{
                                        echo'<h5 class="card-title text-center">'.$user->firstName." ".$user->lastName.'</h5>';
                                    }

                                    echo '<hr>';
                                    echo '<p class="card-text">Email: '.$user->email.'</p>';

                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }

                echo '</div>';

            echo '<div>';
           
        }else{
            echo "No users available";
        }

    ?>



