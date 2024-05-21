<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo "Delakilo - ".$templateParams['title']; ?></title>
        <base href="<?php echo DIR_BASE; ?>">
        <link rel="icon" type="image/x-icon" href="<?php echo ICON_LOGO; ?>">
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php
            if (isset($templateParams['css'])) {
                foreach ($templateParams['css'] as $key => $value) {
                    ?>
                    <link href="./styles/<?php echo $value ?>" rel="stylesheet" type="text/css"/>
                    <?php
                }
            }
        ?>
        <?php
            if (isset($templateParams['js'])) {
                foreach ($templateParams['js'] as $key => $value) {
                    ?>
                    <script type="text/javascript" src="<?php echo $value ?>"></script>
                    <?php
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
