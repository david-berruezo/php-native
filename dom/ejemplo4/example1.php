<?php
    include 'spl.php';
    /*
    see how we work with our document like jQuery :D but it's in php !
    */
    ob_start();
?>
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


<?php
    $html = ob_get_clean();
    use DOM\DOM as pQuery;
    pQuery::createDocFromHTML($html);
    pQuery::select("p")->addClass('myPrivacy')->append("You know !");
    pQuery::select("#biography")->attr('title', "My Auto Biography")->css("background", "yellow");
    $cloned = pQuery::select("#biography")->_clone();
    pQuery::select(".myframework")->append("<br>this is appended from a cloned node : " . $cloned->html());
    print pQuery::getHTML();
?>
