<?php

function MyCalendar($setdate){
    # рисует календарь для выбора периода отчета
    $maxdate=date("Y-m-d");
    print " <form action=\"?newdate metod=\"GET\">
   <p>Інформація на дату: <input type=\"date\" name=\"calendar\" value=\"$setdate\" max=\"$maxdate\">
   <input type=\"submit\" value=\"Ок\"></p>
  </form>";
}

/**
 *  PrintInfoStandart($dt ) v.2 281217
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!!
 * 
 **/
function PrintInfoStandart($dt ){
    global $colorIn, $colorOut, $color3, $color4;
    $str="SELECT  SSP.NAME1,SSP.NAME2,SSP.NAME3, ST.S_DATE, ST.S_TIME, SS.DESCRIPTION, SMS.ID as SMSID, STP.ID as SPTID, SS.ID as SSID
      from SKUD_SPR_PEOPLE AS SSP , SKUD_TIME AS ST, SKUD_SENSOR AS SS, SKUD_TIP_PR AS STP, SKUD_MODE_SENSOR AS SMS
      Where SSP.ID=ST.ID_PEOPLE AND
      		ST.ID_SENSOR=SS.ID AND
            SS.ID_TIP=STP.ID AND
            SS.ID_MODE=SMS.ID AND
            ST.S_DATE='$dt'
      group by SSP.NAME1, ST.S_TIME";
    $result = mysql_query($str);
    print "\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    print "\n<tr align=\"center\" >
                <th colspan=\"4\"  align=\"center\">Співробітники страном на $dt</th>
             </tr>
    <tr><th width=\"20\" scope=\"col\">№</th align=\"center\"><th width=\"20\" scope=\"col\">Код</th><th width=\"70\" scope=\"col\">Час</th><th width=\"150\" scope=\"col\">Співробітник</th></tr>\n";
    $i=1;
    mb_internal_encoding("UTF-8");
    while($data = mysql_fetch_array($result)){ 
        if ($data['SMSID']==1){ 
            if ($data['SPTID']==1){ $bcol=$colorOut; }
            if ($data['SPTID']==2){ $bcol=$colorIn; }
        } 
        if ($data['SMSID']==2){ 
            if ($data['SPTID']==1){ $bcol=$color3; }
            if ($data['SPTID']==2){ $bcol=$color3; } #8AF5E8
        } 
        $IOmy = mb_substr($data['NAME2'], 0, 1) . "." . mb_substr($data['NAME3'], 0, 1).".";
        echo "<tr align=\"center\" bgcolor=\"$bcol\">\n";
        echo '<td  align="center">' . $i . "</td>\n";
        echo '<td >' . $data['SSID'] . "</td>\n";
        echo '<td >' . $data['S_TIME'] . "</td>\n";
        echo '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;' . $data['NAME1'] . " $IOmy</td>\n";
        echo "</tr>\n";
        $i++;
    }
    print "</table>\n";
}   

/**
 *  PrintInfoTime($dt ) v.2 281217
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!!
 * 
 **/
function PrintInfoTime($dt ){  
    global $colorIn, $colorOut, $color3, $color4;
    $str="SELECT  SSP.NAME1,SSP.NAME2,SSP.NAME3, ST.S_DATE, ST.S_TIME, SS.DESCRIPTION, SMS.ID as SMSID, STP.ID as SPTID, SS.ID as SSID
      from SKUD_SPR_PEOPLE AS SSP , SKUD_TIME AS ST, SKUD_SENSOR AS SS, SKUD_TIP_PR AS STP, SKUD_MODE_SENSOR AS SMS
      Where SSP.ID=ST.ID_PEOPLE AND
      		ST.ID_SENSOR=SS.ID AND
            SS.ID_TIP=STP.ID AND
            SS.ID_MODE=SMS.ID AND
            ST.S_DATE='$dt'
      group by ST.S_TIME, SSP.NAME1";
    $result = mysql_query($str);
    print "\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    print "\n<tr align=\"center\" >
                <th colspan=\"4\"  align=\"center\">Співробітники станом на $dt</th>
             </tr>
             <tr>
                <th width=\"20\" scope=\"col\">№</th>
                <th width=\"20\" scope=\"col\">Код</th>
                <th width=\"70\" scope=\"col\">Час</th>
                <th width=\"150\" scope=\"col\">Співробітник</th>
             </tr>\n";
    $i=1;
    mb_internal_encoding("UTF-8");
    while($data = mysql_fetch_array($result)){ 
        if ($data['SMSID']==1){ 
            if ($data['SPTID']==1){ $bcol=$colorOut; }
            if ($data['SPTID']==2){ $bcol=$colorIn; }
        } 
        if ($data['SMSID']==2){ 
            if ($data['SPTID']==1){ $bcol=$color3; }
            if ($data['SPTID']==2){ $bcol=$color3; } #8AF5E8
        } 
        $IOmy = mb_substr($data['NAME2'], 0, 1) . "." . mb_substr($data['NAME3'], 0, 1).".";
        echo "<tr align=\"center\" bgcolor=\"$bcol\">\n";
        echo '<td  align="center">' . $i . "</td>\n";
        echo '<td >' . $data['SSID'] . "</td>\n";
        echo '<td >' . $data['S_TIME'] . "</td>\n";
        echo '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;' . $data['NAME1'] . " $IOmy</td>\n";
        echo "</tr>\n";
        $i++;
    }
    print "</table>\n";
    
    
}   
/*
function GetKodMaxTime($tm,$id_kart){
    $str="SELECT ID_SOST FROM SKUD_TIME WHERE S_TIME='$tm' and ID_KART=$id_kart";
    $result = mysql_query($str);
    return mysql_result($result,0, 'ID_SOST');
}
*/
/**
 *  ShowZapiznenya($d1 ) v.2 301217
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!!
 **/
function ShowZapiznenya($d1){ 
    // показ опоздавших с 08:55 до 09:30
    $t1='07:59:00';
    $t2='08:30:00';
    $str="SELECT ST.S_TIME, ST.S_DATE, SSP.NAME1, SSP.NAME2, SSP.NAME3, SS.ID_TIP
          FROM  SKUD_TIME as ST, SKUD_SPR_PEOPLE as SSP, SKUD_SENSOR as SS
          WHERE ( (ST.S_DATE='$d1') and (ST.S_TIME BETWEEN '$t1' AND '$t2') ) and
		        SSP.ID=ST.ID_PEOPLE and
                ST.ID_SENSOR=SS.ID and
                SS.ID_MODE=1 and
                SS.ID_TIP=2
          GROUP BY SSP.ID
          ORDER BY ST.S_TIME";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
  if ($num_rows>0) {
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Запізнення з $t1 по $t2 -- $num_rows робітників </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['S_TIME'];
        //$id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        //$kodst = GetKodMaxTime($tm,$id_kart);
        $kodst = $data['ID_TIP'];     
        if ($kodst==2){$bcol='#90EE90'; $napr='Прихід в ';} else {$bcol='pink';$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
    }
    print "</table>";
  }  
}

