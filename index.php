<?php


session_name("qrSession");
session_start();
$api = (array)json_decode(file_get_contents('https://dash.devlab.ae/api/v1/site/https://qr-code-generator.io'));

error_reporting(E_ALL ^ E_NOTICE);
require dirname(__FILE__)."/config.php";
if (isset($_GET['reset'])) {
    unset($_SESSION['logo']);
}
global $_ERROR;

if (isset($_SESSION['error'])) {
    $_ERROR = $_SESSION['error'];
    unset($_SESSION['error']);
}
require dirname(__FILE__)."/include/functions.php";

$browserDetect = array_key_exists('detect_browser_lang', $_CONFIG) ? $_CONFIG['detect_browser_lang'] : false;
$defaultlang = array_key_exists('lang', $_CONFIG) ? $_CONFIG['lang'] : 'en';
$color_primary ='#36bc67';//array_key_exists('color_primary', $_CONFIG) ? $_CONFIG['color_primary'] : false;
$lang = getLang($defaultlang, $browserDetect);

if(!in_array($lang, ['ar','en'])){
    $lang="ar";
}/*
var_dump($lang);*/

if (file_exists(dirname(__FILE__)."/translations/".$lang.".php")) {
    include dirname(__FILE__)."/translations/".$lang.".php";
}
require dirname(__FILE__)."/include/head.php";
require dirname(__FILE__)."/lib/countrycodes.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" class="<?php echo $_SESSION['mode'] == 'night' ? 'dark' : ''; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!--  <title><?php echo getString('title'); ?></title> -->
    <!-- <meta name="description" content="<?php echo getString('description'); ?>">
        <meta name="keywords" content="<?php echo getString('tags'); ?>"> -->

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/ie8.js"></script>
    <![endif]-->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174669370-6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-174669370-6');
    </script>


    <?php $version= '?v='.time(); ?>
    <link rel="icon" type="image/png" href="
        <?php
    if($lang=="ar") echo $api['site_profile']->icon_ar;
    else echo $api['site_profile']->icon_en;
    ?>
        " />
    <meta name=" description" content="
        <?php if($lang=="ar") echo $api['site_profile']->site_description_ar;
    else echo $api['site_profile']->site_description_en; ?>">

    <title>
        <?php if($lang=="ar"){
            echo $api['site_profile']->site_name_ar ." | ";
            echo $api['site_profile']->site_sub_name_ar;
        }else{
            echo $api['site_profile']->site_name_en. " | ";
            echo $api['site_profile']->site_sub_name_en;
        }
        ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="
        <?php
    if($lang=="ar")
        echo $api['site_profile']->ar_keywords;
    else
        echo $api['site_profile']->en_keywords;
    ?>
        ">
    <?php echo $api['site_profile']->google_analytics; ?>
    <link href="style.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <?php echo setMainColor($color_primary); ?>
    <?php if($_SESSION["mode"] == 'night'){ ?>
        <style>
            /*label, h4, input, select{*/
            /*    color: #ffffff !important;*/
            /*}*/
            /*input:focus{*/
            /*    background-color: #171734 !important;*/
            /*}*/
            /*label{*/
            /*    background-color: transparent !important;*/
            /*    border-color: transparent !important;*/
            /*}*/
        </style>
    <?php } ?>
    <style>
        html.dark, body.dark, .container.dark, .bg-white.dark{
            background-color: #171734 !important;
        }
        .btn-light.dark{
            background-color: #171734 !important;
            border-color: #171734 !important;
        }
        h1.dark, p.dark, a.dark, label.dark, h4.dark, input.dark, select.dark, .linksholder.dark i, .linksholder.dark a{
            color: #ffffff !important;
        }
        input.dark:focus{
            background-color: #171734 !important;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }


    </style>
</head>
<body class="bg-light <?php echo $_SESSION['mode'] == 'night' ? 'dark' : ''; ?>">
<div class="col-12 px-0" style="">
    <?php if($api['advs']->header_status==1){ ?>
        <?php if($lang=="ar"){ ?>
            <div class="col-12 px-0" style="background-color: #EB593C; color: white; text-align: center; padding: 5px; direction: rtl">
                <?php echo preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $api['advs']->header_ar); ?>
            </div>
        <?php }else{ ?>
            <div class="col-12 px-0" style="background-color: #EB593C; color: white; text-align: center; padding: 5px; direction: ltr">
                <?php echo preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $api['advs']->header_en); ?>
            </div>
        <?php } ?>
    <?php } ?>

    <div class="container {{session('mode')=='night' ? 'dark': ''}}" style="padding: 10px 5px 5px; height: auto">
        <div class="col-12 row px-0">
            <div class="col-6 text-left">
                <?php if($lang=="en"){ ?>
                    <a style="color: #8e8e8f; text-decoration: none" class="language-link <?php echo $_SESSION['mode'] == 'night' ? 'dark' : ''; ?>" href="/?lang=ar">العربية</a>
                <?php }else{ ?>
                    <a style="color: #8e8e8f; text-decoration: none" class="language-link <?php echo $_SESSION['mode'] == 'night' ? 'dark' : ''; ?>" href="/?lang=en">English</a>
                <?php } ?>
            </div>
            <div class="col-6 text-right" style="display: flex; flex-direction: row; justify-content: flex-end; align-items: center">
                <p style="margin-right: 10px; margin-left: 10px" class="switch-label <?php echo $_SESSION['mode'] == 'night' ? 'dark' : ''; ?>">
                    <?php if($lang=="en"){ ?>
                        Dark Mode
                    <?php }else{ ?>
                        الوضع الليلي
                    <?php } ?>
                </p>
                <label class="switch">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" style="opacity: 0" <?php echo $_SESSION["mode"]=='night' ? 'checked=""' : ''; ?> >
                    <span class="slider round"></span>
                </label>

            </div>
        </div>
    </div>
