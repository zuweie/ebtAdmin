/**
 * User 后台JS操作对象 -
 * 
 * 后台所有JS操作都集中在此
 */

var user = {};

user.ajaxload = function (obj){

    if("undefined" == typeof(callback)){
        callback = "location.href = location.href";
    }else{
        callback = 'eval('+callback+')';
    }
    if(obj.status == 1){
        ui.success(obj.data);
        setTimeout(callback,1500);
     }else{
        ui.error(obj.data);
    }

}

user.del = function (id) {
	
	if(confirm('确认删除这个用户么?')){
		$.post(U('User/Admin/delUser'),
			   {id:id},
			   function(msg){
				   user.ajaxload(msg);
			   },
			   'json'
		);
	}
}

user.delUserPrivilege = function (upid) {
	if (confirm('确定要删除用户的这个权限?')){
		$.post(U('User/Admin/delUserPrivilege'),
				{upid:upid},
				function (msg){
					user.ajaxload(msg);
				},
				'json'
		);
	}
}

user.delGroupPrivilege = function (gpid) {
	if (confirm('确定要删除用户组的这个权限?')){
		$.post(U('User/Admin/delGroupPrivilege'),
				{id:gpid},
				function (msg){
					user.ajaxload(msg);
				},
				'json'
		);
	}
}

user.delPrivilege = function (pid) {
	if (confirm('确定要删除这个权限?')){
		$.post(U('User/Admin/delPrivilege'),
				{id:pid},
				function (msg){
					user.ajaxload(msg);
				},
				'json'
		);
	}
}

