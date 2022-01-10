<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Geek Investments
        </title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body> 
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">Geek Investments</a>
            
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                            <?php
                            if(isset($loggedInUser)){?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $this->Url->build('/Investments/add') ?>">Add Investments</a>
                                </li>
                            <?php } ?>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $this->Url->build('/Investments/index') ?>">View Investments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $this->Url->build('/Users/index') ?>">View Users</a>
                            </li>

                            <?php

                                if(isset($loggedInUser)){

                                  echo '<li class="nav-item"><a class="nav-link" href="'.$this->Url->build("/users/logout").'">Log-out</a></li>';
                                
                                }else{
                                    echo '<li class="nav-item"><a class="nav-link" href="'.$this->Url->build("/users/login").'">Log-in</a></li>';
                                }
                            ?>
                                
                        </ul>
                    </div>
                    
                </div>
            </nav>
            <div class="bg-secondary text-center p-4">
				<h1 class="display-3 text-white"><img src="https://cdn.iconscout.com/icon/free/png-256/geek-2-160919.png" width="200">Geek Investments</h1>
			</div>
            <main class="main mt-3">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </main>

            <footer class="text-center mt-3">
                <hr>
                Copyright &copy; 2022. All Rights Reserved. Nathan Mizzi
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
