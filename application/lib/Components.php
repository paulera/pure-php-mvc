<?php

class Components {
    
    public static function code($code, $language) {
        echo '<pre><code class="language-'.$language.' line-numbers">';
        echo trim($code);
        echo '</code></pre>';
    }
}