<?php

class HomeController
{

    public function index()
    {
        $layout = "layouts/master.php";
        $view = "testview.php";
        $variables = array(
            "title" => "vai nesse texto truta"
        );
        
        $html = View::renderWithLayout($layout, $view, $variables);
        die($html);
    }

    public function abc()
    {}
}