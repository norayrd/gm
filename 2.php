
<?php
// Соединение, выбор базы данных
$dbconn = pg_connect("host=db13.freehost.com.ua dbname=norayrbm_pgdb user=norayrbm password=gfgfljvf")
    or die('Could not connect: ' . pg_last_error());

// Выполнение SQL запроса
//pg_query("create table ttt (a integer, b varchar(255));");

pg_query("insert into ttt values (1, 'I am THE BEST.');");


$query = 'SELECT * FROM ttt';
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

// Вывод результатов в HTML
echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Очистка результата
pg_free_result($result);

// Закрытие соединения
pg_close($dbconn);
?>
