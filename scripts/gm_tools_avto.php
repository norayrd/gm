<?php
	function tov_kod_clear($tov_kod){
        //возвращает очищенную строку как код товара
		$etalon='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/';
		$i=0;
		$s='';
		$tov_kod=strtoupper($tov_kod);
		$len=strlen($tov_kod);
		while ($i<$len) {
			$ss=substr($tov_kod,$i,1);
			if (substr_count($etalon,$ss)>0) {
				$s=$s.$ss;
			}
			$i++;
		}
		return $s;
	}
function XMail( $from, $to, $subj, $text, $filename) {
    $f         = fopen($filename,"rb");
    $un        = strtoupper(uniqid(time()));
    $head      = "From: $from\n";
    $head     .= "To: $to\n";
    $head     .= "Subject: $subj\n";
    $head     .= "X-Mailer: PHPMail Tool\n";
    $head     .= "Reply-To: $from\n";
    $head     .= "Mime-Version: 1.0\n";
    $head     .= "Content-Type:multipart/mixed;";
    $head     .= "boundary=\"----------".$un."\"\n\n";
    $zag       = "------------".$un."\nContent-Type:text/html;\n";
    $zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n";
    $zag      .= "------------".$un."\n";
    $zag      .= "Content-Type: application/octet-stream;";
    $zag      .= "name=\"".basename($filename)."\"\n";
    $zag      .= "Content-Transfer-Encoding:base64\n";
    $zag      .= "Content-Disposition:attachment;";
    $zag      .= "filename=\"".basename($filename)."\"\n\n";
    $zag      .= chunk_split(base64_encode(fread($f,filesize($filename))))."\n";
    
    return @mail("$to", "$subj", $zag, $head);
}
?>