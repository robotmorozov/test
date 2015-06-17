<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">

	<title><?$APPLICATION->ShowTitle()?></title>
    <meta name="viewport" content="width=device-width, maximum-scale=1">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.0/masonry.pkgd.min.js"></script>
    <script src="<?=LAYOUT?>js/owl.carousel.min.js"></script>
    <script src="<?=LAYOUT?>js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="<?=LAYOUT?>css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="<?=LAYOUT?>css/style.css" />

	<?$APPLICATION->ShowHead();?>
    
</head>
<body>
    <div id = 'panel'>
        <?$APPLICATION->ShowPanel()?>
    </div>

    <header>
        <div class="inside">
            Тестовое задание
        </div>
    </header>

    <div class="main">
        <div class="inside">
            <div class="grid">

