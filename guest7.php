	<?php
	// @creation_date 14.02.07
	// @modification_date 12.03.07
	// @author Kornilov Ivan
	// @document guest6.php
	// гостевая книга
	// @version 0.2
	require_once "connect.php";//подключения скрипт создания соединения с базой,создания базы и таблицы
	require_once "adm.php"; //подключения скрипта администраторской части гостевой книги
	echo"<script language='javascript1.1' type='text/javascript'src='check.js'></script>";//подключения скрипта проверки правильности заполнения формы
	if ((!isset($_REQUEST['action']))&&(!isset($_REQUEST['q']))&&(!isset($_REQUEST['action1']))&&(!isset($_REQUEST['action2']))&&(!isset($_REQUEST['action0']))&&(!isset($_REQUEST['action3']))) //Если не нажата кнопка добавить сообщение и администраторская часть и все кнопки администраторской части продолжить выполннения оператора if
	{
	echo "<html><head><title>Гостевая книга</title></head>";
	echo "<body><center><h2><b>Гостевая книга</b></h2><br><br><table width=90% cellspacing=0 cellpadding=0 bgcolor=white border=0 align=center topmargin=0 marginwidth=0>";
	$a=mysql_query('SELECT * FROM '.$tablename.' ORDER BY id desc'); //выбираем все поля из таблицы отсортированные по полю id
	$x=mysql_num_rows($a);//количество строчек результата запроса
	if ($x>10)   //если количество строчек больше 10 то выполняется оператор
	{
	echo "<tr  ><td colspan=3 width=100% align=center><font size=\"-1\">страница: ";
	for ($i=0; $i<$x/10; $i++)  //разбиение записей по страницам и создание ссылок на страницы
	 {
	$j=$i+1;
	echo "[";
	if (!isset($_REQUEST['p']) || $_REQUEST['p']<>$j)//если ссылки страниц не активированны или страница не равна активной то создаем на нее  ссылку
	{
	echo "<a href=". $_SERVER['PHP_SELF']."?p=$j>";
	}
	echo $j;
	if (!isset($_REQUEST['p']) || $_REQUEST['p']<>$j)//если ссылки страниц не активированны или страница не равна активной то создаем на нее  ссылку
	{
	echo "</a>";
	}
	echo "] ";
	}
	}
	echo "<br><br></font></td></tr>";
	if (isset($_REQUEST['p'])) //если активирована ссылки страницы
	{
	$xx=($_REQUEST['p']-1)*10;
	}
	else {
	$xx=0;
	}
	$a=mysql_query('SELECT *,UNIX_TIMESTAMP(stamp) AS stamp FROM '.$tablename.' ORDER BY stamp desc limit '.$xx.', 10');//выбрать 10 строчек начиная с хх отсортированные по времени
	$b=array();
	while (($b=mysql_fetch_assoc($a))!==false)//выбор строчек по очередно из массива
	 {
	$b['text']=eregi_replace("\n","<br>&nbsp;",$b['text']);//замена символов перевода строки на их аналоги в html-ФОРМЕ


	echo "<tr><td width=7% align = center rowspan = '2'>";
	if ($b['isImg']!="0")//если запись содержит картинку то продолжить выполннения оператора if
	{
	echo "<img name='img' src='".$imgDir."/".$b['id'].".".$b['isImg']."' width='50' height='50'>";
	}
	echo "</td>";

	echo "<td width=13% align = left rowspan = '2'><font size=\"-2\">от ".$b['name']."<br>".date("d.m.Y H:i",$b['stamp']);
	if ($b['protect']!="1") //если запись не содержит защиты контактной информации то продолжить выполннения оператора if
	{	echo "<br><font size=\"-2\">e-mail: </font><font size=\"-1\">".$b['mail']."</font><br><font size=\"-2\">Телефон: </font><font size=\"-1\">".$b['tel']."</font></td>";
	}

	echo "<td align = left><p ><font size=\"-1\">".$b['text']."</font><br><br><br>\n</td>\n</tr><tr >\n<td  colspan = 1 >\n<hr width=100%>\n</td>\n</tr>";
	}
	echo "</table><br><a href=". $_SERVER['PHP_SELF']."?action=add><font size=\"-1\"><b>Добавить сообщение</b></font></a><br><br>\n<a href=". $_SERVER['PHP_SELF']."?action=login><font size=\"-1\"><b>Администраторская часть</b></font></a></center></body></html>";
	}

	if (isset($_REQUEST['action']) && (($_REQUEST['action']=="add")))//если была нажата кнопка добавить сообщение то продолжить выполннения оператора if
	{
	echo "<html><head><title>Добавление сообщения в гостевую книгу</title></head>";
	echo "<body><center><h2><br><br><br>Добавление сообщения в гостевую книгу</h1><br>";
	echo "<center><form action=\"". $_SERVER['PHP_SELF']."?g=1\" method=\"POST\"  name=\"self\"  enctype=\"multipart/form-data\" onsubmit=\"return check(document.self)\" ><center><table width=80% cellspacing=0 cellpadding=5 bgcolor=white border=0 align=center>";//создание формы добавления сообщения
	echo "<tr><td width=20% valign=middle align=left><font size=\"-1\">Ваше имя:</font> </td><td width=80% valign=middle align=justify><input type=\"text\" name=\"name\" ></td></tr>";
	echo "<tr><td width=20% valign=middle align=left><font size=\"-1\">Ваш телефон:</font> </td><td width=80% valign=middle align=justify><input type=\"text\" name=\"tel\"></td></tr><tr><td width=20% valign=middle align=left><font size=\"-1\">Ваш e-mail:</font> ";
	echo "</td><td width=80%><input type=\"text\" name=\"mail\"></td></tr>";
	$txt="";
		echo "<tr><td width=20% valign=middle align=left><font size=\"-1\">Текст сообщения:</font> </td><td width=80% valign=middle align=justify>";
	echo "<input type=\"button\" name=\"bold\" value=\"Полужирный\" onClick=\"bold2()\"><input type=\"button\" name=\"ital\" value=\"Курсив\" onClick=\"ital()\"><br><textarea name=\"msg\" id=\"msg\" rows=7 cols=45><b>ffffbf</b>$txt</textarea></td></tr><tr><td>Загрузить картинку:</td><td><input type=\"file\" name =\"file\"  size = \"47\" accept=\"image\"></td></tr>";
	echo "<tr><td width=100% colspan=2 valign=middle align=center>";
	echo "<input type=\"hidden\" name=\"action\" value=\"addnew\">";
	$today=date ("j/n/Y");
	echo "<input type=\"hidden\" name=\"date\" value=\"$today\">";
	echo "<font size=\"-1\">Скрывать мои контактные данные</font><input type=\"checkbox\" name=\"protect\" value=\"1\">";
	echo "<br><br><font size=\"-1\">Обязательно заполните поля Имя и Текст сообщения</font>";
	echo "<br><br><input type=\"submit\" value=\"отправить\">&nbsp;&nbsp;<input type=\"reset\" value=\"очистить\"></td></tr>";
	echo "</table></form></center></body>";
	}
	if (isset($_REQUEST['g']) && $_REQUEST['g']=="1") //если была послана форма на сервер то продолжить выполннения оператора if
	        {
	            	$data=$_FILES['file'];//получить файл отправленный на сервер
	            	$tmp=$data['tmp_name'] ;  //получить имя временного файл отправленного на сервер
	            	if (@file_exists($tmp))   //если файл существует   то продолжить выполннения оператора if
	            	{

	            	            $info=@getimagesize($_FILES['file']['tmp_name']);  //получить информацию о файле
	            	            if (preg_match('{image/(.*)}is',$info['mime'],$p)) //если файл - изображение   то продолжить выполннения оператора if
	            	            {  if (($data['size']/1024)<=100)//если размер файла меньше 100 кбайт  то продолжить выполннения оператора if
	            	             {

	            	                   if (isset($_REQUEST['protect']))//если была нажата кнопка скрывать контактные данные  то продолжить выполннения оператора if
	            	                   {
	                                     $rt= "1";
	    	                          }
	    	                             else
	    	                            {
	    	                         $rt= "0";
	    		                          }
	                     $vrem=time();//получить текущее время
	                     mysql_query("INSERT INTO $tablename SET   name='".$_REQUEST['name']."', text='".$_REQUEST['msg']."', tel='".$_REQUEST['tel']."',  mail='".$_REQUEST['mail']."',  protect='".$rt."', isImg='".$p[1]."'" )or die ("Не удалось добавить запись: ".mysql_error());//вставить новую запись в таблицу
	                     $id=mysql_insert_id();//получить id записи
	                     $name="$imgDir/".$id.".".$p[1]; //создать путь и имя к файлу изображения
	                     move_uploaded_file($tmp,$name);    //загрузить файл в директорию из временной папки	            	     echo "<html><body><center><h1><br><br><br><br>Ваше объявление добавлено, спасибо.</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">вернуться к просмотру гостевой книги</a></center></body></html>";
	                          	  }
	                          	    else
	                          	  {
	                          		echo "<html><body><center><h1><br><br><br><br>Попытка добавить файл недопустимого размера</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">вернуться к просмотру гостевой книги</a><a href=". $_SERVER['PHP_SELF']."?action=add>Добавить сообщение</a></center></body></html>";
	                          	  }
	                          	}
	                          	else
	                          	{	                          		echo "<html><body><center><h1><br><br><br><br>Попытка добавить файл недопустимого формата</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">вернуться к просмотру гостевой книги</a><a href=". $_SERVER['PHP_SELF']."?action=add>Добавить сообщение</a></center></body></html>";
	                          	}	            	}
	                else
	                {

	                 if (isset($_REQUEST['protect'])) //если была нажата кнопка скрывать контактные данные  то продолжить выполннения оператора if
	                 {
	                               $rt= "1";
	    	               }
	    	               else
	    	               {
	    	                    $rt= "0";
	    		           }
	                    $vrem=time(); //получить текущее время
	                    mysql_query("INSERT INTO $tablename SET   name='".$_REQUEST['name']."', text='".$_REQUEST['msg']."', tel='".$_REQUEST['tel']."',  mail='".$_REQUEST['mail']."',  protect='".$rt."', isImg='0'" )or die ("Не удалось добавить запись: ".mysql_error());//вставить новую запись в таблицу
	                    echo "<html><body><center><h1><br><br><br><br>Ваше объявление добавлено, спасибо.</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">вернуться к просмотру гостевой книги</a></center></body></html>";

	             	}

	 }
	?>