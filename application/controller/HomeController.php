<?php

class HomeController extends Controller
{

    public function index()
    {
        $layout = "layouts/master.layout.php";
        $view = "testview.php";
        $variables = array(
            "contents" => "vai nesse texto truta"
        );
        
        $html = View::renderWithLayout($layout, $view, $variables);
        echo $html;
    }

    public function abc()
    {}
}