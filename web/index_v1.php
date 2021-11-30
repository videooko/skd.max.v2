<?php
/**
 * @author Leonid Boyko 
 * @copyright 2016
 * @version 1.0
 * @copyright videooko.net
 * 
 */

/**
 * Программа для принятия и обработки данных от системы контроля доступа Алексея Дрыгваля
 * 
 * 
 * 
 *  Приходят данніе в формате
 *  [kod] => 1                  код состояния 1-вход  2-выход
 *  [id] => 1174196573          код карточки уникальный
 *  [time] => 19:03:28          время удаленного устройства. Если прерывается связь - данные из буфера заносятся
 *                              с меткой времени удаленного устройства
 *
 *
 * 
 * 
 * 
 */

$id  = $_GET['id'];
$kod = $_GET['kod'];
$devtime = $_GET['time'];

ini_set("display_errors", "1");
date_default_timezone_set('Europe/Kiev');
$time1 = microtime(); //стоит в начале скрипта
session_start();        
//подключение доп файлов
include("./cfg/connect.inc.php");
include("./cfg/functions.inc.php");


#$query="SELECT * FROM skud.SKUD_SPR_PEOPLE;";
#$result = mysql_query($query,$conn);
//mysql_query=() 
//$result = mysql_query($query) or die("<p>Невозможно выполнить запрос к базе данных: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");


if ( !isset($_GET['id']) or !isset($_GET['kod']) ){
    # показ текущей информации )по входам и выходам
    print "<HTML>
<head>
  <meta charset=\"utf-8\">
  <title>SKUD 1.0</title>
</head>";
    $todate=date("Y-m-d");
    if (!isset($_GET['calendar'])) {$todate=date("Y-m-d");} else {$todate=$_GET['calendar'];}
    
    MyCalendar($todate);
    //print_r($_GET);
    print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tr align=\"center\"><td width=\"350\">";
    PrintInfoStandart($todate);
    print " </td><td width=\"350\">";
    
    PrintInfoTime($todate);
    print " </td></tr><table>";
    $time2 = microtime(); //стоит в конце скрипта
    // выводим в окно броузера $mtime - время генерации страницы.
    $mtime = abs ($time2 - $time1);
    print "Страница сгенерирована за ".$mtime." сек.";
    print "</html>";
    ## Если дата сегодня рисуем онлайн состояние
    
} else  {
    #заносим в базу данные
    
    if ( GetCountIDKart($id)==1 ){
        # вносим в базу
        #print "Add to DB";
        AddTimeKart($id,$kod);
        //print "1";
    } else{ 
        # пишем в файл
        $file=fopen("file.txt","a");
        fwrite($file,print_r($_GET, 1));
        fclose($file);
        print "0";
    }

}

/*
print "<table>";
while($data = mysql_fetch_array($result)){ 
    echo '<tr>';
    echo '<td>' . $data['ID_KART'] . '</td>';
    echo '<td>' . $data['NAME1'] . '</td>';
    echo '<td>' . $data['NAME2'] . '</td>';
    echo '<td>' . $data['NAME3'] . '</td>';
    echo '</tr>';
  }
print "</table>";
*/
/**
 * Если приходит номер которого нету в базе - пишем его в текстовый лог и в базу не вносим
 * Если приходит номер, который есть в базе - пишем данные в таблицу
 * 
 **/
 
 
 #### 1. Проверка наличия в базе номера.
 










?>