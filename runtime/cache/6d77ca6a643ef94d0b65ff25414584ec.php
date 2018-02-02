<?php if($list): ?>
    <?php if(count($list)==1): ?>
    <?php echo $list[0]['name']; ?>
    <?php else: ?>
    <?php echo $list[1]['name']; ?>
    <?php endif; ?>
<?php endif; ?>   
<?php foreach($list as $k=>$r): ?>
<?php echo $r['id']; ?>
<?php endforeach; ?>