/**
 *  ShowZapiznenyaObid($d1 ) v.2 301217
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!!
 **/
function ShowZapiznenyaObid($d1){
    // показ опоздавших с 08:55 до 09:30
    $t1='13:01:00';
    $t2='13:10:00';
   $str="SELECT ST.S_TIME, ST.S_DATE, SSP.NAME1, SSP.NAME2, SSP.NAME3, SS.ID_TIP
          FROM  SKUD_TIME as ST, SKUD_SPR_PEOPLE as SSP, SKUD_SENSOR as SS
          WHERE ( (ST.S_DATE='$d1') and (ST.S_TIME BETWEEN '$t1' AND '$t2') ) and
		        SSP.ID=ST.ID_PEOPLE and
                ST.ID_SENSOR=SS.ID and
                SS.ID_MODE=1 and
                SS.ID_TIP=2
          GROUP BY SSP.ID
          ORDER BY ST.S_TIME";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
  if ($num_rows>0) {
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Запізнення з обіда ($t1-$t2) -- $num_rows робітніков </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['S_TIME'];
        //$id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        //$kodst = GetKodMaxTime($tm,$id_kart);
        $kodst = $data['ID_TIP'];     
        if ($kodst==2){$bcol='#90EE90'; $napr='Прихід в ';} else {$bcol='pink';$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
    }
    print "</table>";
  }  
}

function FormAddList(){
    // рисует форму с выбором отделов
    $str='Select * From SKUD_OTDEL';
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    if ($num_rows>0){
        print "<li id=\"li_6\" >
		      <label class=\"description\" for=\"element_8\">Місце роботи </label>
		      <div>
		      <select class=\"element select medium\" id=\"element_8\" name=\"element_8\"> 
		      
        ";
        while($data = mysql_fetch_array($result)){ 
            //Собираем массив с нужными данными
            $id = $data['ID'];
            $name = $data['NAME'];
            print "<option value=\"$id\" >$name</option>";
        } //while
        print "</select>
		      </div> 
		      </li> ";
    } //if
}


function FormEditList($ID_OTDEL){
    // рисует форму с выбором отделов
    $str='Select * From SKUD_OTDEL';
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    if ($num_rows>0){
        print "<li id=\"li_6\" >
		      <label class=\"description\" for=\"element_8\">Міцео роботи </label>
		      <div>
		      <select class=\"element select medium\" id=\"element_8\" name=\"element_8\"> 
		      
        ";
        $sel = '';
        while($data = mysql_fetch_array($result)){ 
            //Собираем массив с нужными данными
            $id = $data['ID'];
            $name = $data['NAME'];
            if ($id==$ID_OTDEL) {$sel=' selected ';} else {$sel='';}
            print "<option $sel value=\"$id\" >$name</option>";
        } //while
        print "</select>
		      </div> 
		      </li> ";
    } //if
}

/**
 *  ShowSpeedTime($d1 ) v.2 301217
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!!
 **/
function ShowSpeedTime($d1){
    // показ досрочно ушедших с работы
    $t1='16:30:00';
    $t2='16:59:59';
    $date=explode("-", $d1);
    //$num = date("w", mktime(0, 0, 0, $date[1], $date[2], $date[0]));
    //if ($num==5) {$t1='16 :30:00'; $t2='16:59:00'; } // если пятница - сокращенній день
   $str="SELECT ST.S_TIME, ST.S_DATE, SSP.NAME1, SSP.NAME2, SSP.NAME3, SS.ID_TIP
          FROM  SKUD_TIME as ST, SKUD_SPR_PEOPLE as SSP, SKUD_SENSOR as SS
          WHERE ( (ST.S_DATE='$d1') and (ST.S_TIME BETWEEN '$t1' AND '$t2') ) and
		        SSP.ID=ST.ID_PEOPLE and
                ST.ID_SENSOR=SS.ID and
                SS.ID_MODE=1 and
                SS.ID_TIP=2
          GROUP BY SSP.ID
          ORDER BY ST.S_TIME";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
  if ($num_rows>0) {
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Достроковий вихід з роботи ($t1-$t2) -- $num_rows робітників </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        $tm = $data['S_TIME'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        $kodst = $data['ID_TIP'];     
        if ($kodst==2){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
    }
    print "</table>";
  }  
}


function PrintBossv2(){ /**  Выборка только регистрационного сенсора  **/
    global $colorIn, $colorOut, $color3, $color4;
    //print "Online Monitor<br>";
      /** узнать все номера из SKUD_SENSORS где SKUD_MODE_SENSOR = заданому типу $currsensor  ВХОД и ВЫХОД*/
            $str=" SELECT `S_TIME`, `S_DATE`, `ID_PEOPLE`, `NAME1`, `NAME2`, `NAME3`, `ID_TIP`, `DESCRIPTION` FROM(
                SELECT T1.S_TIME, T1.S_DATE, T1.ID_PEOPLE, T2.NAME1, T2.NAME2, T2.NAME3, SS.ID_TIP, SS.DESCRIPTION
                FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2, SKUD_SENSOR AS SS
                WHERE 
                T1.ID_PEOPLE=T2.ID AND
                T1.ID_SENSOR=SS.ID AND
		        T2.ID_OTDEL=30 AND
                SS.ID_MODE='1' ORDER BY T1.S_DATE DESC, T1.S_TIME DESC) AS TEMPP
            GROUP BY `ID_PEOPLE`
             ";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Керівництво</th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['S_TIME'];
        //$id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        //$kodst = $data['ID_SOST'];
        //$tdate = $data['S_DATE'];
        $dt=date("Y-m-d"); //$dt2=explode('-',$tdate);
        //$masmax = GetLastKod($id_kart);
        //$tdate=$masmax[1];  $dt2=explode('-',$tdate);
        $tdate=$data['S_DATE'];  $dt2=explode('-',$tdate);
        //$tm=$data['S_TIME'];
        //print "tdate=$tdate";
        //$kodst=$masmax[0];
        $kodst=$data['ID_TIP'];
        if ($tdate==$dt) {$pdt='';} else {$pdt=$dt2[2].'.'.$dt2[1].'.'.$dt2[0];}
        if ($kodst==2) {$bcol=$colorIn; $napr='Приход в ';} 
        if ($kodst==1) {$bcol=$colorOut;$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm." ".$pdt;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
    }
    print "</table>";
}



