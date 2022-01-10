<h1 class="text-center mt-4">Users</h1>

<div class="container col-10">

    <?php

        if(count($allUsers) > 0){
            
            //pr($allUsers);
            //die;

            echo "<table class='table'>";
            echo '<tr>';
                echo "<th>ID #</th>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Role</th>";
                echo "<th>Delete</th>";
                echo "<th>Edit</th>";
            echo "</tr>";

            foreach($allUsers as $user){
                echo "<tr>";
                    echo "<td>".$user->id."</td>";
                    echo "<td>".$user->firstName."</td>";
                    echo "<td>".$user->lastName."</td>";
                    echo "<td>".$user->role->role_name."</td>";
                    echo '<td><a href="#" class="btn btn-danger">Delete</a></td>';
                    echo '<td><a href="#" class="btn btn-warning">Edit</a></td>';

                echo "</tr>";
            }

            echo "</table>";
        }else{
            echo "No users available";
        }

    ?>

<div>