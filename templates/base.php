<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo "Delakilo - ".$templateParams['title']; ?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo ICON_LOGO; ?>">
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php
            if (!isset($templateParams['css']) || empty($templateParams['css'])) {
                $GLOBALS['log']->logWarning($templateParams['page'].' has no style sheet');
            } else {
                foreach ($templateParams['css'] as $key => $value) {
                    echo '<link href="./styles/'.$value.'" rel="stylesheet" type="text/css"/>'.PHP_EOL;
                }
            }
        ?>
        <?php
            if (isset($templateParams['js'])) {
                foreach ($templateParams['js'] as $key => $value) {
                    ?><script type="text/javascript" src="<?php echo $value ?>"></script><?php
                }
            }
        ?>
    </head>
    <body>
        <?php
            if (isset($templateParams['page'])) {
                require($templateParams['page']);
            } else {
                die('Unspecified PHP page in body tag');
            }
        ?>
    </body>
</html>
