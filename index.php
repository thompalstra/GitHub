<?php
include("autoloader.php");
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
            text-decoration: none;
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

        .group-header{
            margin-bottom: 10px;
        }
        .dashboard-container.toggle-inner,
        .toggle-inner{
            display: none;
        }

        .container{
            width: 1200px;
            margin: auto;
        }
        .col{
            float: left;
            display: inline-block;
            box-sizing: border-box;
            position: relative;
        }
        .dt12{
            width: 100%;
        }
        .dt6{
            width: 50%;
        }
        .dashboard-container .dt3{
            padding-bottom: 25%;
            margin-bottom: -12.5%;
        }
        .dashboard-container .dt6{
            padding-bottom: 50%;
            margin-bottom: -25%;
        }

        .dt3{
            width: 25%;
        }
        .dashboard-container{
            background-color: #333;
            display: inline-block;
            overflow: auto;
            width: 100%;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .dashboard-container .widget-title{
            margin: 0;
            padding: 0;
            color: white;
            text-align: center;
            margin: 0 0 10px 0;
            font-family: "Calibri";
        }

        .dashboard-widget.gauge .widget-title{
            margin: 0;
            padding: 0;
            color: white;
            text-align: center;
            margin: 10px 0;
            z-index: 20;
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-transform: uppercase;
        }
        .dashboard-widget.gauge .widget-title > .sub{
            display: inline-block;
            width: 100%;
            font-size: 11px;
        }

        .dashboard-widget.gauge{
            width: calc(100% - 20px);
            height: calc(50% - 10px);
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }
        .dashboard-widget.gauge:after{
            content: "";
            height: 100%;
        }

        .dashboard-widget.gauge > .inner{
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .dashboard-widget.gauge > .inner:after{
            content: "";
            position: absolute;
            width: 80%;
            height: 80%;
            background-color: #333;
            border-top-left-radius: 500px;
            border-top-right-radius: 500px;
            left: 0;
            bottom: 0;
            right: 0;
            margin: auto;
        }

        .dashboard-widget.gauge > .inner .gauge-inner{
            content: "";
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-top-left-radius: 500px;
            border-top-right-radius: 500px;
            position: absolute;
            background-color: transparent;
        }

        .dashboard-widget.gauge > .inner .gauge-value{
            width: 100%;
            height: 100%;
            background-color: green;
            border-top-left-radius: 500px;
            border-top-right-radius: 500px;
            transform: rotate(180deg);
            transform-origin: 50% 100%;
            transition: all 2s ease-in-out;
            z-index: 10;
        }
        .dashboard-widget.gauge > .inner .gauge-value:before{
            content: "";
            width: 100%;
            height: 200%;
            border-radius: 5000000px;
            background-color: #111;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
        }
        .dashboard-widget.gauge > .inner .gauge-value:after{
            content: "";
            width: 100%;
            height: 100%;
            border-top-left-radius: 500px;
            border-top-right-radius: 500px;
            background-color: inherit;
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
        }


        .dashboard-widget.gauge > .inner .gauge-indicator{
            width: 50%;
            bottom: 4px;
            left: 0;
            right: 0;
            position: absolute;
            margin: auto;
            color: white;
            z-index: 2;
            text-align: center;
        }

        .dashboard-widget.progress{
            width: 100%;
            padding: 0 10px 10px 10px;
            box-sizing: border-box;
        }
        .dashboard-widget.progress > .inner{
            position: relative;
            background-color: #111;
        }
        .dashboard-widget.progress > .inner > .value{
            width: 0;
            transition: width 2s ease-in-out;
            height: 34px;
        }

        .dashboard-widget.progress > .inner > .indicator{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            color: white;
            line-height: 34px;
        }



    </style>
</head>
<body>
    <section class='container'>
        <div class='group-header' data-group='data'><h4>Statistics</h4>
        <section class='dashboard-container toggle-inner'>
            <div class='col dt12'>
                <?=ServerWidget::createDriveSpaceWidget()?>
            </div>
            <div class='col dt12'>
                <div class='col dt3'>
                    <?=ServerWidget::createRamPeakWidget()?>
                </div>
                <div class='col dt3'>
                    <?=ServerWidget::createRamCurrentWidget()?>
                </div>
            </div>
            <!-- <div class='col dt12'> -->
                <?=ServerWidget::createServerLoadWidget()?>
            <!-- </div> -->
            </div>
        </section>
    </section>
<div class='container'>
    <?=ProjectWidget::createDirs()?>
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
                 $(elem.find('.toggle-inner')).slideDown();
             }
        }
    }
});

items = [];
var interval;
$(function(){
    var i = 0;
    $('.dashboard-widget.progress').each(function(e){
        v = $(this).find('.value');
        if(v.length > 0){
            v[0].style.width = $(this).data('value') + "%";
        }

    });
    $('.dashboard-widget.gauge').each(function(e){
        am = $(this).find('.gauge-value');
        val = am.data('value');
        if(val <= 25){
            color = '#1C84A7';
        } else if(val <= 50){
            color = '#FEC606';
        } else if(val < 75){
            color = '#FF7416';
        } else if(val >= 75){
            color = '#CF000F';
        }

        console.log(val + " | " + color);
        am[0].style.backgroundColor = color;

        rot = 180 + parseInt(val) * 3.6 / 2;
        am[0].parentNode.parentNode.setAttribute('id', 'widget-'+i);
        am[0].style.transform = "rotate("+rot+"deg)";
        obj = { id : i, elem: am[0].parentNode, targetValue: parseFloat(val).toFixed(2)};
        items.push(obj);
        i++;
    });
    interval = window.setInterval(function(e){
        setValues();
    },20);

});
function setValues(int){
    for(var i in items){
        item = items[i];
        if(item == null){
            continue;
        }
        indicator = $(item.elem).find('.gauge-indicator');

        currentValue = parseFloat(indicator.data('value'));

        targetValue = item.targetValue;
        index = item.i;

        valuePerTick = item.targetValue / 100;

        newValue = currentValue + valuePerTick;
        if(newValue > targetValue){
            indicator[0].innerHTML = parseFloat(targetValue).toFixed(2) + "%";
            indicator.data('value', targetValue);
            items.splice(i, 1);
            continue;
        }


        indicator[0].innerHTML = parseFloat(newValue).toFixed(2) + "%";
        indicator.data('value', newValue);
    }
    if(items.length == '0'){
        clearInterval(interval);
    }
}


    $('.group-header > h4').on('click', function(e){
        item = JSON.parse(localStorage.getItem('active-groups'));

        visit = $(this.parentNode).find('.toggle-inner');
        key = $(this.parentNode).data('group');

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
