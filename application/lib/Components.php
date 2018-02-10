<?php

class Components
{

    public static function code($code, $language)
    {
        echo '<pre><code class="language-' . $language . ' line-numbers">';
        echo trim($code);
        echo '</code></pre>';
    }

    public static function disqus($context)
    {        
        ?>
        
            <div id="disqus_thread"></div>
            <script>
            
            var disqus_url = '<?php echo Request::pageUrlForSeo(); ?>';
            
            (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://paulodevtest.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
            })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        
        <?php
    }
}