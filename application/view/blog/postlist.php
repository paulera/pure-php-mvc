<?php
defined('IS_APP') || die();
?>

<?php if (count($posts) > 0) { // LISTING POSTS ?>

<ul class="posts-list">
    
    <?php
    
    foreach ($posts as $permalink => $post) {
        
        $date = new DateTime();
        $date->setDate($post->year, $post->month, $post->day);
        
        ?>
        	<li>
		<div class="post-date">
        			<?php echo $post->date->format('d<\s\u\p><\u>S</\u></\s\u\p> \o\f '); ?>
        			<a
				href="<?php echo Env::base(); ?>/blog/<?php echo $post->date->format("Y/m/d"); ?>">
        				<?php echo $post->date->format('F, Y'); ?>
        			</a>
		</div>
		<div class="post-title">
			<a href="<?php echo Env::base() . '/' . $permalink; ?>"><?php echo $post->title; ?></a>
		</div>

	</li>
    <?php } ?>
    </ul>
<?php } else { // NO POSTS TO SHOW ?>

<p>No posts to show for the requested date.</p>
<p>
	Maybe try the <a href="<?php echo Env::base(); ?>/blog">blog home</a>?
</p>

<?php } ?>