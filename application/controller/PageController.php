<?php 

class PageController {
    
    protected static $supportedExtension = array(
        "md.php",
        "md",
        "html",
        "php",
        "txt"
    );
    
    public function handle() {
        
        $path = Utils::sanitize(Request::path(), 'path');
        if (empty($path)) {
            return false;
        }
        
        $searchFilename = glob(DIR_PAGES . DS . $path . '.{' . implode(',', self::$supportedExtension) . '}', GLOB_BRACE);
        $searchIndex = glob(DIR_PAGES . DS . $path . '/index.{' . implode(',', self::$supportedExtension) . '}', GLOB_BRACE);
        
        if (count($searchFilename) == 0 && count($searchIndex) == 0) {
            return false;
        }
        
        if (isset($searchIndex[0])) {
            $fileAsView = str_replace(DIR_PAGES . DS, '', $searchIndex[0]);
            echo View::render($fileAsView);
            return true;
        } else {
            $fileAsView = str_replace(DIR_PAGES . DS, '', $searchFilename[0]);
            echo View::render($fileAsView);
            return true;
        }
        
    }
    
}
?>