<?php include "scripts/gm_access.php"; ?>
<?php include "scripts/gm_tools_avto.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title><?php if ($page_title.""=="") print "$site_name"; else print $page_title; ?></title>
	<meta name="description" content="<?php print "$site_keywords"; ?>">
	<meta name="keywords" content="<?php print "$site_keywords"; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<link rel="icon" type="image/vnd.microsoft.icon" href="images/favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link href="scripts/gm_styles.css" rel="stylesheet" type="text/css" media="all">
		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">
		<link href="images/jquery00.css" rel="stylesheet" type="text/css" media="all">
		<link href="images/css00000.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="images/jquery00.js"></script>
		<script type="text/javascript" src="images/tools000.js"></script>
		<script type="text/javascript" src="images/ajax-car.js"></script>
		<script type="text/javascript" src="images/jquery01.js"></script>
	    <!-- script type="text/javascript" src="SPARE%20PARTS_files/cookies0.js"></script -->
    	<script type="text/javascript" src="images/script00.js"></script>
        <script type="text/javascript" src="images/jscript_.js"></script>   
        <!-- script type="text/javascript" src="images/superfish.js"></script -->	
		<script type="text/javascript" src="images/jquery-1.js"></script>  
</head>
<body id="index">
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            $(window).scroll(function(){
                $('#message_box').animate({top:$(window).scrollTop()+"px" },{queue: false, duration: 350}); 
            });
            $('#close_message').click(function(){
                $('#message_box').animate({ top:"+=15px",opacity:0 }, "slow");
            });
        });
  </script>
    <div id="message_box" class="hidden"><img id="close_message" style="float:right;cursor:pointer"  src="images/cross.png" />Здесь Ваше сообщение</div>
<!--[if lt IE 8]><div style='clear:both;height:59px;padding:0 15px 0 15px;position:relative;z-index:10000;text-align:center;'><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." /></a></div><![endif]-->
<p id="back-top"> <a href="#top"><span></span></a> </p>
<div id="wrapper1">
<div id="wrapper2">
<div id="wrapper3">
	<!-- Header -->
	<?php include "_header.php"; ?>
	<div id="columns">
		<!-- Center -->
        <div id="center_column" class="center_column">
    	<?php if (isset($page_center)) include $page_center; ?>
        </div>
	<!-- Right -->
	<div id="right_column" class="column">
        	<?php if (!isset($page_baner)) { ?>
        	<div style=" height:11px"></div>
            <?php } ?>
			<!-- MODULE Block cart -->
            <div id="cart_macro">
    		<!--?php include "_cart_makro.php"; ?-->
            </div>
            <script type="text/javascript">
				$('#cart_macro').load('_cart_makro.php?kod_=<?php print $kod_; ?>');
			</script>
			<!-- /MODULE Block cart -->
			<!-- tmspecials -->
    		<?php include "_actions.php"; ?>
			<!-- /tmspecials -->
        </div>
		<div class="clearblock"></div>
	</div>
<!-- Footer -->
	<?php include "_bottom.php"; ?>
</div>
</div>
<?php if (($_SERVER['HTTP_HOST']=="tandem-auto.com.ua")or($_SERVER['HTTP_HOST']=="www.tandem-auto.com.ua")) include "counters.php"; ?>
</div>
</body>
</html>