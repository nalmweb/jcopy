{strip}

<a href="/admin/catalog/"><< К меню каталога</a><br />
<div class='clear' style="padding:10px;"><span /></div>
{form from=$form}
<table align="center" width="70%" cellspacing="0" cellpadding="0" border="1">
<tr>
    <th>Свойство</th>
    <th>Просмотр в краткой форме</th>
    <th>Просмотр в списке</th>
    <th>Просмтор в полной форме</th>
    <th>Просмтор в доске объявлений</th>
</tr>
{foreach from=$propList item=p}
<tr>
    <td>{$p->getName()}</td>
    <td>{form_checkbox name=short id="short"|cat:$p->getId()|cat:"" onClick="xajax_checkProp("|cat:$p->getId()|cat:", this.name ); return false;" value=1  checked = $p->getShortView()}</td>
    <td>{form_checkbox name=list id="list"|cat:$p->getId()|cat:"" onClick="xajax_checkProp("|cat:$p->getId()|cat:", this.name ); return false;" value=1 checked = $p->getListView()}</td>
    <td>{form_checkbox name=full id="full"|cat:$p->getId()|cat:"" onClick="xajax_checkProp("|cat:$p->getId()|cat:", this.name ); return false;" value=1 checked = $p->getFullView()}</td>
    <td>{form_checkbox name=bboard id="bboard"|cat:$p->getId()|cat:"" onClick="xajax_checkProp("|cat:$p->getId()|cat:", this.name ); return false;" value=1 checked = $p->getBboardview()}</td>
</tr>
{/foreach}
</table>
{/form}
{/strip}