<?php 

/***
 * This is the router file. Here is the place where the request is analysed and
 * the right Controller is chosen to handle it and return a response. It is
 * also the place where a Exception Handler is assigned.
 * 
 * A request will be routed by default the following way, if the controllers
 * are made using the following convention:
 * 
 *   Last element in the URL, converted to camelCase = function() to call
 *   Second last, converted to UpperCamelCase = Controller class name
 *   The rest = subfolder in the application/controller folder
 *   
 *   The default folder, if can't specify one, is application/controller/
 *   The default controller, if can't specify one, is HomeController
 *   The default function, if can't specify one, is index()
 * 
 *   example.com/index.php/abc
 *      Controller = HomeController
 *      function = abc()
 *      
 *   example.com/index.php/abc/def
 *      Controller = AbcController
 *      function = def()
 *      --- If can't find, will try this:
 *          Subfolder = abc
 *          Controller = DefController
 *          function = index()
 *      
 *   example.com/index.php/abc/def/ghi
 *      Subfolder = abc
 *      Controller = DefController
 *      function = ghi()
 *      --- If can't find, will try this:
 *          Subfolder = abc/def
 *          Controller = GhiController
 *          function = index()
 *      
 *   example.com/index.php/abc/def/ghi/jkl
 *      Subfolder = abc/def/
 *      Controller = GhiController
 *      function = jkl()
 *      --- If can't find, will try this:
 *          Subfolder = abc/def/ghi
 *          Controller = JklController
 *          function = index()
 */


