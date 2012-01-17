<table width="100%" height="100%" border="0" bgcolor="#F4F4F4">
  <tr>
    <td>
    
    <table width="600" border="0" cellspacing="0" cellpadding="10" align="center" bgcolor="#FFFFFF">
  <tr>
    <td height="47" bgcolor="#F4F4F4">&nbsp;</td>
  </tr>
  <tr>
    <td>
    
    
    <table width="590" height="77" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; color:#000; background-color:#FDCA01; padding-left:10px;"><h1><a href="http://agdeima.com" style="color:#000; text-decoration:none">A gde ima?</a></h1></td>
    </tr>
</table></td>
  </tr>
  <tr>
    <td height="20" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;"><br />      
       Tekst: &quot;<?php echo $this->Html->link($title, array('controller' => 'posts', 'action' => 'view', $id), array('style' => 'color:#000; text-decoration:none')); ?>&quot;</td>
  </tr>
  <tr>
    <td height="214">
    
    
    <p><font color="#333333" face="Trebuchet MS, Arial, Helvetica, sans-serif" style="font-size:14px">
    
    Označili ste da Vas obavestimo kada se objavi novi komentar posle Vašeg.<br /><br />
    Možete ga pogledati na sledećem linku: <br />
    
    </font><font face="Trebuchet MS, Arial, Helvetica, sans-serif" color="#333333" style="font-size:14px"><p><?php echo $this->Html->link('LINK', array('controller' => 'posts', 'action' => 'view', $id), array('style' => 'color:#000')); ?><br /><br /><br /><br />
    
       
    <?php echo $this->Html->link(__('Ne želim više da primam obaveštenja za ovaj tekst'), array('controller' => 'posts', 'action' => 'unsubscribe', $id), array('style' => 'color:#000; font-size:11px')); ?>    
    
    </p>
    
    
    
      </p>
    </font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="87" bgcolor="#FDCA01">
    
    
    <p align="center"><font face="Trebuchet MS, Arial, Helvetica, sans-serif" size="4" color="#ffffff">
    
    <?php echo $this->Html->link(__('Objavi gde si nešto našao'), array('controller' => 'posts', 'action' => 'add'), array('style' => 'color:#FFF')); ?> | <?php echo $this->Html->link(__('Pitaj gde nešto ima'), array('controller' => 'post', 'action' => 'add'), array('style' => 'color:#FFF')); ?></font></p>
    
    
    </td>
  </tr>
  <tr>
    <td height="28" bgcolor="#FDCA01">
    
    <p align="center"><font face="Trebuchet MS, Arial, Helvetica, sans-serif" size="-1" color="#ffffff">
    
    agdeima.com | since 2008.</font></p></td>
  </tr>
  <tr>
    <td height="100" bgcolor="#F4F4F4">&nbsp;</td>
  </tr>
    </table>

    
    </td>
  </tr>
</table>