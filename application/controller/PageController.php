<?php 

class PageController {
    
    public function handle() {
        
        $path = Utils::sanitize(Request::path(), 'path');
        if (empty($path)) {
            return false;
        }
        
        $file = View::find($path);
        
        if (!$file) {
            $file = View::find($path . '/index');
        }
        
        if (!$file) {
            return false;
        }
        
        echo View::render($file);
        
        return true;
        
    }
    
}
?>