/*
function PrintOtdel($idotdel){
    //print "Online Monitor<br>";
    $str = "select  max(T1.ID), T1.S_TIME AS TM,T1.S_DATE, T1.ID_SOST, T1.ID_KART, T2.NAME1, T2.NAME2, T2.NAME3, T2.SORT
            FROM    SKUD_TIME AS T1, 
                    SKUD_SPR_PEOPLE AS T2,
                    SKUD_SENSOR AS SS,
                    SKUD_MODE_SENSOR AS SMS
            WHERE   T1.ID_KART=T2.ID_KART and 
                    T2.ID_OTDEL=$idotdel and
                    T1.ID_SENSOR=SS.ID and
                    SS.ID_MODE=SMS.ID and
                    SMS.ID=1
            GROUP BY ID_KART
            ORDER BY T2.SORT";
    //        print $str;
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку  
     
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">".GetNameOtdel($idotdel)."</th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['TM'];
        $id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        //$kodst = $data['ID_SOST'];
        //$tdate = $data['S_DATE'];
        $dt=date("Y-m-d"); //$dt2=explode('-',$tdate);
        $masmax = GetLastKod($id_kart);
        $tdate=$masmax[1];  $dt2=explode('-',$tdate);
        $tm=$masmax[2];
        //print "tdate=$tdate";
        $kodst=$masmax[0];
        if ($tdate==$dt) {$pdt='';} else {$pdt=$dt2[2].'.'.$dt2[1].'.'.$dt2[0];}
        if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm." ".$pdt;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
}
*/

/**
 *  PrintOtdel2($idotdel ) v.2 0301217
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!!
 **/
function PrintOtdel2($idotdel){
    //print "Online Monitor<br>";
    $str = "SELECT `S_TIME`, `S_DATE`, `ID_PEOPLE`, `NAME1`, `NAME2`, `NAME3`, `ID_TIP`, `DESCRIPTION` FROM(
                SELECT T1.S_TIME, T1.S_DATE, T1.ID_PEOPLE, T2.NAME1, T2.NAME2, T2.NAME3, SS.ID_TIP, SS.DESCRIPTION
                FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2, SKUD_SENSOR AS SS
                WHERE 
                T1.ID_PEOPLE=T2.ID AND
                T1.ID_SENSOR=SS.ID AND
		        T2.ID_OTDEL=$idotdel AND
                SS.ID_MODE='1' ORDER BY T1.S_DATE DESC, T1.S_TIME DESC) AS TEMPP
            GROUP BY `ID_PEOPLE`";
    //        print $str;
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку  
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">".GetNameOtdel($idotdel)."</th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //$id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        $dt=date("Y-m-d"); //$dt2=explode('-',$tdate);
        //$masmax = GetLastKod($id_kart);
        //$tdate=$masmax[1];  $dt2=explode('-',$tdate);
        $tdate=$data['S_DATE'];  $dt2=explode('-',$tdate);
        //$tm=$masmax[2];
        $tm=$data['S_TIME'];
        $kodst=$data['ID_TIP'];
        if ($tdate==$dt) {$pdt='';} else {$pdt=$dt2[2].'.'.$dt2[1].'.'.$dt2[0];}
        if ($kodst==2){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm." ".$pdt;
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
    }
    print "</table>";
}




function GetNameOtdel($idotdel){
    $str = "SELECT * FROM `SKUD_OTDEL` WHERE ID=$idotdel";
    $result = mysql_query($str);
    $dt = mysql_result($result,0, 'NAME');
    return $dt;
}
/*
function PrintOnlineMonitor($d1){
    //print "Online Monitor<br>";
    $str = "select  max(T1.S_TIME) AS TM, T1.ID_KART, T2.NAME1, T2.NAME2, T2.NAME3, T2.ID_OTDEL
            FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2
            WHERE S_DATE='$d1' and T1.ID_KART=T2.ID_KART and T2.ID_OTDEL!=30
            GROUP BY ID_KART";
    $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Online Monitor - Зареєстровано $num_rows робітників </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['TM'];
        $id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        $kodst = GetKodMaxTime($tm,$id_kart);
        
        if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
}
*/



/**
 *  PrintOnlineMonitor2($d1 ) v.2 301217
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!!
 **//*
function PrintOnlineMonitor2($d1){
    //print "Online Monitor<br>";
    //  Нужно доделать выборку с правильным показом SS.ID_TIP !!!!  
    $str = "select max(T1.S_TIME) AS TM, T1.ID_KART, T2.NAME1, T2.NAME2, T2.NAME3, T2.ID_OTDEL 
            FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2, SKUD_SENSOR as SS
            WHERE 	S_DATE='$d1' and 
                T1.ID_KART=T2.ID_KART and 	
                T2.ID_OTDEL!=30 and 
                SS.ID=T1.ID_SENSOR and
                SS.ID_MODE=1
            GROUP BY ID_KART";
    $result = mysql_query($str);
    $j=0; $newAR=' AND ('; $prestr='';
    while($data2 = mysql_fetch_array($result)){
            if ($j>0) { $prestr='OR';}
            $newAR .= $prestr." ST.S_TIME='".$data2['TM'].'\' ';
            $j++;
    }
    $newAR .= ")";  
    $str2="Select * 
            FROM SKUD_TIME as ST, SKUD_SENSOR SS
            WHERE   ST.S_DATE='$d1' and
                    ST.ID_SENSOR=SS.ID 
                    $newAR
            ";
    //print "$str";
    $result2 = mysql_query($str2);
    while($data3 = mysql_fetch_array($result2)){ // врем решение за 2 селекта выбрать ади тип
        $idk = $data3['ID_KART'];
        $dbIdTip[$idk]=$data3['ID_TIP'];
    }   
    $num_rows = mysql_num_rows($result);
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Online Monitor2 - Зареєстровано $num_rows робітників </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    $result = mysql_query($str); 
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        $tm = $data['TM'];
        $id_krt = $data['ID_KART'];
        //$id_zap = $data['ID'];  // временная мера - необходимо доделать правильно віборку
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        //$kodst = GetIdTipSensor($id_zap);
        $kodst = $dbIdTip[$id_krt];
        if ($kodst==2){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Вихід в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
    }
    print "</table>";
}
*/

/**
 *  PrintOnlineMonitor3($d1 ) v.2 030117
 * Переделанная  под  вторую версию. Первая уже неподдерживается!!!!! 
 * РАБОТАЕТ ЧЕРЕЗ 1 ЗАПРОС !!!!
 **/
function PrintOnlineMonitor3($d1){
    $str = "SELECT `S_TIME`, `S_DATE`, `ID_PEOPLE`, `NAME1`, `NAME2`, `NAME3`, `ID_TIP`, `DESCRIPTION` FROM(
                SELECT T1.S_TIME, T1.S_DATE, T1.ID_PEOPLE, T2.NAME1, T2.NAME2, T2.NAME3, SS.ID_TIP, SS.DESCRIPTION
                FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2, SKUD_SENSOR AS SS
                WHERE 
                T1.ID_PEOPLE=T2.ID AND
                T1.S_DATE='$d1' AND
                T1.ID_SENSOR=SS.ID AND
		        T2.ID_OTDEL!=30 AND
                SS.ID_MODE='1' ORDER BY T1.S_DATE DESC, T1.S_TIME DESC) AS TEMPP
            GROUP BY `ID_PEOPLE`";
    $result = mysql_query($str);
    $num_rows = mysql_num_rows($result);
    if ($num_rows>0) {
        // Рисуем таблицу
        $countTable=$num_rows;
        $colvo_td=6; // количество ячеек в таблице
        $colvo_tr=intval($countTable/$colvo_td);
        $ostatok=$countTable % $colvo_td;
        if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
        print "<table cellspacing=\"2\" >
        <tr>
            <th colspan=\"$colvo_td\">Online Monitor2 - Зареєстровано $num_rows робітників </th>
        </tr>";
        mb_internal_encoding("UTF-8");
        $ctd=0; //текущее значение колво TD
        $result = mysql_query($str); 
        while($data = mysql_fetch_array($result)){ 
            //Собираем массив с нужными данными
            $tm = $data['S_TIME'];
            //$id_krt = $data['ID_KART'];
            //$id_zap = $data['ID'];  // временная мера - необходимо доделать правильно віборку
            $name1 = $data['NAME1'];
            $name2 = mb_substr($data['NAME2'], 0, 1);
            $name3 = mb_substr($data['NAME3'], 0, 1);
            //$kodst = GetIdTipSensor($id_zap);
            $kodst = $data['ID_TIP'];;
            if ($kodst==2){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Вихід в ';}
            $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." \n$napr ".$tm;
            //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
            if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
            $ctd++;
            print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
            if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        }
        print "</table>";
    }
}


