<?php echo $hello; ?>
<?php if(Request::seg(0) != 'example') echo '<br /><a href="'.baseurl('example','route').'">Example Route</a>'; ?>