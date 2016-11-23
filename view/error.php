<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo htmlentities($title) ?></title>
        <link rel="stylesheet" href="">
    </head>
    <body>
        <h1><?php echo htmlentities($title) ?></h1>
        <p>
            <?php echo htmlentities($message) ?>
        </p>
        <?php include 'partials/scripts.php' ?>
    </body>
</html>
