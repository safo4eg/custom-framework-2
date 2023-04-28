<?php foreach($webroots as $key => $value) { ?>
    <?php if($key === 'css') { ?>
        <link rel="stylesheet" href="<?=$value?>">
    <?php } else if($key === 'js') { ?>
        <?php foreach($value as $path) { ?>
            <script defer src="<?=$path?>"></script>
        <?php } ?>
    <?php } ?>
<?php } ?>

