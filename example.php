<?php
$connect = mysql_connect("localhost","root","");
$db = mysql_select_db("avtotim",$connect) or die(mysql_error());
require_once ('Excel/reader.php');
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('cp-1251');
$data->setUTFEncoder('mb');
$data->read('1.xls');
error_reporting(E_ALL);
for($j=3; $j<=$data->sheets[0]['numRows']; $j++) // Начинаем выводить данные начиная с третьей строки
{
for($i=0; $i<=$data->sheets[0]['numCols']; $i++) // Начинаем выводить данные для всех столбцов
{
if(empty($data->sheets[0]['cells'][$j][$i]))
{
$row[] = "'empty'"; // Создаём массив из значений столбцов для каждой строки
}
else
{
$row[] = "'".$data->sheets[0]['cells'][$j][$i]."'"; // Создаём массив из значений столбцов для каждой строки
}
}
	$row = implode(",", $row); // Объединяем массив в строку, для запроса mysql
	$sql = "INSERT INTO `xls`  VALUES ($row)"; // Создаём запрос mysql
	mysql_query("SET NAMES 'cp1251'"); // Устанавливаем кодировку для mysql
   if(!mysql_query($sql)) // Выполняем запрос mysql 
   {
   echo 'Error: '.mysql_error();
   }		
   else 
   {
   echo 'Add success!<br>';
   }
unset($row); // Удаляем переменную, чтоб массив со строкой не путался
}
?>