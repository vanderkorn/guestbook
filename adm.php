	 <?php
	// @creation_date 5.03.07
	// @modification_date 12.03.07
	// @author Kornilov Ivan
	// @document adm.php
	// ����������������� ����� �������� �����
	// @version 0.2
	   if (isset($_REQUEST['action']) && $_REQUEST['action']=="login")
	{
	echo "<form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\"><table align=left><tr><td width=20%>��� �����:</td><td width=80% align=left><input type=\"text\" name=\"login\"></td></tr><tr><td width=20%>��� ������:</td><td width=80% align=left><input type=\"password\" name=\"password\"><input type=\"hidden\" name=\"action\" value=\"verify\"></td></tr><tr><td width=100% colspan=2 align=center><input type=\"submit\" value=\"o��������\">&nbsp;&nbsp;<input type=\"reset\" value=\"��������\"></td></table></form>";
	}
	if (isset($_REQUEST['action']) && $_REQUEST['action']=="verify")//���� ���� ������ ������ �������� ������ � ������ ����������������� ����� �� ���������� ����������� ��������� if
	{
	        if (isset($_REQUEST['login']) && $_REQUEST['login']==$adm)//���� �������� ���������� �����  �� ���������� ����������� ��������� if
	        {
	   if (isset ($_REQUEST['password']) && ($_REQUEST['password']==$ps)) //���� �������� ���������� ������  �� ���������� ����������� ��������� if
	                {
	echo "<html><body><title>����������������� �������� �����</title>";
	echo "<center><table width=100% cellspacing=0 cellpadding=0 bgcolor=white border=1 align=center topmargin=0 marginwidth=0>";
	$a=mysql_query("select * from $tablename ORDER by stamp desc");
	 $x=mysql_num_rows($a); //���������� ������� ���������� �������
	if ($x>10) //���� ���������� ������� ������ 10 �� ����������� ��������
	{
	echo "<tr><td colspan=3 width=100% align=center><font size=\"-1\">��������: ";
	for ($i=0; $i<$x/10; $i++)//��������� ������� �� ��������� � �������� ������ �� ��������
	 {
	$j=$i+1;
	echo "[";
	if (!isset($_REQUEST['q']) || $_REQUEST['q']<>$j) //���� ������ ������� �� ������������� ��� �������� �� ����� �������� �� ������� �� ���  ������
	{
	echo "<a href=". $_SERVER['PHP_SELF']."?q=$j&action=verify&login=1&password=1>";
	}
	echo $j;
	if (!isset($_REQUEST['q']) || $_REQUEST['q']<>$j)//���� ������ ������� �� ������������� ��� �������� �� ����� �������� �� ������� �� ���  ������
	{
	echo "</a>";
	}
	echo "] ";
	}
	}
	echo "<br><br></font></td></tr>";
	if (isset($_REQUEST['q'])) //���� ������������ ������ ��������
	 {
	$xx=($_REQUEST['q']-1)*10;
	}
	else {
	$xx=0;
	}
	$a=mysql_query('SELECT *,UNIX_TIMESTAMP(stamp) AS stamp FROM '.$tablename.' ORDER BY stamp desc limit '.$xx.', 10');  //������� 10 ������� ������� � �� ��������������� �� �������

	while (($b=mysql_fetch_assoc($a))!==false)   //����� ������� �� �������� �� �������
	 {
	echo "<tr><form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\" enctype=\"multipart/form-data\" ><td width=20% align=center valign=top rowspan=2><font size=\"-1\"><i>�� <font size=\"-1\"><input type=\"text\" name=\"name\" value=\"".$b['name']."\"><br></font><br>".date("d.m.Y H:i",$b['stamp'])."</i></font><br><font size=\"-1\"><i>E-mail:     </i></font><font size=\"-1\"><input type=\"text\" name=\"mail\" value=\"".$b['mail']."\"><br></font><font size=\"-1\"><i>�������:</i></font><font size=\"-1\"><input type=\"text\" name=\"tel\" value=\"".$b['tel']."\"></td></td>";   //�������� ����� ��� ������ ������ ���������
	 echo "<td width=20%>";
	if ($b['isImg']!="0") //���� ������ �������� �������� �� ���������� ����������� ��������� if
	{
	echo "<img name='img' src='".$imgDir."/".$b['id'].".".$b['isImg']."' width='50' height='50'>";
	}
	else
	{
	 echo "<font size=\"-1\">����������� ���</font>";
	}

	 echo "</td>";

	echo "<td  width=60% align=left valign=middle><font size=\"-1\"><i>����� ���������:</i><br><textarea rows=7 cols=75 name=\"msg\">".$b['text']."</textarea></font></td></tr><tr><td  width=80% align=left valign=middle colspan=2>";
	echo "<p align=left> <input type=\"hidden\" name=\"type\" value=\"".$b['isImg']."\"><font size=\"-1\">��������� �����������: </font><input type=\"file\" name =\"file\"  size = \"47\" accept=\"image\"><input type=\"submit\" name=\"action3\" value=\"������� �����������\"><br><input type=\"hidden\" name=\"id\" value=\"".$b['id']."\"><input type=\"submit\" name=\"action0\" value=\"���������� ����� ���������\"><input type=\"hidden\" name=\"id\" value=\"".$b['id']."\"><input type=\"submit\" name=\"action1\" value=\"���������\"><input type=\"submit\" name=\"action2\" value=\"�������\"></tr></form></p>";
	}
	echo "</table><br><form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\"  ><input type=\"hidden\" name=\"action\" value=\"deleteall\"><input type=\"submit\" value=\"�������� ���� ������\"></form><br><form action=\"". $_SERVER['PHP_SELF']."\"><input type=\"submit\" value=\"������� � ��������� ���������\"></form></center>";
	echo "<center><br><form action=\"". $_SERVER['PHP_SELF']."\" method=\"POST\"><input type=\"hidden\" name=\"action\" value=\"ddelete\"><input type=\"submit\" value=\"������� ��������� ������, ���\"><input type=\"text\" name=\"much\" size=\"3\" value=\"60\">����</form></center>";
	echo "</body></html>";
	                }
	                else {echo "<a href=javascript:history.back(1)>������� ������ ������.</a>";}
	        }else {echo "<a href=javascript:history.back(1)>������� ������ �����.</a>";}

	}
	if (isset($_REQUEST['action0']) && isset($_REQUEST['id'])) //���� ���� ������ ������ ���������� ����� ��������� ����������������� ����� �� ���������� ����������� ��������� if
	{
		$q=mysql_query('SELECT text  FROM '.$tablename.' where id='.$_REQUEST['id'].''); //�������� ���� text � ������ id
		$q2=mysql_fetch_assoc($q);//�������� ������
		$txt=$q2['text'];  //�������� ����� ���������
	    mysql_query("INSERT INTO $tablename SET   name='"."adm"."', text='".$txt."', tel='".""."',  mail='".""."',  protect='"."0"."',  isImg='0'" )or die ("�� ������� �������� ������: ".mysql_error()); //�������� ����� ������ � ��������� ������� �� ������� ��������� txt� �������
	    echo "<html><body><center><h1>��������� � ��������� ���������.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">������������� ������</a> <a href=". $_SERVER['PHP_SELF'].">������ ���������</a></center></body></html>";

	}
	if (isset($_REQUEST['action3']) && isset($_REQUEST['id']))//���� ���� ������ ������ ��������� ����������� ����������������� ����� �� ���������� ����������� ��������� if
	{
	 $name1=realpath("./$imgDir/".$_REQUEST['id'].".".$_REQUEST['type']);//����� ���� � ����� � ��������� id � ����� ����  �����
	                             if (file_exists( $name1))//���� ���� ����������  �� ������������ ����������� ��������� if
	            	             {
	                             unlink($name1);//��������� ������� ����(������)
	                             mysql_query("update ".$tablename." set isImg='"."0"."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error()); //������� ����������� � ���. ������������
	                             echo "<html><body><center><h1>��������� � ��������� ���������.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">������������� ������</a> <a href=". $_SERVER['PHP_SELF'].">������ ���������</a></center></body></html>";

	            	             }
	            	             else
	            	             {
	            	                echo "<html><body><center><h1>����� �� ���������� ��� ��������</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">������������� ������</a> <a href=". $_SERVER['PHP_SELF'].">������ ���������</a></center></body></html>";

	            	             	}


		}
	if (isset($_REQUEST['action1']) && isset($_REQUEST['id'])) //���� ���� ������ ������ ��������� ����������������� ����� �� ���������� ����������� ��������� if
	{
	                 $data=$_FILES['file'];//�������� ���� ������������ �� ������
	            	$tmp=$data['tmp_name'] ;//�������� ��� ���������� ���� ������������� �� ������

	            	if (@file_exists($tmp))   //���� ���� ����������   �� ���������� ����������� ��������� if
	            	{

	            	            $info=@getimagesize($_FILES['file']['tmp_name']);//�������� ���������� � �����
	            	            if (preg_match('{image/(.*)}is',$info['mime'],$p))//���� ���� - �����������   �� ���������� ����������� ��������� if
	            	            {  if (($data['size']/1024)<=100) //���� ������ ����� ������ 100 �����  �� ���������� ����������� ��������� if
	            	             {
	                            $name1=realpath("./$imgDir/".$_REQUEST['id'].".".$_REQUEST['type']);//����� ���� � ����� � ��������� id � ����� ����  �����
	                             if (file_exists( $name1))//���� ���� ����������  �� ������������ ����������� ��������� if
	            	             {
	                             unlink($name1);//��������� ������� ����(������)
	            	             }


	                        mysql_query("update ".$tablename." set name='".$_REQUEST['name']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error());//���������� ���� name ������
	                        mysql_query("update ".$tablename." set text='".$_REQUEST['msg']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error()); //���������� ���� msg ������
	                        mysql_query("update ".$tablename." set tel='".$_REQUEST['tel']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error());//���������� ���� tel ������
	                        mysql_query("update ".$tablename." set mail='".$_REQUEST['mail']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error()); //���������� ���� mail ������


	                     $id=mysql_insert_id();//��������� id ������
	                     $name="$imgDir/".$_REQUEST['id'].".".$p[1];  //������� ���� � ��� � ����� �����������
	                     move_uploaded_file($tmp,$name);     //��������� ���� � ���������� �� ��������� �����
	                  mysql_query("update ".$tablename." set isImg='".$p[1]."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error());    //���������� ���� isImg ������

	                  echo "<html><body><center><h1>��������� � ��������� ���������.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">������������� ������</a> <a href=". $_SERVER['PHP_SELF'].">������ ���������</a></center></body></html>";

	            	           	  }
	                          	    else
	                          	  {
	                          		echo "<html><body><center><h1><br><br><br><br>������� �������� ���� ������������� �������</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">��������� � ��������� �������� �����</a><a href=". $_SERVER['PHP_SELF']."?action=add>�������� ���������</a></center></body></html>";
	                          	  }
	                          	}
	                          	else
	                          	{
	                          		echo "<html><body><center><h1><br><br><br><br>������� �������� ���� ������������� �������</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">��������� � ��������� �������� �����</a><a href=". $_SERVER['PHP_SELF']."?action=add>�������� ���������</a></center></body></html>";
	                          	}
	            	}
	                else
	                {

	                          mysql_query("update ".$tablename." set name='".$_REQUEST['name']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error());//���������� ���� name ������
	mysql_query("update ".$tablename." set text='".$_REQUEST['msg']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error());     //���������� ���� msg ������
	mysql_query("update ".$tablename." set tel='".$_REQUEST['tel']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error());      //���������� ���� tel ������
	mysql_query("update ".$tablename." set mail='".$_REQUEST['mail']."' where id='".$_REQUEST['id']."'")or die ("�� ������� �������� ������: ".mysql_error());    //���������� ���� mail ������
	echo "<html><body><center><h1>��������� � ��������� ���������.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">������������� ������</a> <a href=". $_SERVER['PHP_SELF'].">������ ���������</a></center></body></html>";

	             	}

	}

	if (isset($_REQUEST['action']) && $_REQUEST['action']=="ddelete" && isset($_REQUEST['much']) && $_REQUEST['much']>0)//���� ���� ������ ������ ������� ��������� ������, ��� ����������������� ����� �� ���������� ����������� ��������� if
	{
	$q=time()-$_REQUEST['much']*24*60*60;//���������� ������� ������� ����� ����� ����  ���� ������� ��������� � �������


	       $a=mysql_query("select * from ".$tablename );//����� ���� ������� �� �������
	while (($b=mysql_fetch_assoc($a))!==false)//����� ������� �� �������� �� �������
	{

	if (strtotime( $b['stamp'])<$q)//���� ��������� ������ ����������� ������� ���� ������� � ������� �� ���������� ����������� ��������� if
	{mysql_query("delete from ".$tablename." where id='". $b['id']."'");};//������� ������
	}


	echo "<html><body><center><h1>��������� ������, ��� ".$_REQUEST['much']." ����, �������.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=adm&password=$ps\">������������� ������</a> <a href=". $_SERVER['PHP_SELF'].">������ ���������</a></center></body></html>";
	}

	if (isset($_REQUEST['action2']) && isset($_REQUEST['id'])) //���� ���� ������ ������ ������� ����������������� ����� �� ���������� ����������� ��������� if
	{
	mysql_query("delete from ".$tablename."  where id='".$_REQUEST['id']."'");//������� ������ �� ������� � �������� id
	echo "<html><body><center><h1>��������� �������.</h1><br><a href=\"". $_SERVER['PHP_SELF']."?action=verify&login=$adm&password=$ps\">������������� ������</a> <a href=". $_SERVER['PHP_SELF'].">������ ���������</a></center></body></html>";
	}
	if (isset($_REQUEST['action']) && $_REQUEST['action']=="deleteall")  //���� ���� ������ ������ ������ ���� ����������������� ����� �� ���������� ����������� ��������� if
	{
	mysql_query("truncate ".$tablename);//�������� ���� �������
	echo "<html><center><h1>������ ���� ������� ������� �� ���� ������.</h1><br><a href=\"". $_SERVER['PHP_SELF']."\">�������� �������� �����</a></center>";
	}
	?>