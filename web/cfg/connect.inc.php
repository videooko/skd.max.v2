<?php
	//database connection settings
	define('DB_HOST', 'localhost' ); // database host
	define('DB_USER', 'skud.mk.v2'      ); // username
	define('DB_PASS', 'skdv2'  ); // password
	define('DB_NAME', 'skud.mk.v2'      ); // database name
//	//database tables
//	include("./cfg/tables.inc.php");

// ������������ � �������
$conn = mysql_connect(DB_HOST, DB_NAME, DB_PASS) or die("<p>���������� ������������ � ����: " . mysql_error() . ". ������ ��������� � ������ " . __LINE__ . "</p>");
  // ��� ����� ���� ���������� ������ � ������ ��������� ����������� � �������
// �������� ���� ������
$db = mysql_select_db(DB_NAME, $conn) or die("<p>���������� ������������ � ���� ������: " . mysql_error() . ". ������ ��������� � ������ " . __LINE__ . "</p>");

        // ��� ����� ���� ����������� ������ � ������ ��������� ����������� � ��
// ��������� �������, ��� ������, ������� �� �� ���� ��������, ��� ����� � ��������� UTF-8
$query = mysql_query("set names utf8", $conn) or die("<p>���������� ��������� ������ � ���� ������: " . mysql_error() . ". ������ ��������� � ������ " . __LINE__ . "</p>");
    
?> 