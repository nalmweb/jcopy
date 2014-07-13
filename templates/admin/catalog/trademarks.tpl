<h1 class="orange">Управление производителями</h1>
<p>Здесь вы можете добовлять или изменять производителей техники</p>
<br/>


<div class="black_box mTop10 radius">
    <div class="inner">


        <div>
            <div id="ajaxContent" style="display: none">{$ajaxContent}<div class="clear"></div></div>

        </div>
    {form from=$form}

        <table class="sTable">
            <tr class="first">
                <td class="tleft">Лого</td>
                <td class="tleft">Название</td>
                <td class="tleft">Страна</td>
                <td>Операции</td>
            </tr>
            {foreach from=$marks key=key item=tm}
                <tr>
                    <td width="40" class="tleft">
                        <img src="{$tm->getLogo()->getDataPath()}" title="{$tm->getName()}" border="0"
                             style="max-width: 100px"/><br/>
                        {form_hidden value=$tm->getLogo()->getId() name="trademarks["|cat:$tm->getId()|cat:"][logo_id]"}
                    </td>
                    <td class="tleft">
                        {form_text value=$tm->getName() name="trademarks["|cat:$tm->getId()|cat:"][name]" style="width: 150px;"}
                    </td>
                    <td class="tleft">
                        {form_select id=country selected=$tm->getIdCountry() options=$countries name="trademarks["|cat:$tm->getId()|cat:"][country_id]" style="width: 150px;"}
                    </td>
                    <td width="40">
                        <div id="tm_{$tm->getId()}_logo">
                            <a href="#" onclick="xajax_changeTMLogo({$tm->getId()}); return false;">Добавить/Изменить
                                лого</a>
                        </div>
                    </td>
                </tr>
            {/foreach}
            <tr>
                <td colspan="4" align="center" width="40">
                    {form_submit value="Сохранить" name="Сохранить"}
                </td>
            </tr>
        </table>
    {/form}

    </div>
</div>

<br/>

<div class="black_box mTop10 radius">
    <div class="inner">
        <div class="form">
            <div class="text">
                НОВАЯ ЗАПИСЬ
                <form method="POST" action="/admin/trademarks/" enctype="multipart/form-data">
                    <table width="300" style="width: 300px;">
                        <tr>
                            <td width="50%" class="tright">Название</td>
                            <td>{form_text name=trademarks[new][name]}</td>
                        </tr>
                        <tr>
                            <td class="tright">Страна</td>
                            <td>{form_select id=country options=$countries name="trademarks[new][country_id]" style="width: 150px;"}</td>
                        </tr>
                        <tr>
                            <td class="tright">Лого</td>
                            <td>
                                <input type="file" name="new"/>
                                {form_hidden name="trademarks[new][logo_id]"}
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2"><input type="submit" name="submit" value="Добавить"></td>
                        </tr>
                    </table>
                </form>

            {literal}
                <script type="text/javascript">
                    function openMyDialog(id) {
                        $('#' + id).modal();
                    }
                </script>
            {/literal}


            </div>
        </div>
    </div>
</div>