</div>

<div class="col-12 px-0">
    <div class="col-12 px-0">
        <?php if($lang=="ar" &&  $api['advs']->popup_status==1)
            echo $api['advs']->popup_ar;
        else
            echo $api['advs']->popup_en;
        ?>
    </div>
</div>
<!--   -->
<style type="text/css">
    *{
        font-family: 'Almarai', sans-serif;
    }
    .placeresult{
        box-shadow: 0px 0px 10px #e6e6e6;
        border-radius: 8px;
    }
</style>



<div class="col-12 row justify-content-center m-0 px-0 <?php echo $_SESSION['mode'] == 'night' ? 'dark' : ''; ?>" style="min-height: 100vh">



    <div class="col-12 px-0 m-auto">

        <div class="container  pt-4 px-4 <?php echo $_SESSION['mode'] == 'night' ? 'dark' : ''; ?>" style="background: #fff;border-radius: 12px;">
            <div class="col-12 text-center pt-4">
                <a href="/" class="d-inline-block mb-5 pb-5">
                    <?php if($lang=='ar') { ?>
                        <img src="<?php echo  $api['site_profile']->logo_ar_path ;?>" style="width: 250px;display: inline-block;" id="site-logo">
                    <?php } else if($lang!='ar') { ?>
                        <img src="<?php echo $api['site_profile']->logo_en_path; ?>" style="width:250px;display: inline-block;" id="site-logo">
                    <?php }?>
                </a>
            </div>

            <?php

            if (file_exists(dirname(__FILE__).'/include/generator.php')) {
                include dirname(__FILE__).'/include/generator.php';
            }

            ?>
        </div>

    </div>


</div>
<?php
if($lang=="ar" && $api['footer']->footer_ar_enabled==1)
    echo $api['footer']->footer_ar ;
else if($api['footer']->footer_en_enabled==1)
    echo $api['footer']->footer_en ;
?>

<script src="js/popper.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="js/all.js?v=3"></script>
<link rel="stylesheet" type="text/css" href="https://footer.devlab.ae/public/styles.css">
<?php if($_SESSION['mode'] == 'night'){ ?>
    <iframe src="https://footer.devlab.ae/<?php echo $lang; ?>?mode=night&night_bg=171734&day_bg=f5f7fb" class="col-12 footer-iframe px-0" style="width: 100%" id="devlab-footer"></iframe>
<?php }else{ ?>
    <iframe src="https://footer.devlab.ae/<?php echo $lang; ?>?mode=day&night_bg=f8f9fa&day_bg=f8f9fa" class="col-12 footer-iframe px-0" style="width: 100%" id="devlab-footer"></iframe>
<?php } ?>
<?php if($_SESSION["mode"] == 'night'){ ?>
    <script type="text/javascript">
        $('body').addClass("dark");
        $('html').addClass("dark");
        $('.container').addClass("dark");
        $('.language-link').addClass("dark");
        $('.switch-label').addClass("dark");
        $('.bg-white').addClass("dark");
        $('.btn-light').addClass("dark");
        $('label').addClass("dark");
        $('h4').addClass("dark");
        $('input').addClass("dark");
        $('select').addClass("dark");
        $('i').addClass("dark");
    </script>
<?php } ?>

<script type="text/javascript">
    $('#inlineCheckbox1').change(function() {

        if ($(this).is(':checked')) {


            $('#devlab-footer').attr('src','https://footer.devlab.ae/<?php echo $lang; ?>?mode=night&night_bg=171734&day_bg=f5f7fb');

            $('#site-logo').attr('src', '<?php echo $api['site_profile']->logo_en_path_dark; ?>');
            $('body').addClass("dark");
            $('html').addClass("dark");
            $('.container').addClass("dark");
            $('.language-link').addClass("dark");
            $('.switch-label').addClass("dark");
            $('.bg-white').addClass("dark");
            $('.btn-light').addClass("dark");
            $('label').addClass("dark");
            $('h4').addClass("dark");
            $('input[type = "text"]').addClass("dark");
            $('select').addClass("dark");
            $('.linksholder').addClass("dark");

            $.ajax({
                method: "get",
                url: "/update_mode.php",
                data: { mode: 'night' }
            }).done(function(msg) {});
        } else {

            $('#devlab-footer').attr('src','https://footer.devlab.ae/<?php echo $lang; ?>?mode=day&night_bg=171734&day_bg=f5f7fb');

            $('body').removeClass("dark");
            $('html').removeClass("dark");
            $('.container').removeClass("dark");
            $('.language-link').removeClass("dark");
            $('.switch-label').removeClass("dark");
            $('.bg-white').removeClass("dark");
            $('.btn-light').removeClass("dark");
            $('label').removeClass("dark");
            $('h4').removeClass("dark");
            $('input[type = "text"]').removeClass("dark");
            $('select').removeClass("dark");
            $('.linksholder').removeClass("dark");


            $('#site-logo').attr('src', '<?php echo $api['site_profile']->logo_en_path; ?>');

            $.ajax({
                method: "get",
                url: "/update_mode.php",
                data: { mode: 'day' }
            }).done(function(msg) {});
        }
    });

    function update_mood(){
        $.ajax({
            method: "get",
            url: "/update_mode.php",
            data: { mode: 'night' }
        }).done(function(msg) {});
        $.ajax({
            method: "get",
            url: "/update_mode.php",
            data: { mode: 'day' }
        }).done(function(msg) {});
    }
</script>
</body>
</html>