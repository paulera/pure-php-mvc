<?php
defined('IS_APP') || die();

class Components
{

    public static function code($code, $language)
    {
        return '<pre><code class="language-' . $language . ' line-numbers">' . trim($code) . '</code></pre>';
    }

    public static function disqus($context)
    {
        $disqus_url = Request::pageUrlForSeo();
        return "
<div id='disqus_thread'></div>
<script>
    var disqus_url = '{$disqus_url}; ?>';
    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://paulodevtest.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>
	Enable JavaScript to view comments.
</noscript>";
    }
}