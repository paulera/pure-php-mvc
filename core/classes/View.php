<?php

class View {
    
    public static function render($view, $variables = null) {
        
        $viewRelativePathClean = str_replace("../", "", $view);
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
    
    public static function error($code, $variables = null) {
        
        $code = intval($code);
        http_response_code($code);
        
        $view = "error_".$code.".php";
        
        if (isset($variables) && is_array($variables) && !isset($variables['code'])) {
            $variables['code'] = $code;
        }

        if (View::exists($view)) {
            echo View::render($view, $variables);
            die();
        }
        
        echo "Error {$code}\n<br>";
        if (isset($variables) && is_array($variables)) {
            foreach ($variables as $variableName => $variableValue) {
                echo "{$variableName} = {$variableValue}";
            }
        }
        die();
    }
    
    public static function exists($view) {
        return (file_exists(DIR_VIEW . DS . $view));
    }
}
