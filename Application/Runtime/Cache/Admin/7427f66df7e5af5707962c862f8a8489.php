<?php if (!defined('THINK_PATH')) exit();?><ul class="MenuList" id="root_<?php echo ($menu['id']); ?>" >
   	<!-- 第二级菜单 -->
    <li class="treemenu">
       <a id="root_<?php echo ($menu['id']); ?>" class="actuator" href="javascript:void(0)" onClick="switch_root_menu('<?php echo ($menu['id']); ?>');" hidefocus="true" style="outline:none;"><?php echo ($menu['title']); ?></a>
         <ul id="tree_<?php echo ($menu['id']); ?>" class="submenu">
	          	<?php foreach($menu['submenu'] as $k => $v) { ?>
			      <li>
			      	<a id="menu_<?php echo ($v['id']); ?>" href="javascript:void(0)" onClick="switch_sub_menu('<?php echo ($v['id']); ?>', '<?php echo ($v['url']); ?>');" class="submenuA" hidefocus="true" style="outline:none;"><?php echo ($v['title']); ?></a>
			      </li>
				<?php } ?>
          </ul>
	</li>
</ul>