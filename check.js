	// @creation_date 5.03.07
	// @modification_date 12.03.07
	// @author Kornilov Ivan
	// @document check.php
	// скрипт проверки правильности заполнения формы
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
	function emptyField(txt)//функция проверки заполнения поля
	{
	if (txt.value.length==0)return true;//проверяет количество символов в поле и если символов нет в поле то возвращается true
	 for (var i=0;i<txt.value.length;++i)
		{
		 var ch=txt.value.charAt(i);//выбирает символов из поля
		 if (ch!=' ' && ch!='\t' )return false//проверяет наличие символов ' '  и '\t' и если их нет то считается что поле  заполнено и возвращается false
		}
		 return true;//поле не заполнено возвращается true
	}
	function emptyFieldTel(txt)	 //функция проверки заполнения поля	 телефон
	{
			 var regExpObj=/[\d\-\(\)]/i;	//шаблон для поиска цифр знаков - ( )

										 if (regExpObj.exec(txt.value)!=null){return false;}
		  return true;//поле не заполнено возвращается true
	}
	function check(frm)//функция вызываемая при отправки формы
	{
	if (emptyField(frm.name)){alert("Введите ИМЯ контактного лица");} //проверка заполнения имени
	else
	{      if (emptyField(frm.msg)){alert("Введите текст сообщения");}  //проверка заполнения текста сообщения
	else
	{
	       if (!emptyField(frm.tel))  //проверка заполнения номера телефона
	       {	       	    if (emptyFieldTel(frm.tel)) //проверка правильности заполнения номера телефона
	       	    {
	       	           alert("Вы ввели неправильный номер телефона");	       	    	}
	       	    	else
	       	    	{
	       	    	         if (!emptyField(frm.mail))//проверка заполнения имени электронного ящика
	                                  {
	             		var regExpObj=/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i;

										 if (regExpObj.exec(frm.mail.value)==null) //проверка правильности заполнения имени электронного ящика
										 {
										 	alert("Неверно указан E-Mail. Проверьте написание.");

										 }
										 else
										 {
										       return true;//если проверка прошла успешна форма	  отправляется;

										 	}
										 	}
										 	else
										 	{
										 	    return true; //если проверка прошла успешна форма	  отправляется;

	     	}

	       	    		}	       }
	     else
	     {

	               if (!emptyField(frm.mail))  //проверка заполнения имени электронного ящика
	                                  {
	             	var regExpObj=/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i;

										 if (regExpObj.exec(frm.mail.value)==null) //проверка правильности заполнения имени электронного ящика
										 {
										 	alert("Неверно указан E-Mail. Проверьте написание.");

										 }
										 else
										 {
										       return true;//если проверка прошла успешна форма	  отправляется;
	                                     }
										 	}
										 	else
										 	{
										 	    return true; //если проверка прошла успешна форма	  отправляется;
	                                       }

	                }
	              }

	}
	  return false;//если проверка прошла не удачно форма не отправляется
	}