function PrintNotEntered($dt){
    //вывод сотрудников не пришедших на роботу
    $str="SELECT u.ID_KART, u.NAME1, u.NAME2, u.NAME3
            FROM SKUD_SPR_PEOPLE u
            WHERE u.ID_KART not in (SELECT t.ID_KART FROM SKUD_TIME t WHERE t.S_DATE='$dt')";
        $result = mysql_query($str); 
    $num_rows = mysql_num_rows($result);
    //print "Зарегистрировано $num_rows работников";
    // Рисуем таблицу
    $countTable=$num_rows;
    $colvo_td=6; // количество ячеек в таблице
    $colvo_tr=intval($countTable/$colvo_td);
    $ostatok=$countTable % $colvo_td;
    if ($ostatok<>0){ $colvo_tr=$colvo_tr+1;} // если не целое число добавляем дополнительную строку   
    print "<table cellspacing=\"2\" >
    <tr>
        <th colspan=\"$colvo_td\">Не пришло $num_rows робітників </th>
    </tr>";
    mb_internal_encoding("UTF-8");
    $ctd=0; //текущее значение колво TD
    while($data = mysql_fetch_array($result)){ 
        //Собираем массив с нужными данными
        //$tm = $data['TM'];
        //$id_kart = $data['ID_KART'];
        $name1 = $data['NAME1'];
        $name2 = mb_substr($data['NAME2'], 0, 1);
        $name3 = mb_substr($data['NAME3'], 0, 1);
        //$kodst = GetKodMaxTime($tm,$id_kart);
        $bcol='#DCDCDC';
        //if ($kodst==1){$bcol='#90EE90'; $napr='Приход в ';} else {$bcol='pink';$napr='Уход в ';}
        $tittletd="$name1 ".$data['NAME2']." ".$data['NAME3']." ";
        //print $tm." ".$id_kart." ".$name1." ".$name2." ".$name3." ".$kodst."<br>";
        if ($ctd==0){ print "<tr align=\"center\">";} //новая строка
        $ctd++;
        print "<td  bgcolor=\"$bcol\" TITLE='$tittletd'> $name1 $name2$name3 </td>";
        if ($ctd==$colvo_td){ $ctd=0; print "</tr>";}
        //print "ctd=".$ctd;
        
    }
    //print "</td></tr>";
    print "</table>";
}



/**
 *  Используется index.php
 **/
function GetCountIDKart($id ){
    $str="SELECT COUNT(*) FROM SKUD_SPR_PEOPLE 	WHERE ID_KART=$id";
    $result = mysql_query($str);
    //print "$str";
    return mysql_result($result,0, 'COUNT(*)');
}   
  
 
function GetCountLastKod($id){
    #Получение последнего кода состояния
    $dt=date("Y-m-d");
    $str="SELECT ID_SOST FROM SKUD_TIME WHERE ID_KART=$id and S_DATE='$dt' ORDER BY ID desc LIMIT 1";
    //print"$str";
    $result = mysql_query($str);
    return mysql_result($result,0, 'ID_SOST');
    //$data = mysql_fetch_array($result);
    //print "return=".mysql_result($result,0, 'ID_SOST');
}

function GetLastKod($id){
    #Получение последнего кода состояния с датой и временнем
    //$dt=date("Y-m-d");
    $str="SELECT ID_SOST, S_DATE, S_TIME FROM SKUD_TIME WHERE ID_KART=$id ORDER BY ID desc LIMIT 1";
    //print"$str";
    $result = mysql_query($str);
    $dt[0] = mysql_result($result,0, 'ID_SOST');
    $dt[1] = mysql_result($result,0, 'S_DATE');
    $dt[2] = mysql_result($result,0, 'S_TIME');
    //return mysql_result($result,0, 'ID_SOST');
    
    return $dt; //$data = mysql_fetch_array($result);
    //print "return=".mysql_result($result,0, 'ID_SOST');
}
 function GetLastKodAdvv1($id,$currsensor){   //05122017 v 2.0
    /** Получение последней записи состояния по номету карты и типу датчика (регистрационный или проходной)
        запрос с вложенным подзапросом принадлежности 
        1.  узнать все номера из SKUD_SENSORS где SKUD_MODE_SENSOR = заданому типу $currsensor
        */
        
     $str="SELECT *
            FROM   SKUD_TIME as ST, 
	               SKUD_SPR_PEOPLE as SSP,  
                   SKUD_SENSOR as SS
            WHERE  ST.ID_PEOPLE=SSP.ID and
		           SSP.ID_KART='$id' and
                   SS.ID=ST.ID_SENSOR and 
                   SS.ID_MODE=$currsensor
                   ORDER BY ST.ID DESC
                   Limit 1";
        
     //$str="SELECT * FROM SKUD_SENSOR, SKUD_MODE_SENSOR WHERE SKUD_MODE_SENSOR.ID=SKUD_SENSOR.ID_MODE AND 
     //                                                       SKUD_MODE_SENSOR.ID=$currsensor"; 
     //print "$str \n </br>";  
     $i=0;
     $result = mysql_query($str);
     while($data = mysql_fetch_array($result)){
            $skods[$i] = $data['ID_NOMER'];  // массив с трехзначным стрингом
            $intkods[$i] = (int) $skods[$i]; // тотже массив с переведенными в инт
            $i++;
     }
     
     $arr_kods = '\'' . implode ( "','", $intkods ) . '\''; //разбиваем массив с одинарными ковычками и запятой + ставим эти кавычки
     /** 2. Узнаем из SKUD_TIME последнее значение входящее в предыдущий массив     */
     $str="SELECT * FROM SKUD_TIME WHERE SKUD_TIME.ID_SOST IN ($arr_kods)
                    ORDER BY SKUD_TIME.ID desc LIMIT 1"; 
     $result = mysql_query($str);
     $lkod  = mysql_result($result,0, 'ID_SOST');  // lastkod
     
     /** 3. Переводим в СТР и ищем тип для следующего сравнения  */
     $lkodstr = KodtoStr($lkod);
     $str="SELECT * FROM SKUD_SENSOR WHERE SKUD_SENSOR.ID_NOMER=$lkodstr"; 
     $result = mysql_query($str);
     $kodtip  = mysql_result($result,0, 'ID_TIP');  // lastkod
     return $kodtip; //возв код типа приемника из табл SKUD_SENSOR
}

 function GetLastKodAdv($id,$currsensor){   //05122017 v 2.0
    /** Получение последней записи состояния по номету карты и типу датчика (регистрационный или проходной)
        запрос с вложенным подзапросом принадлежности 
        1.  узнать все номера из SKUD_SENSORS где SKUD_MODE_SENSOR = заданому типу $currsensor
        */
        
     $str="SELECT *
            FROM   SKUD_TIME as ST, 
	               SKUD_SPR_PEOPLE as SSP,  
                   SKUD_SENSOR as SS
            WHERE  ST.ID_PEOPLE=SSP.ID and
		           SSP.ID_KART='$id' and
                   SS.ID=ST.ID_SENSOR and 
                   SS.ID_MODE=$currsensor
                   ORDER BY ST.ID DESC
                   Limit 1";
     //print       $str;       
     $result = mysql_query($str);
     $kodtip  = mysql_result($result,0, 'ID_TIP');  // lastkod
     return $kodtip; //возв код типа приемника из табл SKUD_SENSOR
}



