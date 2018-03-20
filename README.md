# pure-php-mvc

This is a work in progress.

The pure-php-mvc project implements basic concepts of a MVC web application without using PHP frameworks and plenty of comments, so it can be used for studying the MVC pattern.

The data storage is file-based and there is no dependency on SQL servers or any third application such Apache/Ngix. The site runs entirely on PHP only and can be deployed locally using the PHP built-in server: `sh serve.sh`

```
(80%) Classloader
(50%) Web Application Firewall
(75%) Controller
(90%) View
(   ) Unit tests
(   ) Dispatcher
(30%) Model
(50%) Controller
```
