{strip}
    <div>
        <input class="button" type="submit"  {foreach from=$params item=value key=key} {$key}="{$value}"{/foreach}/>
    </div>
{/strip}