/*
function AddTimeKart($id,$sost){
    # записываем в базу движение карточки
    # Если  в базе есть последняя запись с такимже статусом - не заносить в базу и вернуть код ответа 2
    if ($sost!=GetCountLastKod($id)){
        $dt=date("Y-m-d");
        $tm=date("H:i:s");
        $query="INSERT INTO SKUD_TIME (ID_KART,ID_SOST, S_DATE, S_TIME)
            VALUES ('".$id."',
                    ".$sost.",
                    '".$dt."',
                    '".$tm."')";
                   // print $query;
        $result = mysql_query($query);
        if (mysql_affected_rows()<>1):
            if (mysql_affected_rows()<1):
            // print "В таблищу операция небыло записсано. Свяжитесь с администратором!!!";
            else:
            // print "Слишком много возврата. Свяжитесь с администратором!!!";
            endif;
        else:
         //print "Записано записей: ".mysql_affected_rows();
        endif;
        //print "1"; // действие разрешено
        print "@@1"; // действие разрешено
        $file=fopen("post.txt","w");
        //fwrite($file,print_r($_GET, 1));
        fwrite($file,"$id,$sost");
        fclose($file);

    } else {
        ## kod равен предыдущему значит повторное действие недопустимое
        ##  вернем код 3 - значи что попытка войти или выйти повторно
        //print "2"; // блокировка действия
        print "@@2"; // блокировка действия
        $file=fopen("post.txt","w");
        //fwrite($file,print_r($_GET, 1));
        fwrite($file,"$id,3");
        fclose($file);
    }
}*/

/**
 * function GetCurrentSensor($id)
 *    Возвращает информацию по текущему сенсору  :
 *    код типа сенсора mode[0]
 *    1- реєстраційинй
 *    2- прохідний
 *    код типа прохода mode[1]
 *    1- Вихід
 *    2- Вхід
 */
function GetCurrentSensor($id){  /** id -номер датчика      */
    
    $str="SELECT SS.ID,SS.ID_NOMER,SS.ID_TIP,SS.ID_MODE   
            FROM SKUD_SENSOR as SS, 
                 SKUD_MODE_SENSOR as SM, 
                 SKUD_TIP_PR as ST 
            WHERE   SS.ID_MODE=SM.ID  and 
                    SS.ID_TIP=ST.ID  and 
                    SS.ID_NOMER=$id ";
            //print $str;
    $result = mysql_query($str);
    $mode[0] = mysql_result($result,0, 'ID_MODE'); //регистрация-1 или проходной-2
    $mode[1] = mysql_result($result,0, 'ID_TIP');  // 2-вход или 1-выход 
    return $mode;
}

/**
 *    Возвращает :
 */
 /*
function GetPreSensor($id){
   $lastkod=GetCountLastKod(id); // последний код в системе
    $prekod=                             // код   
    $str="SELECT * FROM SKUD_SENSOR WHERE ID_NOMER=$id ";
    $result = mysql_query($str);
    $mode[0] = mysql_result($result,0, 'ID_MODE');
    $mode[1] = mysql_result($result,0, 'ID_TIP');
    return $mode;
}*/
function KodtoStr($i){
    /** Преобразование кода из базы (хранит в инт число) в трехзначное текстовое (добавляються нули)  */
    if ( strlen($i)==1 ) $str="00".$i;
    if ( strlen($i)==2 ) $str="0".$i;
    if ( strlen($i)==3 ) $str=$i;
    return $str;
}



// Вторая версия добавления записей и управление турникетом  07122017
function AddTimeKartV_2($id,$sost){
    # $sost - код приемника
    # записываем в базу движение карточки
    # Если  в базе есть последняя запись с такимже статусом - не заносить в базу и вернуть код ответа 2
    # функция определения типа приемника (Проходной или регистрационный))
    # если регистрационный
    /** $currentsensor массив из 2 */
    $currentsensor=GetCurrentSensor($sost);  // узнаем из какого приемника регист или проходной
    print "currentsensor="; print_r($currentsensor); print " \n </br>";
    
    /** $presensor массив из 5 позиций  */
    $presensor=GetLastKodAdv($id,$currentsensor[0]); // узнаем на каком  сенсоре регистрационном последняя регистрация была
    print "<br>presensor=$presensor \n </br> presensor($id,$currentsensor[0])";
    /** Если регистрационный сенсор и последний регистрационный != текущему  */
    
    if ($currentsensor[0]==1){// Реєстраційний сенсор  если с регистрационного и сейчас регистрация != прошлой регистрации
            // проверяем не повторный ли вход/выход
            print "First IF <br>";
            if ($currentsensor[1] <> $presensor ){  // если неповторная регистрация заносим в базу
                    print "Second IF <br>";
                    RecordKardv2($id,$sost);      // add to base
                    print "<br>ADD to Base!!!";
                    
            }
    }  else {
    
        /** Если проходной сенсор и последний регистрационный активный по входу разрешаем  */
        if ($currentsensor[0]==2) {
                print " <br> Prohodnoy IF 1<br>";
                /** Если последний регистрационный сенсор равен входу - можно проходить  */
                  if (  GetLastRegSensor($id)==2    ){
                        RecordKardv2($id,$sost);
                        print("<br>ADD to Base PROXODNOY!!!");
             } else{
                /** попытка прохода через терникет без регистрации входа */
                        //RecordERROR($id,$sost);// ничего не делать - повторный вход/выход запрещен!!!!
             }    
        }
    }
}

