/**
 * Zdl 后台JS操作对象 -
 * 
 * 后台所有JS操作都集中在此
 */

var zdl = {};

zdl.ajaxload = function (obj){

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

zdl.delType = function (id) {
	
	if(confirm('确认删除这个类型么?')){
		$.post(U('Zdl/Admin/delType'),
			   {id:id},
			   function(msg){
				   zdl.ajaxload(msg);
			   },
			   'json'
		);
	}
}

zdl.delDev = function (id) {
	if(confirm('确认删除这个设备么?')){
		$.post(U('Zdl/Admin/delDev'),
			   {id:id},
			   function(msg){
				   zdl.ajaxload(msg);
			   },
			   'json'
		);
	}
}

zdl.delStatus = function (id) {
	if(confirm('确认删除这个状态么?')){
		$.post(U('Zdl/Admin/delStatus'),
			   {id:id},
			   function(msg){
				   zdl.ajaxload(msg);
			   },
			   'json'
		);
	}
}

zdl.delProcess = function (id) {
	if(confirm('确认删除这个设备进程么?')){
		$.post(U('Zdl/Admin/delProcess'),
			   {id:id},
			   function(msg){
				   zdl.ajaxload(msg);
			   },
			   'json'
		);
	}
}

zdl.delProject = function (id){
	if(confirm('确认删除这个大项目么?')){
		$.post(U('Zdl/Admin/delProject'),
			   {id:id},
			   function(msg){
				   zdl.ajaxload(msg);
			   },
			   'json'
		);
	}
}