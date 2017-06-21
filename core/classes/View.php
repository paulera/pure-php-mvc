<?php

class View {
    
    public static function render($viewRelativePath, $variables = null) {
        ob_start();
        if (isset($variables) and is_array($variables)) {
            extract($variables);
        }
        include DIR_VIEW.DS.(str_replace("..", "", $viewRelativePath));
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    
    public static function renderWithLayout($layoutRelativePath, $viewRelativePath, $variables = null) {
        $view = self::render($viewRelativePath, $variables);
        $page = self::render($layoutRelativePath, array(
            "contents" => $view
        ));
        return $page;
    }

}
