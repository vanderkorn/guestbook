	// @creation_date 5.03.07
	// @modification_date 12.03.07
	// @author Kornilov Ivan
	// @document check.php
	// ������ �������� ������������ ���������� �����
	// @version 0.2
	 	function bold2()
	{
           var range = document.selection.createRange();
           var range2 =range.htmlText;
                        alert( range.parentElement().type );
                        alert( range.boundingLeft );
            var  range3= range2.bold();
                 alert(range3);
                        range.text=range2.bold();
                            var sdt=document.getElementById('msg').firstChild.nodeValue;
                            sdr="<b> ggg</b>";
                       alert(document.getElementById('msg').firstChild.nodeValue) ;
                            document.getElementById('msg').firstChild.nodeValue= eval(sdr);
                                               //  document.selection.pasteHTML("<b>textedit</b>");
               // .pasteHTML(range3);
              // alert(range2);
	}
		function ital()
	{

	}
	function emptyField(txt)//������� �������� ���������� ����
	{
	if (txt.value.length==0)return true;//��������� ���������� �������� � ���� � ���� �������� ��� � ���� �� ������������ true
	 for (var i=0;i<txt.value.length;++i)
		{
		 var ch=txt.value.charAt(i);//�������� �������� �� ����
		 if (ch!=' ' && ch!='\t' )return false//��������� ������� �������� ' '  � '\t' � ���� �� ��� �� ��������� ��� ����  ��������� � ������������ false
		}
		 return true;//���� �� ��������� ������������ true
	}
	function emptyFieldTel(txt)	 //������� �������� ���������� ����	 �������
	{
			 var regExpObj=/[\d\-\(\)]/i;	//������ ��� ������ ���� ������ - ( )

										 if (regExpObj.exec(txt.value)!=null){return false;}
		  return true;//���� �� ��������� ������������ true
	}
	function check(frm)//������� ���������� ��� �������� �����
	{
	if (emptyField(frm.name)){alert("������� ��� ����������� ����");} //�������� ���������� �����
	else
	{      if (emptyField(frm.msg)){alert("������� ����� ���������");}  //�������� ���������� ������ ���������
	else
	{
	       if (!emptyField(frm.tel))  //�������� ���������� ������ ��������
	       {	       	    if (emptyFieldTel(frm.tel)) //�������� ������������ ���������� ������ ��������
	       	    {
	       	           alert("�� ����� ������������ ����� ��������");	       	    	}
	       	    	else
	       	    	{
	       	    	         if (!emptyField(frm.mail))//�������� ���������� ����� ������������ �����
	                                  {
	             		var regExpObj=/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i;

										 if (regExpObj.exec(frm.mail.value)==null) //�������� ������������ ���������� ����� ������������ �����
										 {
										 	alert("������� ������ E-Mail. ��������� ���������.");

										 }
										 else
										 {
										       return true;//���� �������� ������ ������� �����	  ������������;

										 	}
										 	}
										 	else
										 	{
										 	    return true; //���� �������� ������ ������� �����	  ������������;

	     	}

	       	    		}	       }
	     else
	     {

	               if (!emptyField(frm.mail))  //�������� ���������� ����� ������������ �����
	                                  {
	             	var regExpObj=/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i;

										 if (regExpObj.exec(frm.mail.value)==null) //�������� ������������ ���������� ����� ������������ �����
										 {
										 	alert("������� ������ E-Mail. ��������� ���������.");

										 }
										 else
										 {
										       return true;//���� �������� ������ ������� �����	  ������������;
	                                     }
										 	}
										 	else
										 	{
										 	    return true; //���� �������� ������ ������� �����	  ������������;
	                                       }

	                }
	              }

	}
	  return false;//���� �������� ������ �� ������ ����� �� ������������
	}