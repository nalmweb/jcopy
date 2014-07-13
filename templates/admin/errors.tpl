{if $errors}
<div class="black_box radius" style="margin-bottom: 10px;">
  <div class="inner" style="background-color: #FBE1E3">
    <div class="form">
      <img src="/images/docbox_error.gif" width="29" height="27" alt="" style="position: absolute"/>
      <div style="padding-left: 40px">
        <h1 style="margin: 0px; color: #CC0000; ">{$errors}</h1>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
{/if}

{if $success}
<div class="black_box radius" style="margin-bottom: 10px;">
  <div class="inner" style="background-color: #bbffbd">
    <div class="form">
      <img src="/images/docbox_success.gif" width="29" height="27" alt="" style="position: absolute"/>
      <div style="padding-left: 40px">
        <h1 style="margin: 0px; color: #1db01d; ">{$success}</h1>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
{/if}