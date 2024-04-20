<!-- Enrico Marchionni -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo "Delakilo - ".$templateParams['title']; ?></title>
        <?php
            if (!isset($templateParams['css']) || empty($templateParams['css'])) {
                $GLOBALS['log']->logWarning($templateParams['page'].' has no style sheet');
            } else {
                foreach ($templateParams['css'] as $key => $value) {
                    echo '<link href="./styles/'.$value.'" rel="stylesheet" type="text/css"/>'.PHP_EOL;
                }
            }
        ?>
        <link rel="icon" type="image/x-icon" href="<?php echo LOGO; ?>">
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <?php
            if (isset($templateParams['page'])) {
                require($templateParams['page']);
            } else {
                die('Unspecified .php page in body');
            }
        ?>
    </body>
</html>
