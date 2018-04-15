 <?php

// Скрипт с сайта http://petrenco.com/php.php?txt=134

$serv_addr = 'www.avto-polit.ru';
$serv_port = 80;
$serv_page = 'index.php';
$timelimit = 2; // Время ожидания ответа в сек. По умолчанию - 30 сек.

// Передаваемые POST переменные в формате: название переменной => значение
$post_data = array('name' => 'fsockopen',
                   'plus' => 5,
                   'my_array[0]' => 0,
                   'my_array[1]' => 'var1',
                   'my_array[2]' => 'vars2',
                   'file' => 'zip');

// Генерируем строку с POST запросом
$post_data_text = '';
foreach ($post_data AS $key => $val)
  $post_data_text .= $key.'='.urlencode($val).'&';
 
// Убираем последний символ & из строки $post_data_text
$post_data_text = substr($post_data_text, 0, -1);
 
// Прописываем заголовки, для передачи на сервер
// Последний заголовок должен быть обязательно пустым,
// так как тело запросов отделяется от заголовков пустой строкой (символом перевода каретки "\r\n")
$headers = array('POST /'.$serv_page.' HTTP/1.1',
                 'Host: '.$serv_addr,
                 'Content-type: application/x-www-form-urlencoded',
                 'Content-length: '.strlen($post_data_text),
                 'Accept: */*',
                 'Connection: Close',
                 '');
                 
// Создание строки заголовков
$headers_txt = '';
foreach ($headers AS $val)
  {
  $headers_txt .= $val.chr(13).chr(10);
  }
 
// Создание общего запроса (заголовки и тело запроса)
// chr(13).chr(10) равно "\r\n" - перевод каретки
$request_body = $headers_txt.$post_data_text.chr(13).chr(10).chr(13).chr(10);

// Открытие сокета
$sp = fsockopen($serv_addr, $serv_port, $errno, $errstr, $timelimit);
 
if (!$sp)
  exit('Error: '.$errstr.' #'.$errno);

// Передача заголовков и POST запросов за один раз
fwrite($sp, $request_body);

$server_answer = '';

// Если соединение, открытое fsockopen() не было закрыто сервером
// код while(!feof($sp)) { ... } приведет к зависанию скрипта
// В коде ниже - эта проблема решена
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

// Запись ответа сервера в файл
// Если в ответе сервера будет только содержимое zip-файла
// файл test.zip - будет являться zip-архивом
$fp = fopen('test.zip', 'wb+');
fwrite($fp, $server_answer, strlen($server_answer));
fclose($fp);
?>