<?php
/**
 * @author Leonid Boyko leonid.boyko@gmail.com  videooko.net
 * @copyright 2016
 * @version 1.0 01.01.2017
 * @copyright videooko.net
 * 
 * ����������� �������������
 **/
// �������� �����������



# ������� ��� ��������� ��������� ������

function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];  
    }

    return $code;

}



# ���������� � ��

mysql_connect("localhost", "myhost", "myhost");

mysql_select_db("testtable");


if(isset($_POST['submit']))

{

    # ����������� �� �� ������, � ������� ����� ���������� ����������

    $query = mysql_query("SELECT user_id, user_password FROM users WHERE user_login='".mysql_real_escape_string($_POST['login'])."' LIMIT 1");

    $data = mysql_fetch_assoc($query);

    

    # ���������� ������

    if($data['user_password'] === md5(md5($_POST['password'])))

    {

        # ���������� ��������� ����� � ������� ���

        $hash = md5(generateCode(10));

            

        if(!@$_POST['not_attach_ip'])

        {

            # ���� ������������ ������ �������� � IP

            # ��������� IP � ������

            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";

        }

        

        # ���������� � �� ����� ��� ����������� � IP

        mysql_query("UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        

        # ������ ����

        setcookie("id", $data['user_id'], time()+60*60*24*30);

        setcookie("hash", $hash, time()+60*60*24*30);

        

        # ���������������� ������� �� �������� �������� ������ �������

        header("Location: check.php"); exit();

    }

    else

    {

        print "�� ����� ������������ �����/������";

    }

}

?>

<form method="POST">

����� <input name="login" type="text"><br>

������ <input name="password" type="password"><br>

�� ����������� � IP(�� ���������) <input type="checkbox" name="not_attach_ip"><br>

<input name="submit" type="submit" value="�����">

</form>