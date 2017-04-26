<?php
function randomHex(){
    $a = range('a', 'f');
    $b = range(0,9);

    $r = array_merge($a, $b);
    $out = '#';
    $i = 0;
    while($i < 6){
        $out .= $r[array_rand($r,1)];
        $i++;
    }
    return $out;
}


function createDirs(){
    $out = '';
    $dirs = array_filter(glob('*'), 'is_dir');

    $groups = [];
    foreach($dirs as $dir){
        $sn = substr($dir, 0, strpos($dir, '-'));
        if(!empty($sn)){
            if(!isset($groups[$sn])){
                $groups[$sn][] = $dir;
            } else {
                $groups[$sn][] = $dir;
            }
        } else {
            $groups[0][] = $dir;
        }
    }

    foreach($groups as $key => $group){
        $name = ($key === 0) ? 'General' : $key;
        $line = "<div class='group-header' data-group='$key'><h4>$name</h4>";
        $line .= "<div class='go-visit-outer'>";
        foreach($group as $dir){
            $sn = substr($dir, 0, strpos($dir, '-'));

            $bgC = randomHex();

            $line .= "<div class='go-visit' style='background-color:$bgC'>";
            $line .= "<h2 style='color: white; text-align: center; text-shadow: 0px 0px 4px rgba(150, 150, 150, 1);'>".$dir."</h2>";
            $line .= "<a href='//$dir.git/'>";
            $line .= "<div class='go-visit-pop'></div>";
            $line .= "</a>";
            $line .= "</div>";
        }
        $line .= "</div>";
        $line .= "</div>";
        $out .= $line;
    }
    return $out;
}
?>

<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        .go-visit{
            position: relative;
            overflow: hidden;
        }
        .go-visit > h2{
            line-height: 80px;
            margin: 0;
            padding: 0;
        }
        .go-visit > a{
            background-color: inherit;
        }
        .go-visit-pop{
            text-align: center;
            color: white;
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0; bottom: 0; left: 100%;
            background-color: rgba(255,255,255,.3);
            z-index: 1;
            transition: left 1s ease-in-out;
            opacity: .8;
        }
        .go-visit:hover .go-visit-pop{
            left: 0;
        }
        .group-header > h4{
            line-height: 60px;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
            margin: 0;
            padding: 0 20px;
            background-color: #333;
            color: white;
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
            font-family: "Calibri";
        }

        .go-visit-outer{
            display: none;
        }

    </style>
</head>
<body>
<div style="width: 50%; margin: 0 25%;">
    <?=createDirs()?>
</div>
</body>
<script>
$(function(){
    item = JSON.parse(localStorage.getItem('active-groups'));

    if(!item){
        item = {};
        localStorage.setItem('active-groups', JSON.stringify(item));
    } else {
        for(var i in item){
             elem = $('[data-group="'+i+'"]');
             if(elem.length > 0){
                 $(elem.find('.go-visit-outer')).slideDown();
             }
        }
    }
});
    $('.group-header').on('click', function(e){
        item = JSON.parse(localStorage.getItem('active-groups'));

        visit = $(this).find('.go-visit-outer');
        key = $(this).data('group');

        if(visit[0].style.display == 'block'){
            delete item[key];
        } else {
            if(item[key] == undefined){
                item[key] = 1;
            }
        }
        localStorage.setItem('active-groups', JSON.stringify(item));
        visit.slideToggle();

    });
</script>
</html>