/**  Возврат последнего регистрационного состояния по карточке */
function GetLastRegSensorv1($sost){  // v2 07122017
    /**  Ищем все входные регистрационные серсоры  */
     $str="SELECT * FROM SKUD_SENSOR, SKUD_MODE_SENSOR WHERE SKUD_MODE_SENSOR.ID=SKUD_SENSOR.ID_MODE AND 
                                                            SKUD_MODE_SENSOR.ID=1 ";   
     //print "$str \n </br>";
     $i=0;
     $result = mysql_query($str);
     while($data = mysql_fetch_array($result)){
            $skods[$i] = $data['ID_NOMER'];  // массив с трехзначным стрингом
            $intkods[$i] = (int) $skods[$i]; // тотже массив с переведенными в инт
            $i++;
     }
     $arr_kods = '\'' . implode ( "','", $intkods ) . '\''; //разбиваем массив с одинарными ковычками и запятой + ставим эти кавычки
    /** 2. Узнаем из SKUD_TIME последнее значение входящее в предыдущий массив по указанное карте   */
     $str="SELECT * FROM SKUD_TIME WHERE SKUD_TIME.ID_SOST IN ($arr_kods) AND SKUD_TIME.ID_KART=$sost
                    ORDER BY SKUD_TIME.ID desc LIMIT 1"; 
     //print "$str \n </br>";
     $result = mysql_query($str);
     $lkod  = mysql_result($result,0, 'ID_SOST');  // lastkod $lkod=2 int!!! номер сенсора/приемника
     /** 3. Узнаем тип приемника ID_TIP 1-выход 2-вход  */
     $lkodstr = KodtoStr($lkod);
     $str="SELECT * FROM SKUD_SENSOR WHERE ID_TIP=$lkodstr AND ID_MODE=1";
     $result = mysql_query($str);
     $idtip  = mysql_result($result,0, 'ID_TIP');  // idtip=2 int!!! регистрационный вход
     return  $idtip;  
}


/**
 *   Работает только на второй версии !!!
 *   Возврат последнего регистрационного состояния по карточке v2 03012017
*/
function GetLastRegSensor($sost){  // v2 03012017
     $str="SELECT SS.ID_TIP FROM SKUD_TIME as ST, SKUD_SPR_PEOPLE as SSP, SKUD_SENSOR as SS 
            WHERE   ST.ID_PEOPLE=SSP.ID and 
                    SSP.ID_KART='$sost' and 
                    SS.ID=ST.ID_SENSOR and 
                    SS.ID_MODE=1 
            ORDER BY ST.ID DESC Limit 1";  
     $result = mysql_query($str);
     $idtip  = mysql_result($result,0, 'ID_TIP');  // idtip=2 int!!! регистрационный вход
     return  $idtip;  
}



function RecordERROR($id,$sost){
        ##  вернем код 3 - значи что попытка войти или выйти повторно
        print "@@2"; // блокировка действия
        $file=fopen("post.txt","w");
        //fwrite($file,print_r($_GET, 1));
        fwrite($file,"$id,3");
        fclose($file);
        //print "RecordERROR";
    }


function TimerProhoda($id,$sost){
        $timestamp = time();
        $dt=date("Y-m-d");
        $tm=date("H:i:s");
        /** делаю задержку для проходных серсоров, чтобы не отправляли пачкой регистрации  */
        $query="SELECT ST.S_DATE, ST.S_TIME, SSP.ID
                FROM   SKUD_SENSOR SS, 
	                   SKUD_TIME ST, 
                       SKUD_SPR_PEOPLE SSP 
                WHERE  ST.ID_SENSOR=SS.ID AND 
		               SSP.ID=ST.ID_PEOPLE AND
		               SSP.ID_KART=$id AND
                       SS.ID_NOMER=$sost  
                ORDER BY ST.ID
                desc LIMIT 1";                                                                       
        $result = mysql_query($query);
        $dtime  = mysql_result($result,0, 'S_TIME');  
        $ddate  = mysql_result($result,0, 'S_DATE');  
        $dID  = mysql_result($result,0, 'ID');  
        $dtime=explode(":",$dtime);
        $ddate=explode("-",$ddate);
        $timestamp2 = mktime($dtime[0],$dtime[1],$dtime[2],$ddate[1],$ddate[2],$ddate[0]);
        $reztime=$timestamp-$timestamp2;
        //print"timestamp=$timestamp, timestamp2=$timestamp2, reztime=$reztime";
        //exit;
        if ($reztime>4){ return 1;} else {return 0;}
   
    
}


