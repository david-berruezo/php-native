<?php
    /**
    *
    * FSS Framework
    *
    * @package : FSS Framework
    * @author : Mohamad Mohebifar
    * @copyright : Copyright (c) 2012, Mohamad Mohebifar
    * @link : http://www.mohebifar.ir
    * @since : Version 1.0
    */

    /*
    With this sample you can do whatever you want with your document before
    having any content. all operations will be saved in stack. after giving
    html content you can call stack then all effects will be appeared.
    */
    include 'spl.php';

    use DOM\DOM as pQuery;

    pQuery::select("p")->addClass('myPrivacy')->append("You know !");
    pQuery::select("#biography")->attr('title', "My Auto Biography")->css("background", "yellow");
    $cloned = pQuery::select("#biography")->_clone();

    $html = <<<HTML
    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">

<html>
    <head>
        <meta name="generator" content="FSS DOM Object">

        <title>My Test</title>
    </head>
    <body>
        <div id="biography">
            Hello ! I am Mohamad Mohebifar from iran and i was born in 1993.
            I study Chemistry & IT at Shahid Beheshti University.
        </div>
        <p>
            FSS stands for my love's name. I present this class to FSS ! ♥
        </p>
        <div class="myframework">
            I had created this class for my own framework (FSS) and now i published it.
        </div>
    </body>
</html>
HTML;

    pQuery::createDocFromHTML($html);
    pQuery::callStack();

    print pQuery::getHTML();
?>
