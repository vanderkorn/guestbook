	<?php
	// @creation_date 14.02.07
	// @modification_date 12.03.07
	// @author Kornilov Ivan
	// @document guest6.php
	// �������� �����
	// @version 0.2
	require_once "connect.php";//����������� ������ �������� ���������� � �����,�������� ���� � �������
	require_once "adm.php"; //����������� ������� ����������������� ����� �������� �����
	echo"<script language='javascript1.1' type='text/javascript'src='check.js'></script>";//����������� ������� �������� ������������ ���������� �����
	if ((!isset($_REQUEST['action']))&&(!isset($_REQUEST['q']))&&(!isset($_REQUEST['action1']))&&(!isset($_REQUEST['action2']))&&(!isset($_REQUEST['action0']))&&(!isset($_REQUEST['action3']))) //���� �� ������ ������ �������� ��������� � ����������������� ����� � ��� ������ ����������������� ����� ���������� ����������� ��������� if
	{
	echo "<html><head><title>�������� �����</title></head>";
	echo "<body><center><h2><b>�������� �����</b></h2><br><br><table width=90% cellspacing=0 cellpadding=0 bgcolor=white border=0 align=center topmargin=0 marginwidth=0>";
	$a=mysql_query('SELECT * FROM '.$tablename.' ORDER BY id desc'); //�������� ��� ���� �� ������� ��������������� �� ���� id
	$x=mysql_num_rows($a);//���������� ������� ���������� �������
	if ($x>10)   //���� ���������� ������� ������ 10 �� ����������� ��������
	{
	echo "<tr  ><td colspan=3 width=100% align=center><font size=\"-1\">��������: ";
	for ($i=0; $i<$x/10; $i++)  //��������� ������� �� ��������� � �������� ������ �� ��������
	 {
	$j=$i+1;
	echo "[";
	if (!isset($_REQUEST['p']) || $_REQUEST['p']<>$j)//���� ������ ������� �� ������������� ��� �������� �� ����� �������� �� ������� �� ���  ������
	{
	echo "<a href=". $_SERVER['PHP_SELF']."?p=$j>";
	}
	echo $j;
	if (!isset($_REQUEST['p']) || $_REQUEST['p']<>$j)//���� ������ ������� �� ������������� ��� �������� �� ����� �������� �� ������� �� ���  ������
	{
	echo "</a>";
	}
	echo "] ";
	}
	}
	echo "<br><br></font></td></tr>";
	if (isset($_REQUEST['p'])) //���� ������������ ������ ��������
	{
	$xx=($_REQUEST['p']-1)*10;
	}
	else {
	$xx=0;
	}
	$a=mysql_query('SELECT *,UNIX_TIMESTAMP(stamp) AS stamp FROM '.$tablename.' ORDER BY stamp desc limit '.$xx.', 10');//������� 10 ������� ������� � �� ��������������� �� �������
	$b=array();
	while (($b=mysql_fetch_assoc($a))!==false)//����� ������� �� �������� �� �������
	 {
	$b['text']=eregi_replace("\n","<br>&nbsp;",$b['text']);//������ �������� �������� ������ �� �� ������� � html-�����


	echo "<tr><td width=7% align = center rowspan = '2'>";
	if ($b['isImg']!="0")//���� ������ �������� �������� �� ���������� ����������� ��������� if
	{
	echo "<img name='img' src='".$imgDir."/".$b['id'].".".$b['isImg']."' width='50' height='50'>";
	}
	echo "</td>";

	echo "<td width=13% align = left rowspan = '2'><font size=\"-2\">�� ".$b['name']."<br>".date("d.m.Y H:i",$b['stamp']);
	if ($b['protect']!="1") //���� ������ �� �������� ������ ���������� ���������� �� ���������� ����������� ��������� if
	{	echo "<br><font size=\"-2\">e-mail: </font><font size=\"-1\">".$b['mail']."</font><br><font size=\"-2\">�������: </font><font size=\"-1\">".$b['tel']."</font></td>";
	}

	echo "<td align = left><p ><font size=\"-1\">".$b['text']."</font><br><br><br>\n</td>\n</tr><tr >\n<td  colspan = 1 >\n<hr width=100%>\n</td>\n</tr>";
	}
	echo "</table><br><a href=". $_SERVER['PHP_SELF']."?action=add><font size=\"-1\"><b>�������� ���������</b></font></a><br><br>\n<a href=". $_SERVER['PHP_SELF']."?action=login><font size=\"-1\"><b>����������������� �����</b></font></a></center></body></html>";
	}

	if (isset($_REQUEST['action']) && (($_REQUEST['action']=="add")))//���� ���� ������ ������ �������� ��������� �� ���������� ����������� ��������� if
	{
	echo "<html><head><title>���������� ��������� � �������� �����</title></head>";
	echo "<body><center><h2><br><br><br>���������� ��������� � �������� �����</h1><br>";
	echo "<center><form action=\"". $_SERVER['PHP_SELF']."?g=1\" method=\"POST\"  name=\"self\"  enctype=\"multipart/form-data\" onsubmit=\"return check(document.self)\" ><center><table width=80% cellspacing=0 cellpadding=5 bgcolor=white border=0 align=center>";//�������� ����� ���������� ���������
	echo "<tr><td width=20% valign=middle align=left><font size=\"-1\">���� ���:</font> </td><td width=80% valign=middle align=justify><input type=\"text\" name=\"name\" ></td></tr>";
	echo "<tr><td width=20% valign=middle align=left><font size=\"-1\">��� �������:</font> </td><td width=80% valign=middle align=justify><input type=\"text\" name=\"tel\"></td></tr><tr><td width=20% valign=middle align=left><font size=\"-1\">��� e-mail:</font> ";
	echo "</td><td width=80%><input type=\"text\" name=\"mail\"></td></tr>";
	$txt="";
		echo "<tr><td width=20% valign=middle align=left><font size=\"-1\">����� ���������:</font> </td><td width=80% valign=middle align=justify>";
	echo "<input type=\"button\" name=\"bold\" value=\"����������\" onClick=\"bold2()\"><input type=\"button\" name=\"ital\" value=\"������\" onClick=\"ital()\"><br><textarea name=\"msg\" id=\"msg\" rows=7 cols=45><b>ffffbf</b>$txt</textarea></td></tr><tr><td>��������� ��������:</td><td><input type=\"file\" name =\"file\"  size = \"47\" accept=\"image\"></td></tr>";
	echo "<tr><td width=100% colspan=2 valign=middle align=center>";
	echo "<input type=\"hidden\" name=\"action\" value=\"addnew\">";
	$today=date ("j/n/Y");
	echo "<input type=\"hidden\" name=\"date\" value=\"$today\">";
	echo "<font size=\"-1\">�������� ��� ���������� ������</font><input type=\"checkbox\" name=\"protect\" value=\"1\">";
	echo "<br><br><font size=\"-1\">����������� ��������� ���� ��� � ����� ���������</font>";
	echo "<br><br><input type=\"submit\" value=\"���������\">&nbsp;&nbsp;<input type=\"reset\" value=\"��������\"></td></tr>";
	echo "</table></form></center></body>";
	}
	if (isset($_REQUEST['g']) && $_REQUEST['g']=="1") //���� ���� ������� ����� �� ������ �� ���������� ����������� ��������� if
	        {
	            	$data=$_FILES['file'];//�������� ���� ������������ �� ������
	            	$tmp=$data['tmp_name'] ;  //�������� ��� ���������� ���� ������������� �� ������
	            	if (@file_exists($tmp))   //���� ���� ����������   �� ���������� ����������� ��������� if
	            	{

	            	            $info=@getimagesize($_FILES['file']['tmp_name']);  //�������� ���������� � �����
	            	            if (preg_match('{image/(.*)}is',$info['mime'],$p)) //���� ���� - �����������   �� ���������� ����������� ��������� if
	            	            {  if (($data['size']/1024)<=100)//���� ������ ����� ������ 100 �����  �� ���������� ����������� ��������� if
	            	             {

	            	                   if (isset($_REQUEST['protect']))//���� ���� ������ ������ �������� ���������� ������  �� ���������� ����������� ��������� if
	            	                   {
	                                     $rt= "1";
	    	                          }
	    	                             else
	    	                            {
	    	                         $rt= "0";
	    		                          }
	                     $vrem=time();//�������� ������� �����
	                     mysql_query("INSERT INTO $tablename SET   name='".$_REQUEST['name']."', text='".$_REQUEST['msg']."', tel='".$_REQUEST['tel']."',  mail='".$_REQUEST['mail']."',  protect='".$rt."', isImg='".$p[1]."'" )or die ("�� ������� �������� ������: ".mysql_error());//�������� ����� ������ � �������
	                     $id=mysql_insert_id();//�������� id ������
	                     $name="$imgDir/".$id.".".$p[1]; //������� ���� � ��� � ����� �����������
	                     move_uploaded_file($tmp,$name);    //��������� ���� � ���������� �� ��������� �����	            	     echo "<html><body><center><h1><br><br><br><br>���� ���������� ���������, �������.</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">��������� � ��������� �������� �����</a></center></body></html>";
	                          	  }
	                          	    else
	                          	  {
	                          		echo "<html><body><center><h1><br><br><br><br>������� �������� ���� ������������� �������</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">��������� � ��������� �������� �����</a><a href=". $_SERVER['PHP_SELF']."?action=add>�������� ���������</a></center></body></html>";
	                          	  }
	                          	}
	                          	else
	                          	{	                          		echo "<html><body><center><h1><br><br><br><br>������� �������� ���� ������������� �������</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">��������� � ��������� �������� �����</a><a href=". $_SERVER['PHP_SELF']."?action=add>�������� ���������</a></center></body></html>";
	                          	}	            	}
	                else
	                {

	                 if (isset($_REQUEST['protect'])) //���� ���� ������ ������ �������� ���������� ������  �� ���������� ����������� ��������� if
	                 {
	                               $rt= "1";
	    	               }
	    	               else
	    	               {
	    	                    $rt= "0";
	    		           }
	                    $vrem=time(); //�������� ������� �����
	                    mysql_query("INSERT INTO $tablename SET   name='".$_REQUEST['name']."', text='".$_REQUEST['msg']."', tel='".$_REQUEST['tel']."',  mail='".$_REQUEST['mail']."',  protect='".$rt."', isImg='0'" )or die ("�� ������� �������� ������: ".mysql_error());//�������� ����� ������ � �������
	                    echo "<html><body><center><h1><br><br><br><br>���� ���������� ���������, �������.</h1><br><br><a href=\"". $_SERVER['PHP_SELF']."\">��������� � ��������� �������� �����</a></center></body></html>";

	             	}

	 }
	?>