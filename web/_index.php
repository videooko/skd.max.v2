<?php
/**
 * @author Leonid Boyko 
 * @copyright 2016
 * @version 1.0
 * @copyright videooko.net
 * 
 */

/**
 * ��������� ��� �������� � ��������� ������ �� ������� �������� ������� ������� ��������
 * 
 * 
 * 
 *  �������� ����� � �������
 *  [kod] => 1                  ��� ��������� 1-����  2-�����
 *  [id] => 1174196573          ��� �������� ����������
 *  [time] => 19:03:28          ����� ���������� ����������. ���� ����������� ����� - ������ �� ������ ���������
 *                              � ������ ������� ���������� ����������
 *
 *
 * 
 * 
 * 
 */

#ini_set("display_errors", "0");
#date_default_timezone_set('Europe/Kiev');
#$time1 = microtime(); //����� � ������ �������
#session_start();        
//����������� ��� ������
#include("./cfg/connect.inc.php");





print_r($_GET);
$file=fopen("file.txt","a");
fwrite($file,print_r($_GET, 1));
fclose($file);

?>