<?php /* Smarty version 2.6.16, created on 2014-07-13 14:22:51
         compiled from board/board.index.tpl */ ?>
<?php echo $this->_tpl_vars['breadcrumbs']; ?>

<!--<div class="b_block"></div>
<div class="b_block"></div>
<div class="b_block"></div>-->
<table width="100%" border="0">

  <tr>
    <td width="33%"><h1 style="margin-bottom: -5px;">Продается</h1><a href="/board/addauto/" style="color: green;">продать</a>
  </tr>

  <tr>
    <td>
    <?php $_from = $this->_tpl_vars['bikeMarks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <a href="/board/listauto/trademark/<?php echo $this->_tpl_vars['item']; ?>
/"><?php echo $this->_tpl_vars['item']; ?>
</a>&nbsp;
    <?php endforeach; endif; unset($_from); ?><br>
    </td>
  </tr>

  <tr>
    <td>
      <table width="100%" border="1" style="border-style: solid; border-width: 1px; border-color: #c7d9d6;">
        <tr style="background-color: #33445a; color: white; text-align: center;">
          <td width="25px">Фото</td>
          <td width="">Модель</td>
          <td width="60px">Цена</td>
        </tr>
      <?php $_from = $this->_tpl_vars['bikeList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ad']):
?>
        <tr>
          <td><?php if ($this->_tpl_vars['ad']->hasImages() != 0): ?>
            <center><img src="/images/photo.gif"></center><?php endif; ?></td>
          <td><a href="/board/item/auto/<?php echo $this->_tpl_vars['ad']->getId(); ?>
.html"><?php echo $this->_tpl_vars['ad']->title; ?>
</a></td>
          <td>
            <center><?php echo $this->_tpl_vars['ad']->getPrice(); ?>
</center>
          </td>
        </tr>
      <?php endforeach; endif; unset($_from); ?>
      </table>
      <a href="/board/listauto/">Смотреть все</a>
    </td>
  </tr>
</table>


<div style="height:300px;"></div>
<div id="clear"></div>