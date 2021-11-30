<?php

$intkods[0]=0;
$intkods[1]=1;
$intkods[2]=2;

 $str="SELECT * FROM SKUD_TIME WHERE SKUD_TIME.ID_SOST IN $intkods"; 
 
 //print "$str";
 
 
 $arr = array(5,6,7,8);
$arr_lists = '\'' . implode ( "','", $arr ) . '\''; //разбиваем массив с одинарными ковычками и запятой + ставим эти кавычки по краям
print"$arr_lists";
    




?>