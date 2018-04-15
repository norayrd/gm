 <?php

// ������ � ����� http://petrenco.com/php.php?txt=134

$serv_addr = 'www.avto-polit.ru';
$serv_port = 80;
$serv_page = 'index.php';
$timelimit = 2; // ����� �������� ������ � ���. �� ��������� - 30 ���.

// ������������ POST ���������� � �������: �������� ���������� => ��������
$post_data = array('name' => 'fsockopen',
                   'plus' => 5,
                   'my_array[0]' => 0,
                   'my_array[1]' => 'var1',
                   'my_array[2]' => 'vars2',
                   'file' => 'zip');

// ���������� ������ � POST ��������
$post_data_text = '';
foreach ($post_data AS $key => $val)
  $post_data_text .= $key.'='.urlencode($val).'&';
 
// ������� ��������� ������ & �� ������ $post_data_text
$post_data_text = substr($post_data_text, 0, -1);
 
// ����������� ���������, ��� �������� �� ������
// ��������� ��������� ������ ���� ����������� ������,
// ��� ��� ���� �������� ���������� �� ���������� ������ ������� (�������� �������� ������� "\r\n")
$headers = array('POST /'.$serv_page.' HTTP/1.1',
                 'Host: '.$serv_addr,
                 'Content-type: application/x-www-form-urlencoded',
                 'Content-length: '.strlen($post_data_text),
                 'Accept: */*',
                 'Connection: Close',
                 '');
                 
// �������� ������ ����������
$headers_txt = '';
foreach ($headers AS $val)
  {
  $headers_txt .= $val.chr(13).chr(10);
  }
 
// �������� ������ ������� (��������� � ���� �������)
// chr(13).chr(10) ����� "\r\n" - ������� �������
$request_body = $headers_txt.$post_data_text.chr(13).chr(10).chr(13).chr(10);

// �������� ������
$sp = fsockopen($serv_addr, $serv_port, $errno, $errstr, $timelimit);
 
if (!$sp)
  exit('Error: '.$errstr.' #'.$errno);

// �������� ���������� � POST �������� �� ���� ���
fwrite($sp, $request_body);

$server_answer = '';

// ���� ����������, �������� fsockopen() �� ���� ������� ��������
// ��� while(!feof($sp)) { ... } �������� � ��������� �������
// � ���� ���� - ��� �������� ������
$start = microtime(true);
$header_flag = 1;
while(!feof($sp) && (microtime(true) - $start) < $timelimit)
  {
  if ($header_flag == 1)
    {
    $content = fgets($sp, 4096);
    if ($content === chr(13).chr(10))
      $header_flag = 0;
    else
      $server_header .= $content;
    }
  else
    {
    $server_answer .= fread($sp, 4096);
    }
  }

fclose($sp);  
 
echo $server_header.chr(13).chr(10).chr(13).chr(10).chr(13).chr(10).$server_answer.' ';

// ������ ������ ������� � ����
// ���� � ������ ������� ����� ������ ���������� zip-�����
// ���� test.zip - ����� �������� zip-�������
$fp = fopen('test.zip', 'wb+');
fwrite($fp, $server_answer, strlen($server_answer));
fclose($fp);
?>