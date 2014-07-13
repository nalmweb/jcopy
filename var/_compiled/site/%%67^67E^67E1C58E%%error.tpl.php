<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:40
         compiled from error.tpl */ ?>

    <div style="padding:20px;">
    <br>
    <b style='color:#CB0000'><?php echo $this->_tpl_vars['error']->getMessage(); ?>
</b>
    </br>
    <b>File :</b> <?php echo $this->_tpl_vars['error']->getFile(); ?>

    </br>
    <b>Line :</b> <?php echo $this->_tpl_vars['error']->getLine(); ?>

    </br>
    </div>
