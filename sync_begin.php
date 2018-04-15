<?php
//olimp_n:ol456imp@olimpia-auto.com.ua/olimpiaauto
  $login="olimp_n";
  $passw="ol456imp";
  $host="olimpia-auto.com.ua";
  $database="olimpiaauto";
  
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

    mysql_connect($host,$login,$passw);
    @mysql_select_db($database) or die("Unable connect to database!");
        mysql_query ("set character_set_client='cp1251'");
        mysql_query ("set character_set_results='cp1251'");
        mysql_query ("set collation_connection='cp1251_general_ci'");
    
    if (isset($_GET["guid"])) $prog_guid=$_GET["guid"]; else unset($prog_guid);
    if (isset($_GET["path"])) $prog_path=$_GET["path"]; else unset($prog_path);
    
    if (isset($prog_guid)&&($prog_guid<>"")&&isset($prog_path)&&($prog_path<>"")) {
        $sql="select prog_base from organizations where (prog_guid='$prog_guid')and(prog_guid is not null)and(prog_guid<>'')and(prog_path='$prog_path')and(prog_path is not null)and(prog_path<>'')";
        $tb=mysql_query($sql);
        $tb_n=mysql_numrows($tb);
        if ($tb_n==1) print EncryptString("$login:$passw@$host/$database");
    }
?>