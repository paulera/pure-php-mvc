<?php

class Components {
    
    public static function code($code, $language) {
        echo '<pre><code class="language-'.$language.' line-numbers">';
        echo trim($code);
        echo '</code></pre>';
    }
    
    public static function disqus($url, $uuid) {
        ?>
        
<div id="disqus_thread"></div>
<script>

//--------------------
//TODO: manage environments to turn this on only in development
var disqus_developer = 1;
//--------------------

var disqus_config = function () {
	this.page.url = '<?php echo "http://localhost:9091".$url; ?>';
	this.page.identifier = '<?php echo $uuid; ?>';
};

(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://EXAMPLE.disqus.com/embed.min.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

<?php
    }
}