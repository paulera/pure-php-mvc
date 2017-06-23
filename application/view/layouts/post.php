<?php

if (isset($postData->title)) {
    echo '<h1 class="title"><a href="'.$postData->permalink.'">'.$postData->title.'</a></h1>'."\n";    
}

if (isset($postData->date)) { 
    echo '<p class="post-date"><a href="'.$postData->permalink.'">'.$postData->date->format('l, j M Y').'</a></p>'."\n";
}

if (isset($postData->author)) {
    echo '<p class="author">by '.$postData->author.'</p>'."\n";
}

?>
<hr>
<?php echo $contents; ?>
<hr>
<?php echo Components::disqus($postData->permalink, $postData->uuid)?>
