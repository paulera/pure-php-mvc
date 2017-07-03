<?php

class View {
    
    public static function render($viewRelativePath, $variables = null) {
        
        $viewRelativePathClean = str_replace("../", "", $viewRelativePath);
        $filePath = DIR_VIEW.DS.$viewRelativePathClean;
        if (!file_exists($filePath)) {
            $filePath = DIR_APP.DS.$viewRelativePathClean;
            if (!file_exists($filePath)) {
                $filePath = DIR_ROOT.DS.$viewRelativePathClean;
                if (!file_exists($filePath)) {
                    throw new Exception("View not found: ".$viewRelativePathClean);
                }
            }
        }
        
        ob_start();
        if (isset($variables) and is_array($variables)) {
            extract($variables);
        }
        include $filePath;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    
    public static function renderWithLayout($layoutRelativePath, $viewRelativePath, $variables = null) {
        $view = self::render($viewRelativePath, $variables);
        $layoutVariables = array_merge ($variables, array(
            "contents" => $view
        ));
        $page = self::render($layoutRelativePath, $layoutVariables);
        return $page;
    }
    
    public static function error404() {
        http_response_code(404);
        echo View::render("404.php");
        die();
    }
    
    public static function error500() {
        http_response_code(500);
        echo View::render("500.php");
        die();
    }
    
    public static function exists($viewPath) {
        return (file_exists(DIR_VIEW . DS . $viewPath));
    }
}
