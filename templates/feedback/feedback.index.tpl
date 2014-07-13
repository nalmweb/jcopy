<center>
<form action="/feedback/send/" method="POST" id="feedback">
<table width="530px"  border="0">
 <tr><td class="col_left" colspan="2" align="center"><div class="new"><h3>Связь с нами</h3></div></td></tr>
 <tr><td colspan="2"><h4>Мы рады тому, что вы хотите нам что-то сообщить. Заполните, пожалуйста, форму ниже и не забудьте указать контакты.<br />Ответ не заставит себя долго ждать.</h4></td></tr>
  <tr>
   	   <td width="150px" >Категория сообщения:</td>
   		<td>
   		   <select name="subject"  id="subject"  style="width:200px;">
			  <option value="добавить новую модель">добавить новую модель</option>
   			  <option value="ошибка на сайте">ошибка на сайте </option>
   			  <option value="сотрудничество">сотрудничество </option>
   			  <option value="пожелание">пожелание</option>
   			  <option value="другое">другое</option>
  		   </select>
	</td></tr>
	<tr>
		<td>Контакты для связи: </td>
		<td><input type="text" name="contacts" value="" maxlength="100" style="width:200px;"></td>
	</tr>	
	<tr>
		<td>Сообщение:</td>
		<td>
			<textarea style="width: 380px;" rows="20" maxlength="500" name="message"></textarea>
		</td>	
	</tr>
	<tr><td></td><td align="center"> <input type="submit" name="submit" value="Отправить" >
	{*subtmibutton name="Отправить"  onclick="xajax_sendEmail(xajax.getFormValues('feedback'))"*}</td></tr>
</table>
</form>
</center>