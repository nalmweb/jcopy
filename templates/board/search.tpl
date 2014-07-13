<br/>
<div style="border:solid 0px #555;">
  <form class="fc22" action="/board/listauto/" method="POST" name="search_bikes">
    <fieldset>
      <legend>Поиск</legend>
      <table border="2" width="700px">
        <tr>
          <td><label>Марка:</label>
            <select name="markId" style="width:150px;" id="markId"
                    onclick="xajax_changeTrademark(this.options[this.selectedIndex].value);">
            {html_options values=$mark_ids selected=$mark_id output=$mark_names}
            </select>
          </td>
        </tr>
        <tr>
          <td><label>Модель:</label>
            <select name="modelId" style="width:150px;" id="modelId">
            </select>
          </td>
        </tr>
        <tr>
          <td><label>Тип:</label>
            <select name="typeId" style="width:150px;" id="typeId">
            {html_options values=$type_ids selected=$type_id output=$type_names}
            </select>
          </td>
        </tr>
        <tr>
          <td nowrap>
            <label>Цена:</label>
            <input type="text" value="" name="price[from]" size="7" maxlength="7"/>–<input type="text" value=""
                                                                                           name="price[to]" size="7"
                                                                                           maxlength="7"/>
        </tr>
        <tr>
          <td nowrap>
            <label>Пробег, км:</label>
            <input type="text" value="" name="probeg[from]" size="7" maxlength="7"/>–<input type="text" value=""
                                                                                            name="probeg[to]" size="7"
                                                                                            maxlength="7"/>
          </td>
        </tr>
        <tr>
          <td nowrap><label>Год выпуска:</label>
            <select name="year[from]" style="width:68px;">
              <option value="2008" selected="selected">2008</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
              <option value="2013">2013</option>
              <option value="2012">2012</option>
              <option value="2011">2011</option>
              <option value="2010">2010</option>
              <option value="2009">2009</option>
              <option value="2008">2008</option>
              <option value="2007">2007</option>
              <option value="2006">2006</option>
              <option value="2005">2005</option>
              <option value="2004">2004</option>
              <option value="2003">2003</option>
              <option value="2002">2002</option>
              <option value="2001">2001</option>
              <option value="2000">2000</option>
              <option value="1999">1999</option>
              <option value="1998">1998</option>
              <option value="1997">1997</option>
              <option value="1996">1996</option>
              <option value="1995">1995</option>
              <option value="1994">1994</option>
              <option value="1993">1993</option>
              <option value="1992">1992</option>
              <option value="1991">1991</option>
              <option value="1990" selected="selected">1990</option>
            </select>-<select name="year[to]" style="width:68px;">
              <option value="2008">2008</option>
              <option value="2007">2007</option>
              <option value="2006">2006</option>
              <option value="2005">2005</option>
              <option value="2004">2004</option>
              <option value="2003" selected="selected">2003</option>
              <option value="2003">2003</option>
              <option value="2002">2002</option>
              <option value="2001">2001</option>
              <option value="2000">2000</option>
              <option value="1999">1999</option>
              <option value="1998">1998</option>
            </select>
        </tr>
        <tr>
        </tr>
        <tr>
          <td nowrap>
            <div style="margin-left:100px;"> C фото: <input type="checkbox" name="is_photo" value=""></div>
          </td>
        </tr>

        <tr>
          <td nowrap align="center">&nbsp;{submitbutton name="save" value="Искать"}</td>
        </tr>
      </table>
      <!-- </fieldset> -->
  </form>
</div>
<!--
<input type="hidden" name="year[from]"  value="20">
<input type="hidden" name=""  value="">
<input type="hidden" name=""  value="">
<input type="hidden" name=""  value="">
<input type="hidden" name=""  value=""> -->