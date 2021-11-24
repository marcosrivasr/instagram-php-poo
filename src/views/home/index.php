<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <?php require_once 'src/views/layout/menu.php'; ?>
   

   <div class="container w-25">

   <h2>Home <?php echo $this->d['user']->getUsername(); ?></h2>


   <div id="create">
        <form action="publish" method="POST" enctype="multipart/form-data">
            <input type="text" name="title">
            <input type="file" name="image" accept="image/png, image/jpeg">

            <input type="submit" value="Publicar">
        </form>
   </div>
        <?php
            $user = $this->d['user'];
            $posts = $this->d['posts'];

            foreach($posts as $p){ ?>

                <div class="card mt-2">
                    <div class="card-body">
                    <img class="rounded-circle" src="public/img/photos/<?php echo $p->getUser()->getProfile() ?>" width="32" />
                        <?php echo $p->getUser()->getUsername() ?>
                    </div>
                    <img src="public/img/photos/<?php echo $p->getImage() ?>" width="100%" />
                    <div class="card-body">
                        
                        <div class="card-title">
                            <form action="addLike" method="POST">
                                <input type="hidden" name="post_id" value="<?php echo $p->getId() ?>">
                                <input type="hidden" name="origin" value="home">
                                <button type="submit" class="btn btn-danger"><?php echo $p->getLikes(); ?> Likes</button>
                            </form>
                        </div>
                        <p class="card-text"><?php echo $p->getTitle() ?></p>
                    </div>
                </div>
                
                
        <?php } ?>
    </div>
</body>
</html>