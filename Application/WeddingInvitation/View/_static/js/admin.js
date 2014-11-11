var wd = {};

wd.ajaxload = function (obj){
    if("undefined" == typeof(callback)){
        callback = "location.href = location.href;";
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

wd.delGuest = function (gid) {
	if (confirm('确定要删除这个嘉宾么?')){
		$.post(U('WeddingInvitation/Admin/delGuest'),
				   {id:gid},
				   function(msg){
					   wd.ajaxload(msg);
				   },
				   'json'
			);
	}
}