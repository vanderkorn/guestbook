<?php
// @creation_date 14.02.07
// @modification_date 12.03.07
// @author Kornilov Ivan
// @document connect.php
//скрипт создания соединения с базой,создания базы и таблицы
// @version 0.2
$hostname="localhost";//Имя хоста
$db="baza";//имя базы
$tablename="mes";//Имя таблицы
$adm="1";//Имя Администратора
$ps="1";//Пароль Администратора
$username="root";//Имя пользователя
$pass="";//Пароль
$imgDir="images";//Папка для хранения изображений
@mkdir($imgDir,0777);//создаем папку, если её нет с полными правами
mysql_connect($hostname,$username,$pass) or die ("Не удалось подключиться к базе: ".mysql_error()); //подключение к базе
@mysql_query('CREATE DATABASE '.$db); //создание базы, если ее нет
mysql_select_db($db) or die("Не удалось выбрать базу: ".mysql_error());  //выбор базы
mysql_query('CREATE TABLE IF NOT EXISTS '.$tablename.'(id INT AUTO_INCREMENT PRIMARY KEY,number INT,stamp TIMESTAMP,name VARCHAR(60),text TEXT,tel VARCHAR(60),mail VARCHAR(60),protect VARCHAR(60),isImg VARCHAR(60))') or die ("Не удалось создать таблицу: ".mysql_error()); //создание таблицы, если ее нет
?>