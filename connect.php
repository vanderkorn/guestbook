<?php
// @creation_date 14.02.07
// @modification_date 12.03.07
// @author Kornilov Ivan
// @document connect.php
//������ �������� ���������� � �����,�������� ���� � �������
// @version 0.2
$hostname="localhost";//��� �����
$db="baza";//��� ����
$tablename="mes";//��� �������
$adm="1";//��� ��������������
$ps="1";//������ ��������������
$username="root";//��� ������������
$pass="";//������
$imgDir="images";//����� ��� �������� �����������
@mkdir($imgDir,0777);//������� �����, ���� � ��� � ������� �������
mysql_connect($hostname,$username,$pass) or die ("�� ������� ������������ � ����: ".mysql_error()); //����������� � ����
@mysql_query('CREATE DATABASE '.$db); //�������� ����, ���� �� ���
mysql_select_db($db) or die("�� ������� ������� ����: ".mysql_error());  //����� ����
mysql_query('CREATE TABLE IF NOT EXISTS '.$tablename.'(id INT AUTO_INCREMENT PRIMARY KEY,number INT,stamp TIMESTAMP,name VARCHAR(60),text TEXT,tel VARCHAR(60),mail VARCHAR(60),protect VARCHAR(60),isImg VARCHAR(60))') or die ("�� ������� ������� �������: ".mysql_error()); //�������� �������, ���� �� ���
?>