function RecordKardv2($id,$sost){
    //    print "<br>-- RUN RecordKardv2 --<br>";
        $timestamp = time();
        $dt=date("Y-m-d");
        $tm=date("H:i:s");
        /** делаю задержку для проходных серсоров, чтобы не отправляли пачкой регистрации  */
        $query="SELECT ST.S_DATE, ST.S_TIME, SSP.ID
                FROM   SKUD_SENSOR SS, 
	                   SKUD_TIME ST, 
                       SKUD_SPR_PEOPLE SSP 
                WHERE  ST.ID_SENSOR=SS.ID AND 
		               SSP.ID=ST.ID_PEOPLE AND
		               SSP.ID_KART=$id AND
                       SS.ID_NOMER=$sost  
                ORDER BY ST.ID
                desc LIMIT 1";  
     //    print "$query";                                                                 
        $result = mysql_query($query);
        $dtime  = mysql_result($result,0, 'S_TIME');  
        $ddate  = mysql_result($result,0, 'S_DATE');  
        $dID  = mysql_result($result,0, 'ID');  
        $dtime=explode(":",$dtime);
        $ddate=explode("-",$ddate);
        $timestamp2 = mktime($dtime[0],$dtime[1],$dtime[2],$ddate[1],$ddate[2],$ddate[0]);
        $reztime=$timestamp-$timestamp2;
        //print"timestamp=$timestamp, timestamp2=$timestamp2, reztime=$reztime";
        //exit;
        if ($reztime<4){ exit;}
        /** Ищем ID в табл SKUD_SENSOR  */
        $query="SELECT ID FROM SKUD_SENSOR WHERE ID_NOMER=$sost";
        $result = mysql_query($query);
        $idsensor  = mysql_result($result,0, 'ID'); 
      //  print "<br> idsensor=$idsensor <br>"; 
        
        $query="INSERT INTO SKUD_TIME (ID_PEOPLE, S_DATE, S_TIME, ID_SENSOR)
            VALUES (
                    '".$dID."',
                    '".$dt."',
                    '".$tm."',
                    '".$idsensor."')";
                   // print $query;
      //  print "<br> $query <br>";
        $result = mysql_query($query);
      //  print "Insert=".mysql_affected_rows();
                      print "@@1"; // действие разрешено
                $file=fopen("post.txt","w");
                //fwrite($file,print_r($_GET, 1));
                fwrite($file,"$id,$sost");
                //fwrite($file, "$err");  //отладка
                fclose($file);
/*
        if (mysql_affected_rows()==1){
                print "@@1"; // действие разрешено
                $file=fopen("post.txt","w");
                //fwrite($file,print_r($_GET, 1));
                fwrite($file,"$id,$sost");
                //fwrite($file, "$err");  //отладка
                fclose($file);
        }*/
}    
    
    
// Вторая версия добавления записей и управление турникетом  07122017
function AddTimeKartV2($id,$sost){ // id-номер карты  sost-номера серсора 001
    $karta=$id;
    $dt=date("Y-m-d");
    $tm=date("H:i:s");
    $pre_kodtip=0;
    $cur_tip=0;
    
    
 //   print "id=$id <br> sost=$sost <br>";
    # Узнаем из какого приемника пришел запрос
    $str="SELECT SS.ID,SS.ID_NOMER,SS.ID_TIP,SS.ID_MODE   
            FROM SKUD_SENSOR as SS, 
                 SKUD_MODE_SENSOR as SM, 
                 SKUD_TIP_PR as ST 
            WHERE   SS.ID_MODE=SM.ID  and 
                    SS.ID_TIP=ST.ID  and 
                    SS.ID_NOMER='$sost' ";
   //         print $str;
    $result = mysql_query($str);
    $cur_id = mysql_result($result,0, 'ID'); //ID записи
    $cur_mode = mysql_result($result,0, 'ID_MODE'); //регистрация-1 или проходной-2
    $cur_tip = mysql_result($result,0, 'ID_TIP');  // 2-вход или 1-выход 
   // print "<br>cur_mode=$cur_mode<br>cur_tip=$cur_tip <br>";
    ##################################################################################
    #Узнаем сенсор последней регистрации
     $str="SELECT *
            FROM   SKUD_TIME as ST, 
	               SKUD_SPR_PEOPLE as SSP,  
                   SKUD_SENSOR as SS
            WHERE  ST.ID_PEOPLE=SSP.ID and
		           SSP.ID_KART='$id' and
                   SS.ID=ST.ID_SENSOR and 
                   SS.ID_MODE=$cur_mode
                   ORDER BY ST.ID DESC
                   Limit 1";
                   // SS.ID_MODE=$cur_mode
   //  print       $str;       
     $result = mysql_query($str);
     $pre_kodtip  = mysql_result($result,0, 'ID_TIP');  // lastkod
   //  print "<br>pre_kodtip=$pre_kodtip <br>";
    ##################################################################################
    # Последний регистрационный тип сенсора
     $str="SELECT SS.ID_TIP FROM SKUD_TIME as ST, SKUD_SPR_PEOPLE as SSP, SKUD_SENSOR as SS 
            WHERE   ST.ID_PEOPLE=SSP.ID and 
                    SSP.ID_KART='$id' and 
                    SS.ID=ST.ID_SENSOR and 
                    SS.ID_MODE=1 
            ORDER BY ST.ID DESC Limit 1";  
     $result = mysql_query($str);
     $lost_reg_tip  = mysql_result($result,0, 'ID_TIP');  // idtip=2 int!!! регистрационный вход
    // print "lost_reg_tip=$lost_reg_tip <br>";
    ##################################################################################
               $query="SELECT ST.S_DATE, ST.S_TIME, SSP.ID
                FROM   SKUD_SENSOR SS, 
	                   SKUD_TIME ST, 
                       SKUD_SPR_PEOPLE SSP 
                WHERE  ST.ID_SENSOR=SS.ID AND 
		               SSP.ID=ST.ID_PEOPLE AND
		               SSP.ID_KART='$id' AND
                       SS.ID_NOMER='$sost'  
                ORDER BY ST.ID
                desc LIMIT 1"; 
        //        print "$query";
                $result = mysql_query($query);
                $dtime  = mysql_result($result,0, 'S_TIME');  
                $ddate  = mysql_result($result,0, 'S_DATE');  
                $dID  = mysql_result($result,0, 'ID'); 
                       /** Ищем ID в табл SKUD_SENSOR  */
                $query="SELECT ID FROM SKUD_SENSOR WHERE ID_NOMER='$sost'";
                $result = mysql_query($query);
                $idsensor  = mysql_result($result,0, 'ID'); 
        //        print "<br> idsensor=$idsensor <br>"; 
                mysql_free_result($result);
    
    if ( ($cur_mode==1) and ($cur_tip<>$pre_kodtip)  ){
        

      //  print" <br>ZAP 1<br> ";
            #####################################################
        
        $query2="INSERT INTO SKUD_TIME (ID_PEOPLE, S_DATE, S_TIME, ID_SENSOR)
            VALUES (
                    '$dID',
                    '$dt',
                    '$tm',
                    '$idsensor')";
                   // print $query;
       // print "<br> $query2 <br>";
      //  sleep(5);
       $result2 = mysql_query($query2);
        
       // print "Insert=".mysql_affected_rows()."<br>";
        if (mysql_affected_rows()==1){
                print "@@1"; // действие разрешено
                $file=fopen("post.txt","w");
                //fwrite($file,print_r($_GET, 1));
                fwrite($file,"$id,$sost");
                //fwrite($file, "$err");  //отладка
                fclose($file);
        } 
  
         
         
      //   RecordKardv2($id,$sost);
         
        
    }
    
    if ( ($cur_mode==2) and ($lost_reg_tip==2) ){
       // print "<br>ZAP 2 <br>";
        RecordKardv2($id,$sost);
        
    }
}



