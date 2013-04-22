<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $Title; ?> - <?php echo $Powered; ?></title>
        <link rel="stylesheet" href="./css/install.css?v=9.0" />
    </head>
    <body>
        <div class="wrap">
            <?php require './templates/header.php'; ?>
            <div class="section">
                <div class="main cc">
                    <pre class="pact" readonly="readonly">
ThinkPHP通用后台使用协议
本通用后台为 <b><a href="http://weibo.com/ybyq2010" target="_blank">@_永不言弃_</a></b> 为QQ群：102577846 群友学习参考用，其中没有做过多数据过滤完全考虑和界面兼容处理，如果你将本通用后台使用于你自己的系统中，请自行处理（不过不会有太多的问题）。

<b>本通用后台包含以下功能：</b>

1、RBAC权限管理功能；
   便捷地对系统中用户进行权限分配，所以权限分配可以在一个页面分配完成。

2、简单新闻发布版块；
   基本的新闻发布、修改、删除。

3、无极限分类功能；
   满足新闻分类等的无极限分类的功能，你可以根据实际情况修改。

4、每月自动备份功能；
   管理员每月个第一次登陆后台，系统会后台自动进行当月数据备份功能。

5、备份、还原数据库，打包已备份sql文件
   备份数据量大时，系统会自动分隔备份成多个sql文件，每个sql文件头部记录了当前sql文件包含了那些表数据。支持其他软件导入的sql文件导入（支持导入>200M的sql文件，目前只测试过200M左右的sql文件，虽然支持但是还是不建议这么做）。

6、打包已备份sql文件，在线解压zip数据文件
   考虑到节省磁盘空间，你可以将已备份是sql文件打包成zip压缩文件（对应打包的sql文件会被清除），同时你可以在线解压之间zip打包的文件（zip文件保留）。

7、邮件发送sql备份，下载数据库备份文件
   在你配置了系统邮件信息后，你可以轻松将你的备份sql文件打包发送到你指定的邮箱中，如果发送的sql文件较多较大，系统考虑到备份邮箱不支持大附件系统将分成多封邮件发送（压缩前50M一封，压缩后一般在6~7M左右），同时你可以将系统备份的sql文件下载到你本地。

8、数据优化修复功能
   你可以轻松优化修复你的mysql数据库。

9、缓存清除功能
   你不用去一个一个目录地清除缓存文件了，只要勾选确定就可以了

10、JS\CSS 压缩缓存
   系统加入了minify压缩js、css缓存，为了和TP的分隔符分开，如果你要将你的js、css加入到minify中，你必须使用竖线“|”将多个文件分隔开。

11、后台有二维码访问图
   如果你不需要请自行在/Admin/Lib/Action/CommonAction.class.php 里去掉，同时修改模板文件。


<b>特别说明：</b>
1、本向导是直接拿 @水平凡 的项目向导修改的；
2、后面界面设计是来自互联网，排版是本人完成的；
3、本系统虽然有备份、回复数据库功能，但是为了完全建议还是执行备份。（本系统可以作为一个备份补充手动）
4、由于使用本后台系统出现任何安全问题、数据文件等其他其他与本人无关，请考虑后用。

版权所有(c)2012-2013，<a href="blog.51edm.org" target="_blank" >blog.51edm.org</a> 保留所有权力。</a></pre>
                </div>
                <div class="bottom tac"> <a href="./index.php?step=2" class="btn">接 受</a> </div>
            </div>
        </div>
        <?php require './templates/footer.php'; ?>
    </body>
</html>