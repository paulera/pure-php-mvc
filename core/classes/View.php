<?php
defined('IS_APP') || die();

class View
{
    
    private static $supportedExtensions = array(
        ".md.php",
        ".md",
        ".html",
        ".php",
        ".txt"
    );
    
    public static function getSupportedExtensions() {
        return self::$supportedExtensions;
    }

    public static function render($view, $variables = null, $extension = null)
    {
        $cleanPath = Utils::sanitize($view, 'view');
        if (file_exists($cleanPath)) {
            $filePath = $cleanPath;
        } else {
            $filePath = self::find($cleanPath);
        }
        
        if ($filePath && file_exists($filePath)) {
            ob_start();
            if (isset($variables) and is_array($variables)) {
                extract($variables);
            }
            
            if (! isset($extension)) {
                $filename = basename($filePath);
                $dot = strpos($filename, '.');
                $extension = substr($filename, $dot);
            }
            
            $extension = strtolower(trim($extension, '.'));
            
            switch ($extension) {
                case 'php':
                    include ($filePath);
                    break;
                
                case 'md':
                    $mdContents = file_get_contents($filePath);
                    $parsedown = new Parsedown();
                    $htmlContents = $parsedown->text($mdContents);
                    echo $htmlContents;
                    break;
                
                case 'md.php':
                    $mdContents = self::render($view, $variables, 'php');
                    $parsedown = new Parsedown();
                    $htmlContents = $parsedown->text($mdContents);
                    echo $htmlContents;
                    break;
                
                case 'html':
                case 'htm':
                    $htmlContents = file_get_contents($filePath);
                    echo $htmlContents;
                    break;
                
                case 'txt':
                    $htmlContents = file_get_contents($filePath);
                    $htmlContents = htmlentities($htmlContents);
                    echo $htmlContents;
                    break;
            }
            
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }
        return false;
    }

    public static function renderWithLayout($layoutRelativePath, $viewRelativePath, $variables = null)
    {
        $view = self::render($viewRelativePath, $variables);
        $layoutVariables = array_merge($variables, array(
            "contents" => $view
        ));
        $page = self::render($layoutRelativePath, $layoutVariables);
        return $page;
    }

    public static function error($code, $variables = null)
    {
        $code = intval($code);
        http_response_code($code);
        
        $view = "error_" . $code . ".php";
        
        if (isset($variables) && is_array($variables) && ! isset($variables['code'])) {
            $variables['code'] = $code;
        }
        
        if (View::find
            ($view)) {
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
    
    public static function findAll($path)
    {   
        $filename = basename($path);
        if (strpos($filename, '.') > 0) {
            if (file_exists(DIR_VIEW . DS . $path)) {
                return array(DIR_VIEW . DS . $path);
            }
            
            if (file_exists(DIR_PAGES . DS . $path)) {
                return array(DIR_PAGES . DS . $path);
            }
            
            if (file_exists(DIR_APP . DS . $path)) {
                return array(DIR_APP . DS . $path);
            }
        }
        
        $brace = '{' . implode(',', self::$supportedExtensions) . '}';
        $files = glob(DIR_VIEW . DS . $path . $brace, GLOB_BRACE);
        if (! count($files)) {
            $files = glob(DIR_PAGES . DS . $path. $brace, GLOB_BRACE);
            if (! count($files)) {
                $files = glob(DIR_APP . DS . $path. $brace, GLOB_BRACE);
                if (! count($files)) {
                    return false;
                }
            }
        }
        return $files;
    }
    
    public static function find($path)
    {
        $files = self::findAll($path);
        if (!$files) {
            return false;
        }
        return $files[0];
    }
    
}
