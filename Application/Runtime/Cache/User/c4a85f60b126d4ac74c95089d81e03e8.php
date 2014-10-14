<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--  
<link href="<?php echo APPS_URL;?>/admin/_static/admin.css" rel="stylesheet" type="text/css">
-->
<link href="/Application/Admin/View/_static/css/admin.css" rel="stylesheet" type="text/css">

<script>
/**
 * 全局变量
 */
var SITE_URL       = '<?php echo SITE_URL;?>';
var PUBLIC_STATIC  = '<?php echo PUBLIC_STATIC; ?>';
var APPNAME        = '<?php echo MODULE_NAME; ?>';
var UID            = '<?php echo $uid; ?>';
var LANG           = new Array();
</script>

<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/core.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/module.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/module.common.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/module.weibo.js"></script>
<script type="text/javascript" src="/Application/Admin/View/_static/js/admin.js?t=11"></script>
<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/ui.core.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_STATIC;?>/js/ui.draggable.js"></script>

<?php  if(MODULE_NAME != 'Admin' && file_exists('.'.MODULE_STATIC.'/js/admin.js')){ ?>
<script type="text/javascript" src="<?php echo MODULE_STATIC;?>/js/admin.js"></script>
<?php } ?>
<?php if(!empty($langJsList)) { ?>
<?php if(is_array($langJsList)): $i = 0; $__LIST__ = $langJsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><script src="<?php echo ($vo); ?>"></script><?php endforeach; endif; else: echo "" ;endif; ?>
<?php } ?>
</head>
<body>
<div id="container" class="so_main">
  <div class="page_tit">
    <?php if(true){ ?>
    <span onclick="admin.fold('page_config')"><?php echo L('PUBLIC_PAGE_CONFIGURATION');?></span>
    <?php } ?>
    <?php echo ($pageTitle); ?> 
  </div>
  	<!-- START PAGE_CONFIG -->
  	<div id='page_config' class = "form2 list" >
  		<div class="hd"><?php echo L('PUBLIC_CHECH_IS');?></div>
  		<form action="<?php echo ($savePageConfigUrl); ?>" method="POST">
  		<input type="hidden" name='pageKey' value="<?php echo ($pageKey); ?>" />
  		<input type="hidden" name='pageTitle' value="<?php echo ($pageTitle); ?>" />
  		<table width="100%" cellpadding="0" cellspacing="0" border="0">
  			<tr>
  				<th><?php echo L('PUBLIC_SYSTEM_FIELD');?></th>
  				<th class="line_l"><?php echo L('PUBLIC_ADMIN_TITLE');?></th>
  				<th class="line_l"><?php echo L('PUBLIC_ADMIN_TYPE');?></th>
  				<th class="line_l"><?php echo L('PUBLIC_ADMIN_MODIFY');?></th>
  				<th class="line_l"><?php echo L('PUBLIC_ADMIN_INFO');?></th>
  				<th class="line_l"><?php echo L('PUBLIC_ADMIN_NOTHING');?></th>
  			</tr>
  			<?php if(is_array($pageKeyList)): $i = 0; $__LIST__ = $pageKeyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pk): $mod = ($i % 2 );++$i; $key = is_array($pk) ? $pk[0] : $pk; $keyType = $pageKeyData['key_type'][$key]; if(is_array($pk)){ $pk = $pk[0];} ?>
  			<tr overstyle="on">
  				<td> <input type="hidden" name='key[]' value='<?php echo ($pk); ?>'> <?php echo ($pk); ?></td>
  				<td><input type="text" name='key_name[]' value='<?php echo ($pageKeyData['key_name'][$key]); ?>'  class="s-txt"/></td>
  				<td><select name='key_type[]'>
  					<option value='text' <?php if(($keyType) == "text"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_INPUT_TEXT');?></option>
  					<option value='password' <?php if(($keyType) == "password"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_INPUT_PASSWORD');?></option>
  					<option value='select' <?php if(($keyType) == "select"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_SELECT');?></option>
  					<option value='radio' <?php if(($keyType) == "radio"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_RADIO');?></option>
  					<option value='checkbox' <?php if(($keyType) == "checkbox"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_CHAECKBOX');?></option>
  					<option value='date' <?php if(($keyType) == "date"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_DATE');?></option>
  					<option value='textarea' <?php if(($keyType) == "textarea"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_TEXTAREA');?></option>
            		<option value='editor' <?php if(($keyType) == "editor"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_EDITOR');?></option>
  					<option value='word' <?php if(($keyType) == "word"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_WORD');?></option>
  					<option value='hidden' <?php if(($keyType) == "hidden"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_INPUT_HIDDEN');?></option>
            		<option value='image' <?php if(($keyType) == "image"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_IMAGE_FILES');?></option>
  					<option value='file' <?php if(($keyType) == "file"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_INPUT_FILE');?></option>
            		<option value='department' <?php if(($keyType) == "department"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_DEPARENT_FILES');?></option>
            		<option value='user' <?php if(($keyType) == "user"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_USER_FILSE');?></option>
            		<option value='oneUser' <?php if(($keyType) == "oneUser"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_USER_SELECT');?></option>
            		<option value='stringText'<?php if(($keyType) == "stringText"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_MODSAVE_FILES');?></option>
            		<option value='color'<?php if(($keyType) == "color"): ?>selected="selected"<?php endif; ?>>色彩框：color</option>
            		<option value='define'<?php if(($keyType) == "define"): ?>selected="selected"<?php endif; ?>><?php echo L('PUBLIC_CUSTOM_DEFINE');?></option>
  				</select></td>
  				<td><input type='text' name='key_default[]' value='<?php echo ($pageKeyData['key_default'][$key]); ?>' class="s-txt"></td>
  				<td><input type='text' name='key_tishi[]' value='<?php echo ($pageKeyData['key_tishi'][$key]); ?>' class="s-txt"></td>
  				<td><input type='text' name='key_javascript[]' value='<?php echo ($pageKeyData['key_javascript'][$key]); ?>' class="s-txt"></td>
  				<!-- 
  				<td style="background-color:#1E325C">
  				<a onclick="admin.moveUp($(this))" class="ico_top" title="上移"><img src="<?php echo THEME_PUBLIC_URL;?>/admin/image/zw_img.gif"></a> &nbsp;&nbsp;
  				<a onclick="admin.moveDown($(this))" class="ico_btm" title="下移"><img src="<?php echo THEME_PUBLIC_URL;?>/admin/image/zw_img.gif"></a>
  				</td> -->
  			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
  		</table>
  		<div class="page_btm">
	      <input type="submit" class="btn_b" value="<?php echo L('PUBLIC_CONFIRM');?>" />
	    </div>
	    </form>
  	</div>
  	<!-- END PAGE_CONFIG -->
  
   <!-- START TAB框 -->
  <?php if(!empty($pageTab)): ?>
  <div class="tit_tab">
    <ul>
    <?php !$_REQUEST['tabHash'] && $_REQUEST['tabHash'] = $pageTab[0]['tabHash']; ?>
    <?php if(is_array($pageTab)): $i = 0; $__LIST__ = $pageTab;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><li><a href="<?php echo (push_param_to_url($t["url"],'tabHash='.$t['tabHash'])); ?>" <?php if($t['tabHash'] == $_REQUEST['tabHash']){ echo 'class="on"';} ?>><?php echo ($t["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
  <?php endif; ?>
  <!-- END TAB框 -->
  
  <!-- START CONFIG_FORM -->
  <?php if($pageKeyData=='null'){ ?>
  	<?php echo L('PUBLIC_PLEASE');?><span onclick="admin.fold('page_config')"><?php echo L('PUBLIC_PAGE_CONFIGURATION');?></span>
  <?php }else{ ?>
  
   <form method="POST" action="<?php echo ($savePostUrl); ?>" <?php if(($onsubmit) != ""): ?>onsubmit = "return <?php echo ($onsubmit); ?>;"<?php endif; ?> id='detail_form' name='detail_form'>
  	<input type="hidden" name='systemdata_list' value="<?php echo ($systemdata_list); ?>"  class="s-txt"/>
  	<input type="hidden" name='systemdata_key' value="<?php echo ($systemdata_key); ?>"  class="s-txt"/>  
  	<input type="hidden" name='pageTitle' value="<?php echo ($pageTitle); ?>" class="s-txt" />
  	<div class="form2">
  	<?php $upkey = 1; ?>
  	<?php if(is_array($pageKeyList)): $i = 0; $__LIST__ = $pageKeyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pk): $mod = ($i % 2 );++$i; $key = $pk; $_pk = $pk; is_array($pk) && $pk = $pk[0]; $key = is_array($pk) ? $pk[0] : $pk; $defaultS = isset($detailData[$pk]) ? $detailData[$pk] : $pageKeyData['key_default'][$key]; $event = $pageKeyData['key_javascript'][$key]; $keyName = $pageKeyData['key_name'][$key] ? $pageKeyData['key_name'][$key] :$pk; $keyType = $pageKeyData['key_type'][$key] ? $pageKeyData['key_type'][$key] :'text'; if($keyType != 'hidden'): ?>
    <dl class="lineD" id='dl_<?php echo ($pk); ?>'>
      <dt><?php if(in_array($pk,$notEmpty)){ ?><font color="red"> * </font><?php } echo ($keyName); ?>：</dt>
      <dd>
    <?php endif; ?>  
      	<?php if($keyType == 'text'): ?>
      	<input name="<?php echo ($pk); ?>" id="form_<?php echo ($pk); ?>" type="text" value="<?php echo (tt($defaultS)); ?>" <?php if(($event) != ""): ?>onfocus = "<?php echo ($event); ?>"<?php endif; ?> class="s-txt" style='width:200px'>
      	<?php endif; ?>
        
        <?php if($keyType == 'password'): ?>
      	<input name="<?php echo ($pk); ?>" id="form_<?php echo ($pk); ?>" type="password" value="<?php echo ($defaultS); ?>" <?php if(($event) != ""): ?>onfocus = "<?php echo ($event); ?>"<?php endif; ?>  class="s-txt" style='width:200px'>
      	<?php endif; ?>
      	
      	<?php if($keyType == 'select'): ?>
      	<select name="<?php echo ($pk); ?>" id="form_<?php echo ($pk); ?>" <?php if(($event) != ""): ?>onchange = "<?php echo ($event); ?>"<?php endif; ?>>
      		<?php foreach($opt[$pk] as $sk=>$sv): ?>
      			<option value="<?php echo ($sk); ?>" <?php if($sk == $defaultS): ?> selected="selected" <?php endif; ?>><?php echo ($sv); ?></option>
      		<?php endforeach; ?>
      	</select>
      	<?php endif; ?>

         <?php if($keyType == 'department'): ?>
        <?php echo W('Department',array('inputName'=>$pk,'canChange'=>1,'tpl'=>'input','notop'=>1,'defaultName'=>$detailData['department_show'],'defaultId'=>intval($defaultS)));?>
        <?php endif; ?>
      	
      	<?php if($keyType == 'radio'): $nums = count($opt[$pk]); $tempi = 1; foreach($opt[$pk] as $sk=>$sv): $br = $nums >=6 && $tempi%3==0 ? '<br/>':''; $tempi++; ?>
        <label><input type="radio" name="<?php echo ($pk); ?>" value='<?php echo ($sk); ?>' <?php if($sk == $defaultS): ?> checked="checked"<?php endif; ?> <?php if(($event) != ""): ?>onclick = "<?php echo ($event); ?>"<?php endif; ?> ><?php echo ($sv); ?> </label>            		
      	<?php endforeach; ?>
        <br /> <?php echo ($br); ?>
        <?php endif; ?>
      	
      	
      	<?php  if($keyType == 'checkbox'): $defaultS = !is_array($defaultS) ? explode(',',trim($defaultS,',')) : $defaultS; foreach($opt[$pk] as $sk=>$sv): ?>	
      	<label><input type="checkbox" name="<?php echo ($pk); ?>[]" value='<?php echo ($sk); ?>' <?php if(in_array($sk,$defaultS)): ?> checked="checked"<?php endif; ?> <?php if(($event) != ""): ?>onclick = "<?php echo ($event); ?>"<?php endif; ?> ><?php echo ($sv); ?> </label>
      	<?php endforeach; endif; ?>
      	
      	
      		<?php  if($keyType == 'date'): if(is_array($_pk)){ foreach($_pk as $v=>$vv){ ?> 
          <?php echo W('DateSelect',array('name'=>$pk."[]",'class'=>'s-txt','id'=>'from_'.$pk.'_'.$v,'value'=>$defaultS[$v],'dtype'=>'full'));?>
       		<?php echo $v == (count($_pk)-1) ? '':' — '; ?>
       	<?php } }else{ ?>
      	<input name="<?php echo ($pk); ?>" type="text" class="text" id="form_<?php echo ($pk); ?>" value='<?php echo ($defaultS); ?>' onfocus="core.rcalendar(this,'full');" readonly="readonly" style="width:200px;" class="s-txt"/>
      	<?php }endif; ?>
      	
      	<?php if($keyType == 'textarea'): ?>
      	<textarea  name="<?php echo ($pk); ?>" id="form_<?php echo ($pk); ?>" rows="10" cols="80" <?php if(($event) != ""): ?>onfocus = "<?php echo ($event); ?>"<?php endif; ?>><?php echo ($defaultS); ?></textarea>
      	<?php endif; ?>

        <?php if($keyType == 'stringText'): ?>
        <?php echo W('StringText',array('inputname'=>$pk,'value'=>$defaultS));?>
        <?php endif; ?>
      	
         <?php if($keyType == 'user'): ?>
         <?php echo W('SearchUser', array('uids'=>$defaultS, 'name'=>$pk,'follow'=>0, 'max'=>0,'noself'=>0));?>  
        <?php endif; ?>

        <?php if($keyType == 'oneUser'): ?>
         <?php echo W('SearchUser', array('uids'=>$defaultS, 'name'=>$pk,'follow'=>0, 'max'=>1,'noself'=>0,));?>  
        <?php endif; ?>
        
        <?php if($keyType == 'editor'): ?>
        <?php echo W('Editor',array('width'=>'99%','height'=>'200','contentName'=>$pk,'value'=>$defaultS));?> 
        <?php endif; ?>

      	<?php if($keyType == 'word'): ?>
      	<input name="<?php echo ($pk); ?>" id="form_<?php echo ($pk); ?>" type="hidden" value="<?php echo ($defaultS); ?>" class="s-txt">
      		<label <?php if(($event) != ""): ?>onclick= "<?php echo ($event); ?>"<?php endif; ?>> &nbsp;<?php echo ($defaultS); ?></label>
      	<?php endif; ?>
      	
      	<?php if($keyType == 'hidden'): ?>
      	<input name="<?php echo ($pk); ?>" id="form_<?php echo ($pk); ?>" type="hidden" value="<?php echo ($defaultS); ?>" class="s-txt">
      	<?php endif; ?>

        <?php if($keyType === 'color'): ?>
        <?php echo W('Color', array('value'=>$defaultS, 'id'=>$pk));?> 
        <?php endif; ?>

        <?php if($keyType == 'define'): ?>
          <?php echo ($detailData[$pk]); ?>
        <?php endif; ?>
      	
      	<?php if($keyType == 'image'): ?>
      	<!--  上传插件 -->
	
      	<div>
      	<!-- <FORM style='display:inline;padding:0;margin:0;border:0'>  -->
			<div id="divup_<?php echo ($upkey); ?>" type="file" rel="<?php echo ($upkey); ?>">
			<input type="file" name="attach" rel="<?php echo ($upkey); ?>" onchange="admin.upload('<?php echo ($pk); ?>',this)" urlquery='attach_type=feed_image&upload_type=image&thumb=1'></div>
           <div id='show_<?php echo ($pk); ?>'>
            <?php if($defaultS && is_numeric($defaultS)){ ?>
              <img src="<?php echo (getimageurlbyattachid($defaultS)); ?>" class="pic-size">
            <?php }elseif (in_array($defaultS, array('level1.png', 'level2.png', 'level3.png', 'level4.png', 'level5.png', 'level6.png', 'level7.png', 'level8.png', 'level9.png', 'level10.png'))){ ?>
              <img src="__THEME__/image/level/<?php echo ($defaultS); ?>" class="pic-size" />
            <?php } ?>
          </div>
           <input name="<?php echo ($pk); ?>" id="form_<?php echo ($pk); ?>" type="hidden" value="<?php echo ($defaultS); ?>" class="s-txt" style="width:200px;" <?php if(($event) != ""): ?>onchange="<?php echo ($event); ?>"<?php endif; ?>/>
		   <!-- </FORM> -->
    		</div>    
		<?php ++$upkey; ?>
      	<?php endif; ?>


        <?php if($keyType == 'file'): ?>
        <div>

        <?php echo W('Upload',array('uploadType'=>'file','inputname'=>$pk,'attachIds'=>$defaultS));?>
        </div>
        <?php endif; ?>
      	
        <?php if(!empty($pageKeyData['key_tishi'][$key])){ ?>
        <p><?php echo ($pageKeyData['key_tishi'][$key]); ?></p>
        <?php } ?>
       
    <?php if($keyType != 'hidden'): ?> 
    </dd>
    </dl>
    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
    
    
    <div class="page_btm" >
    <input type='text' style="display:none">
      <input type="button" class="btn_b" value="<?php echo ($submitAlias); ?>" id='form_submit' onclick = "submitform()"/>
      
    </div>
  	</div>
  	</form>
  	
   <?php } ?>
   <!-- END CONFIG_FORM -->
</div>
<script>
function submitform(){
	$('#detail_form').submit();
}
</script>
<?php if(!empty($onload)){ ?>
<script type="text/javascript">
/**
 * 初始化对象
 */
//表格样式
$(document).ready(function(){
    <?php foreach($onload as $v){ echo $v,';';} ?>
});
</script>
<?php } ?>

<?php if(ACTION_NAME == 'feed'): ?>
<script type="text/javascript">

//core.loadFile(THEME_URL+'/js/plugins/core.weibo.js', function () {
core.loadFile('<?php echo PUBLIC_STATIC;?>/js/plugins/core.weibo.js', function(){
	setTimeout(function () {
        // 重写方法
        core.weibo.showBigImage = function (a, b) {
            var $parent = $('#tr' + a).find('div[model-node="feed_list"]');
            $parent.find('div').each(function () {
                var relVal = $(this).attr('rel');
                if (relVal == 'small') {
                    $(this).hide();
                } else if (relVal == 'big') {
                    $(this).show();
                }
            });
        };
	}, 1000);
});
</script>
<?php endif; ?>

</body>
</html>