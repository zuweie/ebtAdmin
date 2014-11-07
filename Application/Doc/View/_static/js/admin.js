var doc = {};

doc.ajaxload = function (obj){

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

doc.closebox = function () {
	ui.box.close();
}

doc.convert2pdf = function () {
	ids = admin.getChecked();
	
	if (ids == ''){
		alert('请选择要转换的文档！');
		return false;
	}
	
	var content = '<div class="html_clew_box_con" id="ui_messageContent" style="padding 10px;">\
				  <i class="ico-ok"></i>转换需要时间，请勿刷新，或关闭窗口，谢谢！</div>';
	ui.box.show(content,'正在将文档转为PDF...');
	
	$.post(U('Doc/Admin/convert2Pdf'),
		   {ids:ids},
		   function (msg){
			   doc.closebox();
			   doc.ajaxload(msg);
		   },
		   'json'
	);
	
}