<?php foreach($webroots as $key => $value) { ?>
    <?php if($key === 'css') { ?>
        <link rel="stylesheet" href="<?=$value?>">
    <?php } else if($key === 'js') { ?>
        <script defer src="<?=$value?>"></script>
    <?php } ?>
<?php } ?>

