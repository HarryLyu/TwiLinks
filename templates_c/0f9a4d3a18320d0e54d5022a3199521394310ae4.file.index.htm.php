<?php /* Smarty version Smarty-3.0.8, created on 2012-02-05 02:49:15
         compiled from "./tpl\index.htm" */ ?>
<?php /*%%SmartyHeaderCode:263914f2d99cbb0a0b2-96396831%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f9a4d3a18320d0e54d5022a3199521394310ae4' => 
    array (
      0 => './tpl\\index.htm',
      1 => 1328388552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '263914f2d99cbb0a0b2-96396831',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!doctype html>
<html>
<head>
	<title>TwiLinks</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/kickstart.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
</head>
<body>

<div class="clearfix"></div>

<div id="wrap" class="clearfix">
<?php if (LoginController::isLogined()){?>
	
	<a href="/login/logout" class="btn red" style="float: right;" id="logoutButton"><span class="icon"><span aria-hidden="true">x</span></span>Logout</a>


	<h3>Hi, <?php echo $_smarty_tpl->getVariable('user')->value->name;?>
!</h3>
	
	<?php if (count($_smarty_tpl->getVariable('links')->value)==0){?>
		<p>You have no links at this time =( Just add one using this form:</p>
		<table cellspacing="0" cellpadding="0" style="display: none;" id="linksTable">
	<?php }else{ ?>
		<table cellspacing="0" cellpadding="0" id="linksTable">
	<?php }?>
		<thead><tr>
		<th>Link address</th>
		<th>Description</th>
		<th class="actions"></th>
	</tr></thead>

	<tbody>
	
	<?php  $_smarty_tpl->tpl_vars['link'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('links')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['link']->key => $_smarty_tpl->tpl_vars['link']->value){
?>
	<tr>
		<td><a href="go/<?php echo $_smarty_tpl->getVariable('link')->value->getId();?>
" target="_blank"><?php echo $_smarty_tpl->getVariable('link')->value->link;?>
</a><br>
			<span class="date">Last edit: <?php echo date('H:i d.m.Y',$_smarty_tpl->getVariable('link')->value->add_date);?>
</span>
		</td>
		<td><?php echo $_smarty_tpl->getVariable('link')->value->description;?>
</td>
		<td class="actions" data-linkId="<?php echo $_smarty_tpl->getVariable('link')->value->getId();?>
">
			<a href="#" class="edit" title="Edit this link"><span class="icon green small"><span aria-hidden="true">7</span></span></a>
			<a href="#" class="delete" title="Delete this link"><span class="icon red small"><span aria-hidden="true">T</span></span></a>
			<a href="#" class="twitter" title="Share on Twitter"><span class="icon social blue"><span aria-hidden="true">e</span></span></a>
		</td>
	</tr>
	<?php }} ?>
	</tbody>
	</table>

	<form action="" id="addForm">
		<input type="hidden">
<a class="btn small pink" style="float: right; margin-top: 10px;" href="javascript:window.open('<?php echo URLUtils::getSiteURL();?>
?l='+encodeURIComponent(window.location.href)+'&d='+encodeURIComponent(document.title)+'#addForm')" title="Just drag this link to your Bookmarks bar!">Bookmarklet for quick adding!</a>
		<h5>Add new link</h5>

		<label>Link address
			<input type="text" name="link" value="<?php if (isset($_GET['l'])){?><?php echo htmlspecialchars($_GET['l']);?>
<?php }?>">
		</label>

		<label>Description
			<input type="text" name="description" value="<?php if (isset($_GET['d'])){?><?php echo htmlspecialchars($_GET['d']);?>
<?php }?>">
		</label>

		<div class="notice" style="display: none;"><span class="icon medium"><span aria-hidden="true">X</span></span><span class="text"></span>
		<a href="#close" class="icon close"><span aria-hidden="true">x</span></a></div>

		<input type="submit" value="Add new link">
	</form>

	<div class="col_6">
		<h5>Popular domains since beginning of the time</h5>
		<table cellspacing="0" cellpadding="0">
	
			<thead><tr>
			<th>Domain</th>
			<th>Link count</th>
		</tr></thead>
		<tbody>
		<?php  $_smarty_tpl->tpl_vars['stat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('statAll')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['stat']->key => $_smarty_tpl->tpl_vars['stat']->value){
?>
		<tr>
			<td><a href="http://<?php echo $_smarty_tpl->tpl_vars['stat']->value['domain'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['stat']->value['domain'];?>
</a></td>
			<td><?php echo $_smarty_tpl->tpl_vars['stat']->value['count'];?>
</td>
		</tr>
		<?php }} ?>
		</tbody>
		</table>
	</div>
	
	<div class="col_6">
		<h5>Last month popular domains</h5>
		<table cellspacing="0" cellpadding="0">
	
			<thead><tr>
			<th>Domain</th>
			<th>Link count</th>
		</tr></thead>
		<tbody>
		<?php  $_smarty_tpl->tpl_vars['stat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('statAll')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['stat']->key => $_smarty_tpl->tpl_vars['stat']->value){
?>
		<tr>
			<td><a href="http://<?php echo $_smarty_tpl->tpl_vars['stat']->value['domain'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['stat']->value['domain'];?>
</a></td>
			<td><?php echo $_smarty_tpl->tpl_vars['stat']->value['count'];?>
</td>
		</tr>
		<?php }} ?>
		</tbody>
		</table>
	</div>
<?php }else{ ?>
<div class="center">
	<a href="/login/loginWithTW"><span class="icon social blue large"><span aria-hidden="true">e</span></span>Login via Twitter</a>
</div>
<?php }?>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="js/prettify.js"></script>
<script src="js/kickstart.js"></script>
<script src="js/js.js"></script>

</body>	
</html>