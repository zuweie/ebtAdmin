##### 应用
在ebtAdmin中，应用可以被安装和卸载，安装和卸载的过程是：<br>
* 1 在数据库中建立这个应用的需要的数据表.<br>
* 2 在Admin中注册这个应用资料，如作者，版本.<br>
* 3 应用也可有被卸载，当卸载的时候，Admin模块会删除安装时建立的数据表.<br>

##### 应用目录的文件结构
若应用需要安装，需要在应用的根目录下建立一个Appinfo的文件夹。<br>文件夹中应该新建四个文件，分别为info.php, install.php, install.sql, uninstall.php。这个四个文件的内容具体可以参照Application/User/Appinfo/里面的内容<br>

* 1 info.php，应用的信息，如名称，作者，版本，后台入口，描述。
* 2 install.php，安装该应用时，调用的脚本，一般会调用install.sql来生城数据表。
* 3 install.sql,安装时调用的sql脚本，一般用于生成该应用所需要的数据表
* 4 uninstall.php 卸载该应用时所需要的的脚本，一般为删除安装时建立的数据表。