// Третья версия добавления записей и управление турникетом  02.02.2018
function AddTimeKartV3($id,$sost){ // id-номер карты  sost-номера серсора 001
    $karta=$id;
    $dt=date("Y-m-d");
    $tm=date("H:i:s");
    $timestamp = time();
    $pre_tip_reg=0;
    $historyOff=0;
    //$pre_kodtip=0;
    //$cur_tip=0;
    
    /** Узнаем колличество серсоров     **/
    $str=" SELECT * FROM SKUD_SENSOR ";
    $result = mysql_query($str);
    $x=0;
    while ($x < mysql_num_rows($result)) {
        $aid = mysql_result($result,$x, 'ID');
        $aidnom = mysql_result($result,$x, 'ID_NOMER');
        $aidtip = mysql_result($result,$x, 'ID_TIP');   // 2-вход или 1-выход 
        $aidmode = mysql_result($result,$x, 'ID_MODE'); // регистрация-1 или проходной-2
        $array_sens[$aidnom]=array($aid,$aidnom,$aidtip,$aidmode);
        $sensorsall[$x]=$aid;
        if ( $aidnom == $sost){ $cur_tip = $aidtip; $cur_mode = $aidmode; $cur_ID_kart=$aid;} // забиваем информацией о текущем сенсоре
        $x++;
        
    }
    $countsens = $x;  // всего сенсоров в базе
    //print_r($sensorsall);
    //print "cur_tip=$cur_tip cur_mode=$cur_mode cur_ID_kart=$cur_ID_kart";
    //print_r($array_sens);
    
    /** заполняем массив по сенсорам последними данніми **/
    $str="
    SELECT  `S_DATE`, `S_TIME`, `ID_PEOPLE`, `NAME1`, `NAME2`, `NAME3`, `ID`, `ID_NOMER`, `ID_TIP`, `ID_MODE`, `DESCRIPTION` FROM(
    SELECT  T1.S_DATE, T1.S_TIME, T1.ID_PEOPLE, T2.NAME1, T2.NAME2, T2.NAME3, SS.ID, SS.ID_NOMER, SS.ID_TIP, SS.ID_MODE, SS.DESCRIPTION
    FROM SKUD_TIME AS T1, SKUD_SPR_PEOPLE AS T2, SKUD_SENSOR AS SS
        WHERE 
	   		T1.ID_PEOPLE=T2.ID AND
        	T2.ID_KART=$id AND
        	T1.ID_SENSOR=SS.ID ORDER BY T1.ID DESC ) AS TEMP 
    GROUP BY `ID`
    ORDER BY S_DATE DESC, S_TIME DESC
    ";
    $result = mysql_query($str);
    if ( mysql_num_rows($result)>0) { // есть история по карте
        $x=0; $idmoderunReg=0;$idmoderunTurn=0;
        while ($x < mysql_num_rows($result)) {  
           $aid = mysql_result($result,$x, 'ID');
           $aidnom = mysql_result($result,$x, 'ID_NOMER');
            $aidtip = mysql_result($result,$x, 'ID_TIP');
            $aidmode = mysql_result($result,$x, 'ID_MODE');
            $adate = mysql_result($result,$x, 'S_DATE');
            $atime = mysql_result($result,$x, 'S_TIME');
            $array_fihish_records[$aid]=array($aidnom,$aidtip,$aidmode,$adate,$atime);
            $idpeople = mysql_result($result,$x, 'ID_PEOPLE');
            // поиск последнего регистрационного датчика
            if ( ($aidmode==1) and ($idmoderunReg==0) ){
                $pre_tip_reg=$aidtip; // последний тип регистрационного сенсора
                $idmoderunReg=1;
            }
            // поиск последнего проходного датчика
            if ( ($aidmode==2) and ($idmoderunTurn==0) ){
                $ddate=$adate; 
                $dtime=$atime; 
                $idmoderunTurn=1;
            }
            
            $x++;
        }
        //print"<pre>";
        //print_r($array_fihish_records);
        //print"</pre>";
        //print"<pre>idpeople=$idpeople</pre>";
        $countfinishrecord = $x;  // сколько записей всего истории
    } else{ // история по карте отсутствует
        $historyOff=0; // истории нету - первый вход
    }
    
    /** приход с рестрационного датчика входа**/
    if ( ($cur_mode==1) /*and ($cur_tip==2)*/ ){  // c регистр входа 
        /**  текущий вход не равен предыдущему и пред есть в истории базы **/
        if ( ($cur_tip<>$pre_tip_reg)  ) { // если не повторный датчик 
            /** разрешаем проход  **/
            //print "GO!";
            RecordTimeKart($idpeople,$cur_ID_kart,$dt,$tm); // id-номер карты  sost-номера серсора 001 $idpeople-kod for table people
        }
    }
    
    /** приход с проходного датчика **/
    if ( ($cur_mode==2) /*and ($cur_tip==2)*/ ){  // c регистр входа 
        /**  и последний регистрационный = входу  **/
        if ( ($pre_tip_reg==2)  ) { // если не повторный датчик 
            /** разрешаем проход  **/
            //print "GO! Turniket";
            if ($idmoderunTurn==1){  // если есть история пред. прохода турникета
                $dtime=explode(":",$dtime);
                $ddate=explode("-",$ddate);
                $timestamp2 = mktime($dtime[0],$dtime[1],$dtime[2],$ddate[1],$ddate[2],$ddate[0]);
                $reztime=$timestamp-$timestamp2;
                if ($reztime<5){ exit;}
            }
            
            RecordTimeKart($idpeople,$cur_ID_kart,$dt,$tm);
        }
    }
    
    
/*    if ($historyOff==0) { // первая запись по карте - истории еще нету
        
    }*/
}
/** Запись в базу V2 020218  **/
function RecordTimeKart($idpeople,$cur_ID_kart,$dt,$tm){
    $str="INSERT INTO SKUD_TIME (ID_PEOPLE, S_DATE, S_TIME, ID_SENSOR)
            VALUES (
                    '$idpeople',
                    '$dt',
                    '$tm',
                    '$cur_ID_kart')";
    //print "<pre>$str</pre>";
    $result = mysql_query($str);
    if (mysql_affected_rows()==1){
           print "@@1"; // действие разрешено
           $file=fopen("post.txt","w");
           //fwrite($file,print_r($_GET, 1));
           fwrite($file,"$cur_ID_kart,$idpeople");
           //fwrite($file, "$err");  //отладка
           fclose($file);
    } 
}

function AddUSER($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8){
    # записываем в базу Нового пользователя
    //$dt=date("Y-m-d");
    //$tm=date("H:i:s");
    if ($p5==1) {$dostup=3;} 
    if ($p6==2) {$dostup=2;} 
    if ($p7==3) {$dostup=1;}
    
   $query="INSERT INTO SKUD_SPR_PEOPLE (ID_KART,NAME1,NAME2,NAME3,ID_OTDEL,LEVEL_ACCESS)
            VALUES (".$p1.",
                    '".$p2."',
                    '".$p3."',
                    '".$p4."',
                     ".$p8." ,
                    ".$dostup.")";
                  // print $query;
    $result = mysql_query($query);
    if (mysql_affected_rows()<>1):
        if (mysql_affected_rows()<1):
            // print "В таблищу операция небыло записсано. Свяжитесь с администратором!!!";
         else:
            // print "Слишком много возврата. Свяжитесь с администратором!!!";
         endif;
      else:
         //print "Записано записей: ".mysql_affected_rows();
      endif;
}

function EditUSER($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$idu){
    # записываем в базу Нового пользователя
    //$dt=date("Y-m-d");
    //$tm=date("H:i:s");
    if ($p5==1) {$dostup=3;} 
    if ($p6==2) {$dostup=2;} 
    if ($p7==3) {$dostup=1;}
    
   $query="UPDATE SKUD_SPR_PEOPLE 
            SET ID_KART = $p1 ,
                NAME1 = '$p2' ,
                NAME2 = '$p3' ,
                NAME3 = '$p4' ,
                ID_OTDEL = $p8 ,
                LEVEL_ACCESS= $dostup 
            WHERE ID=$idu
                    ";
   //print $query;
   $result = mysql_query($query);
  // mysql_query($query) or trigger_error(mysql_error()." in ".$query); 
   header("Location: admin.php"); 

                  // print $query;
  /*  $result = mysql_query($query);
    if (mysql_affected_rows()<>1):
        if (mysql_affected_rows()<1):
            // print "В таблищу операция небыло записсано. Свяжитесь с администратором!!!";
         else:
            // print "Слишком много возврата. Свяжитесь с администратором!!!";
         endif;
      else:
         //print "Записано записей: ".mysql_affected_rows();
      endif; */
}





  
function  DeleteUser($idd){
    #Удаление пользователя
     $query="DELETE FROM SKUD_SPR_PEOPLE WHERE ID=$idd";
                   //print $query;
    $result = mysql_query($query);
    
}
  
  
?>