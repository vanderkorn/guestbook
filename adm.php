	 <?php
	// @creation_date 5.03.07
	// @modification_date 12.03.07
	// @author Kornilov Ivan
	// @document adm.php
	// администраторская часть гостевой книги
	// @version 0.2
	   if (isset($_REQUEST['action']) && $_REQUEST['action']=="login")
	{
	echo "<form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\"><table align=left><tr><td width=20%>Ваш Логин:</td><td width=80% align=left><input type=\"text\" name=\"login\"></td></tr><tr><td width=20%>Ваш Пароль:</td><td width=80% align=left><input type=\"password\" name=\"password\"><input type=\"hidden\" name=\"action\" value=\"verify\"></td></tr><tr><td width=100% colspan=2 align=center><input type=\"submit\" value=\"oтправить\">&nbsp;&nbsp;<input type=\"reset\" value=\"очистить\"></td></table></form>";
	}
	if (isset($_REQUEST['action']) && $_REQUEST['action']=="verify")//если была нажата кнопка проверки пароля и логина администраторской части то продолжить выполннения оператора if
	{
	        if (isset($_REQUEST['login']) && $_REQUEST['login']==$adm)//если введеный правильный логин  то продолжить выполннения оператора if
	        {
	   if (isset ($_REQUEST['password']) && ($_REQUEST['password']==$ps)) //если введеный правильный пароль  то продолжить выполннения оператора if
	                {
	echo "<html><body><title>Администрирование гостевой книги</title>";
	echo "<center><table width=100% cellspacing=0 cellpadding=0 bgcolor=white border=1 align=center topmargin=0 marginwidth=0>";
	$a=mysql_query("select * from $tablename ORDER by stamp desc");
	 $x=mysql_num_rows($a); //количество строчек результата запроса
	if ($x>10) //если количество строчек больше 10 то выполняется оператор
	{
	echo "<tr><td colspan=3 width=100% align=center><font size=\"-1\">страница: ";
	for ($i=0; $i<$x/10; $i++)//разбиение записей по страницам и создание ссылок на страницы
	 {
	$j=$i+1;
	echo "[";
	if (!isset($_REQUEST['q']) || $_REQUEST['q']<>$j) //если ссылки страниц не активированны или страница не равна активной то создаем на нее  ссылку
	{
	echo "<a href=". $_SERVER['PHP_SELF']."?q=$j&action=verify&login=1&password=1>";
	}
	echo $j;
	if (!isset($_REQUEST['q']) || $_REQUEST['q']<>$j)//если ссылки страниц не активированны или страница не равна активной то создаем на нее  ссылку
	{
	echo "</a>";
	}
	echo "] ";
	}
	}
	echo "<br><br></font></td></tr>";
	if (isset($_REQUEST['q'])) //если активирована ссылки страницы
	 {
	$xx=($_REQUEST['q']-1)*10;
	}
	else {
	$xx=0;
	}
	$a=mysql_query('SELECT *,UNIX_TIMESTAMP(stamp) AS stamp FROM '.$tablename.' ORDER BY stamp desc limit '.$xx.', 10');  //выбрать 10 строчек начиная с хх отсортированные по времени

	while (($b=mysql_fetch_assoc($a))!==false)   //выбор строчек по очередно из массива
	 {
	echo "<tr><form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\" enctype=\"multipart/form-data\" ><td width=20% align=center valign=top rowspan=2><font size=\"-1\"><i>от <font size=\"-1\"><input type=\"text\" name=\"name\" value=\"".$b['name']."\"><br></font><br>".date("d.m.Y H:i",$b['stamp'])."</i></font><br><font size=\"-1\"><i>E-mail:     </i></font><font size=\"-1\"><input type=\"text\" name=\"mail\" value=\"".$b['mail']."\"><br></font><font size=\"-1\"><i>Телефон:</i></font><font size=\"-1\"><input type=\"text\" name=\"tel\" value=\"".$b['tel']."\"></td></td>";   //создание формы для каждой записи выбранной
	 echo "<td width=20%>";
	if ($b['isImg']!="0") //если запись содержит картинку то продолжить выполннения оператора if
	{
	echo "<img name='img' src='".$imgDir."/".$b['id'].".".$b['isImg']."' width='50' height='50'>";
	}
	else
	{
	 echo "<font size=\"-1\">Изображения нет</font>";
	}

	 echo "</td>";

	echo "<td  width=60% align=left valign=middle><font size=\"-1\"><i>Текст сообщения:</i><br><textarea rows=7 cols=75 name=\"msg\">".$b['text']."</textarea></font></td></tr><tr><td  width=80% align=left valign=middle colspan=2>";
	echo "<p align=left> <input type=\"hidden\" name=\"type\" value=\"".$b['isImg']."\"><font size=\"-1\">Загрузить изображение: </font><input type=\"file\" name =\"file\"  size = \"47\" accept=\"image\"><input type=\"submit\" name=\"action3\" value=\"Удалить изображение\"><br><input type=\"hidden\" name=\"id\" value=\"".$b['id']."\"><input type=\"submit\" name=\"action0\" value=\"Цитировать текст сообщения\"><input type=\"hidden\" name=\"id\" value=\"".$b['id']."\"><input type=\"submit\" name=\"action1\" value=\"Сохранить\"><input type=\"submit\" name=\"action2\" value=\"Удалить\"></tr></form></p>";
	}
	echo "</table><br><form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\"  ><input type=\"hidden\" name=\"action\" value=\"deleteall\"><input type=\"submit\" value=\"Очистить базу данных\"></form><br><form action=\"". $_SERVER['PHP_SELF']."\"><input type=\"submit\" value=\"Перейти к просмотру сообщений\"></form></center>";
	echo "<center><br><form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\"><input type=\"hidden\" name=\"action\" value=\"ddelete\"><input type=\"submit\" value=\"Удалить сообщения старше, чем\"><input type=\"text\" name=\"much\" size=\"3\" value=\"60\">дней</form></center>";
	echo "</body></html>";
	                }
	                else {echo "<a href=javascript:history.back(1)>Неверно указан Пароль.</a>";}
	        }else {echo "<a href=javascript:history.back(1)>Неверно указан Логин.</a>";}

	}
	if (isset($_REQUEST['action0']) && isset($_REQUEST['id'])) //если была нажата кнопка Цитировать текст сообщения администраторской часть то продолжить выполннения оператора if
	{
		$q=mysql_query('SELECT text  FROM '.$tablename.' where id='.$_REQUEST['id'].''); //выбираем поле text с записи id
		$q2=mysql_fetch_assoc($q);//выбираем запись
		$txt=$q2['text'];  //выбираем текст сообщения
	    mysql_query("INSERT INTO $tablename SET   name='"."adm"."', text='".$txt."', tel='".""."',  mail='".""."',  protect='"."0"."',  isImg='0'" )or die ("Не удалось добавить запись: ".mysql_error()); //вставить новую запись с выбранным текстом из другого сообщения txtв таблицу
	    echo "<html><body><center><h1>Изменения в сообщении сохранены.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">редактировать записи</a> <a href=". $_SERVER['PHP_SELF'].">читать сообщения</a></center></body></html>";

	}
	if (isset($_REQUEST['action3']) && isset($_REQUEST['id']))//если была нажата кнопка Загрузить Изображение администраторской часть то продолжить выполннения оператора if
	{
	 $name1=realpath("./$imgDir/".$_REQUEST['id'].".".$_REQUEST['type']);//берем путь к файлу с известным id и может быть  типом
	                             if (file_exists( $name1))//если файл существует  то продолжается выполннение оператора if
	            	             {
	                             unlink($name1);//удалается прошлый файл(старый)
	                             mysql_query("update ".$tablename." set isImg='"."0"."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error()); //тфблица обновляется с изм. изображением
	                             echo "<html><body><center><h1>Изменения в сообщении сохранены.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">редактировать записи</a> <a href=". $_SERVER['PHP_SELF'].">читать сообщения</a></center></body></html>";

	            	             }
	            	             else
	            	             {
	            	                echo "<html><body><center><h1>Файла не существует для удаления</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">редактировать записи</a> <a href=". $_SERVER['PHP_SELF'].">читать сообщения</a></center></body></html>";

	            	             	}


		}
	if (isset($_REQUEST['action1']) && isset($_REQUEST['id'])) //если была нажата кнопка Сохранить администраторской часть то продолжить выполннения оператора if
	{
	                 $data=$_FILES['file'];//получить файл отправленный на сервер
	            	$tmp=$data['tmp_name'] ;//получить имя временного файл отправленного на сервер

	            	if (@file_exists($tmp))   //если файл существует   то продолжить выполннения оператора if
	            	{

	            	            $info=@getimagesize($_FILES['file']['tmp_name']);//получить информацию о файле
	            	            if (preg_match('{image/(.*)}is',$info['mime'],$p))//если файл - изображение   то продолжить выполннения оператора if
	            	            {  if (($data['size']/1024)<=100) //если размер файла меньше 100 кбайт  то продолжить выполннения оператора if
	            	             {
	                            $name1=realpath("./$imgDir/".$_REQUEST['id'].".".$_REQUEST['type']);//берем путь к файлу с известным id и может быть  типом
	                             if (file_exists( $name1))//если файл существует  то продолжается выполннение оператора if
	            	             {
	                             unlink($name1);//удалается прошлый файл(старый)
	            	             }


	                        mysql_query("update ".$tablename." set name='".$_REQUEST['name']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error());//обновление поля name записи
	                        mysql_query("update ".$tablename." set text='".$_REQUEST['msg']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error()); //обновление поля msg записи
	                        mysql_query("update ".$tablename." set tel='".$_REQUEST['tel']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error());//обновление поля tel записи
	                        mysql_query("update ".$tablename." set mail='".$_REQUEST['mail']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error()); //обновление поля mail записи


	                     $id=mysql_insert_id();//получение id записи
	                     $name="$imgDir/".$_REQUEST['id'].".".$p[1];  //создать путь и имя к файлу изображения
	                     move_uploaded_file($tmp,$name);     //загрузить файл в директорию из временной папки
	                  mysql_query("update ".$tablename." set isImg='".$p[1]."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error());    //обновление поля isImg записи

	                  echo "<html><body><center><h1>Изменения в сообщении сохранены.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">редактировать записи</a> <a href=". $_SERVER['PHP_SELF'].">читать сообщения</a></center></body></html>";

	            	           	  }
	                          	    else
	                          	  {
	                          		echo "<html><body><center><h1><br><br><br><br>Попытка добавить файл недопустимого размера</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">вернуться к просмотру гостевой книги</a><a href=". $_SERVER['PHP_SELF']."?action=add>Добавить сообщение</a></center></body></html>";
	                          	  }
	                          	}
	                          	else
	                          	{
	                          		echo "<html><body><center><h1><br><br><br><br>Попытка добавить файл недопустимого формата</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">вернуться к просмотру гостевой книги</a><a href=". $_SERVER['PHP_SELF']."?action=add>Добавить сообщение</a></center></body></html>";
	                          	}
	            	}
	                else
	                {

	                          mysql_query("update ".$tablename." set name='".$_REQUEST['name']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error());//обновление поля name записи
	mysql_query("update ".$tablename." set text='".$_REQUEST['msg']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error());     //обновление поля msg записи
	mysql_query("update ".$tablename." set tel='".$_REQUEST['tel']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error());      //обновление поля tel записи
	mysql_query("update ".$tablename." set mail='".$_REQUEST['mail']."' where id='".$_REQUEST['id']."'")or die ("Не удалось добавить запись: ".mysql_error());    //обновление поля mail записи
	echo "<html><body><center><h1>Изменения в сообщении сохранены.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">редактировать записи</a> <a href=". $_SERVER['PHP_SELF'].">читать сообщения</a></center></body></html>";

	             	}

	}

	if (isset($_REQUEST['action']) && $_REQUEST['action']=="ddelete" && isset($_REQUEST['much']) && $_REQUEST['much']>0)//если была нажата кнопка Удалить сообщения старше, чем администраторской часть то продолжить выполннения оператора if
	{
	$q=time()-$_REQUEST['much']*24*60*60;//вычисление времени границы когда могло быть  быть создано сообщение в таблице


	       $a=mysql_query("select * from ".$tablename );//выбор всех записей из таблицы
	while (($b=mysql_fetch_assoc($a))!==false)//выбор строчек по очередно из массива
	{

	if (strtotime( $b['stamp'])<$q)//если сообщение меньше вычислимого времени было создано в таблицы то продолжить выполннения оператора if
	{mysql_query("delete from ".$tablename." where id='". $b['id']."'");};//удалить запись
	}


	echo "<html><body><center><h1>Сообщения старше, чем ".$_REQUEST['much']." дней, удалены.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=adm&password=$ps\">редактировать записи</a> <a href=". $_SERVER['PHP_SELF'].">читать сообщения</a></center></body></html>";
	}

	if (isset($_REQUEST['action2']) && isset($_REQUEST['id'])) //если была нажата кнопка Удалить администраторской часть то продолжить выполннения оператора if
	{
	mysql_query("delete from ".$tablename."  where id='".$_REQUEST['id']."'");//удалить запись из таблицы с указаным id
	echo "<html><body><center><h1>Сообщение удалено.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">редактировать записи</a> <a href=". $_SERVER['PHP_SELF'].">читать сообщения</a></center></body></html>";
	}
	if (isset($_REQUEST['action']) && $_REQUEST['action']=="deleteall")  //если была нажата кнопка Очисть базу администраторской часть то продолжить выполннения оператора if
	{
	mysql_query("truncate ".$tablename);//очищение всей таблицы
	echo "<html><center><h1>Данные были успешно удалены из базы данных.</h1><br><a href=\"". $_SERVER['PHP_SELF']."\">просмотр гостевой книги</a></center>";
	}
	?>