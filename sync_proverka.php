<?php
  //ключи шифрования
  define ('C1', 52845); 
  define ('C2', 11719); 
  define ('KEY', 1674);

function EncryptString($s){
    $key=KEY;
    $result="";
    $ls="";
    for ($i=0;$i<strlen($s);$i++) {
        $ls=$ls.chr( ord(substr($s,$i,1)) ^ (($key -($key % 256))/256));
        $result=$result.bin2hex(pack("c", ord(substr($ls,$i,1))));
        $key=(((((ord(substr($ls,$i,1))+$key)&0xffff)*C1)&0xffff)+C2)&0xffff;
    }
    $result=KEY."f".C1."f".C2."f".$result;
    return $result;
}
function DecryptString($s){
    if (strlen($s)>0) {
        $key=substr($s,0,strpos($s,"f"));
        $s=substr($s,strpos($s,"f")+1,strlen($s)-strpos($s,"f"));
    }
    if (strlen($s)>0) {
        $c1=substr($s,0,strpos($s,"f"));
        $s=substr($s,strpos($s,"f")+1,strlen($s)-strpos($s,"f"));
    }
    if (strlen($s)>0) {
        $c2=substr($s,0,strpos($s,"f"));
        $s=substr($s,strpos($s,"f")+1,strlen($s)-strpos($s,"f"));
    }
    $result="";
    $ls="";
    for ($i=0;$i<strlen($s)/2;$i++) $ls=$ls.chr(hexdec(substr($s,($i*2),2)));
    for ($i=0;$i<strlen($ls);$i++) {
        $result=$result.chr(ord(substr($ls,$i,1)) ^ (($key -($key % 256))/256));
        $key=(((((ord(substr($ls,$i,1))+$key)&0xffff)*$c1)&0xffff)+$c2)&0xffff;
    }
    return $result;
} 

    $homepage=file_get_contents('http://avtotim/sync_begin.php?guid=000206A7-00100800-1FBAE3BF-BFEBFBFF&path=1674f52845f11719f6232B13F047CDACF79B4F638F472E34EFF24E0E998177FF59C877212E45295C9EFC6E34883068E08EB');
    //$homepage=file_get_contents('http://avtotim/sync_begin.php?guid=00100F43-00040800-00802009-178BFBFF');
    echo DecryptString($homepage);
?>