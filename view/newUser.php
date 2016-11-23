<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo htmlentities($title) ?></title>
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/css/styles.css">
    </head>
    <body>
        <?php
        if ( $errors ) {
            echo '<ul class="errors">';
            foreach ( $errors as $field => $error ) {
                echo '<li>'.htmlentities($error).'</li>';
            }
            echo '</ul>';
        }
        ?>

        <div class="Container">

            <form method="POST" action="" class="Form">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" placeholder="Nombre" class="form-control" value="<?php echo htmlentities($contact->name) ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" id="phone" name="phone" placeholder="Teléfono" class="form-control" value="<?php echo htmlentities($contact->phone) ?>">
                </div>

                <div class="form-group">
                    <label for="email">Teléfono</label>
                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="<?php echo htmlentities($contact->email) ?>">
                </div>

                <div class="form-group">
                    <label for="email">DIrección</label>
                    <input type="text" id="address" name="address" placeholder="Dirección" class="form-control" value="<?php echo htmlentities($contact->address) ?>">
                </div>
                <input type="hidden" name="form-submitted" value="1" />
                <button type="submit" class="btn btn-default">Crear</button>
            </form>
        </div>
    <?php include 'partials/scripts.php' ?>
    </body>
</html>
