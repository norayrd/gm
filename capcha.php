<?php

include("scripts/gm_access.php");
//putenv('GDFONTPATH=' . realpath('.'));

$tbCapcha_n=0;
while ($tbCapcha_n==0){
	$r=rand(0,99);
	$sql="select * from gm_capcha limit $r,1";
	$tbCapcha=mysql_query($sql);
	@$tbCapcha_n=mysql_numrows($tbCapcha);
	$r=mysql_result($tbCapcha,0,"capcha_");
	if ($tbCapcha_n==0) { include("capcha_recapching.php"); }
}


header ("Content-type: image/png");

for($i=0;$i < 4;$i++)	$arr[$i]=substr($r,$i,1);

//$im=ImageCreateTrueColor(130,40);
$im=ImageCreate(130,40);

//putenv('GDFONTPATH=' . realpath('.'));

$font = "ELEPHNT.TTF";

imagecolorallocate($im,153,153,153);
$a=0;
$color_w=imagecolorallocate($im,255,255,255);
$color_g=imagecolorallocate($im,204,204,204);
//$color_g=imagecolorallocate($im,196,22,280);


for($i=0;$i<4;$i++)
	$arr_=imagettftext( $im,15,rand(-35,35),$a+=21, rand(20,30),$color_g,$font,$arr[$i]);


//for($i=20;$i <= 100;$i+=40)	rev($im,$i,rand(10,30));
	
function rev(&$im,$x,$y)
{
	global $color_w,$color_g;
	$w=$h=rand(15,30);
	for($i=$x-$w/2;$i < $x+$w/2;$i++)
		for($k=$y-$h/2;$k < $y+$h/2;$k++,$color_p=imagecolorat($im,$i,$k))
			if($color_p>$color_w)
				imagesetpixel($im,$i,$k,$color_w);
			else
				imagesetpixel($im,$i,$k,$color_g);
}

imagepng($im);
imagedestroy($im);
?>
