<?php
/**
 * @author Leonid Boyko 
 * @copyright 2017
 * @version 2.0
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
 *  [id] => 3686146223          код карточки уникальный Boyko
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
mb_internal_encoding("UTF-8");  //07122017
ini_set("display_errors", "1");
date_default_timezone_set('Europe/Kiev');
$time1 = microtime(); //стоит в начале скрипта
session_start();        
//подключение доп файлов
include("./cfg/connect.inc.php");
include("./cfg/cfg.inc.php");
include("./cfg/functions.inc.php");





        $file=fopen("file2.txt","a");
        fwrite($file,print_r($_GET, 1));
        fwrite($file,"$id,$kod");
        fclose($file);




#$query="SELECT * FROM skud.SKUD_SPR_PEOPLE;";
#$result = mysql_query($query,$conn);
//mysql_query=() 
//$result = mysql_query($query) or die("<p>Невозможно выполнить запрос к базе данных: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");


if ( !isset($_GET['id']) or !isset($_GET['kod']) ){
    # показ текущей информации )по входам и выходам
    $todate=date("Y-m-d");
    if (!isset($_GET['calendar'])) {$todate=date("Y-m-d"); $refr="<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"60\">";} else {$todate=$_GET['calendar'];$refr='';}

    print "<HTML>
            <head>
                <meta charset=\"utf-8\">
                <title>SKUD MAX v.2.0 Миколаїв ГУДСНС</title>
                <link rel=\"stylesheet\" type=\"text/css\" href=\"css/skd.css\">
                $refr
                <META NAME=\"Description\" lang=\"ua\" CONTENT=\"SKUD MAX v.2.0 Leonid Boyko\">
                <META NAME=\"Copyright\" CONTENT=\"Leonid Boyko\">
                <META NAME=\"Author\" lang=\"ua\" CONTENT=\"Леонід Бойко (Leonid Boyko), адрес электоронной почты: leonid.boyko@gmail.com\">

            </head>";
            
    
    MyCalendar($todate);
    //print_r($_GET);
    print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> 
            <tr align=\"center\">
                <td valign=\"top\" width=\"350\">";
                    PrintInfoStandart($todate);
       print " </td>
               <td valign=\"top\" width=\"350\">";
                    PrintInfoTime($todate);
       print " </td>
               <td valign=\"top\">";
                    PrintBossv2();print "<br>";
                    PrintOtdel2(27);print "<br>";
                    ShowZapiznenya($todate); print "<br>";
                    //PrintOnlineMonitor($todate); print "<br>";
                    //PrintOnlineMonitor2($todate); print "<br>";
                    PrintOnlineMonitor3($todate); print "<br>";
                    ShowZapiznenyaObid($todate); print "<br>";
                    ShowSpeedTime($todate); print "<br>";
                   // PrintNotEntered($todate);
       
       print " </td></tr>";
   print "<table>";

    $time2 = microtime(); //стоит в конце скрипта
    // выводим в окно броузера $mtime - время генерации страницы.
    $mtime = abs ($time2 - $time1);
    print "Сторінка згенерирована за ".$mtime." сек.";
    print "</html>";
    
    
} else  {
    #заносим в базу данные
    
/**
 * Если приходит номер которого нету в базе - пишем его в текстовый лог и в базу не вносим
 * Если приходит номер, который есть в базе - пишем данные в таблицу
 * 
 **/
    if ( GetCountIDKart($id)==1 ){
        # вносим в базу
        #print "Add to DB";
        #AddTimeKart($id,$kod); // первая версия
        
        AddTimeKartV3($id,$kod); // вторая версия
        #$file2=fopen("file3.txt","a");
        #fwrite($file2,print_r($_GET, 1));
        #fwrite($file2,"$id,$kod");
        #fclose($file2);
        //print "1";
    } else{ 
        # пишем в файл
        $file=fopen("file.txt","a");
        fwrite($file,print_r($_GET, 1));
        fclose($file);
        print "0";
    }

}


 
 
 #### 1. Проверка наличия в базе номера.
 








?>