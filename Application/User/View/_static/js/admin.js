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
