Consider Example1.php
The HTML content is :
__________________________________

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
            I present this class to FSS ! ?
        </p>
        <div class="myframework">
            Test
        </div>
    </body>
</html>

__________________________________
but with DOM object we made some changes and now the result is :
__________________________________

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
<meta name="generator" content="FSS DOM Object">
<title>My Test</title>
</head>
<body>
        <div id="biography" title="My Auto Biography" style="background: yellow;">
            Hello ! I am Mohamad Mohebifar from iran and i was born in 1993.
            I study Chemistry & IT at Shahid Beheshti University.
        </div>
        <p class="myPrivacy">
            I present this class to FSS ! ♥
        You know !</p>
        <div class="myframework">
            Test
        <br>this is appended from a cloned node : 
            Hello ! I am Mohamad Mohebifar from iran and i was born in 1993.
            I study Chemistry & IT at Shahid Beheshti University.
        </div>
    </body>
</html>


__________________________________
with this code we make document from html string content :
pQuery::createDocFromHTML($html);

and now we select an element using CSS Selector
pQuery::select("p")

then we can do somework with it !! like jQuery
->addClass('myPrivacy')->append("You know !")

as you see in the result content, we have :
<p class="myPrivacy">
	FSS stands for my love's name. I present this class to FSS ! ♥
	You know !</p>
		
while the source was :
<p>
    FSS stands for my love's name. I present this class to FSS ! ?
</p>


now we can add css style, append some text, prepend text, set attribute, get attribue, clone, get inner html, set inner html, add or remove class, check existing class and destroy node !
PHPDoc is prepared for you. just use a good IDE that supports PHPDoc.