#CuteCRUD
CuteCRUD 是基于 Laravel-5 开发的通用网站管理后台解决方案。它可让你省下开发后台管理程序的时间，避免重复的 CRUD 代码。

##特点
1. 代码量小，php 代码 400 行左右。根据自己的需求开发和维护都相当方便。  
2. Larvel 的表单验证规则直接可用。

#安装
在你的终端中执行以下命令：

```bash
git clone git@github.com:NauxLiu/CuteCRUD.git
cd CuteCRUD
composer install
cp .env.example .env
```

然后修改 `.env` 文件中的数据库配置。

生成 数据表：

```
php artisan migrate
```

Enjoy!


##目前支持组件：

1. Checkbox.
2. Range.
3. Radio
4. Telect
5. Text
6. Password
7. Number
8. Content Editor

后续将添加

1. Relationship
2. Date & Time

##截图
![](http://myblog-img.qiniudn.com/github/30F41C7D-8EA2-4C63-ADED-69ADF9E3808B.png)
![](http://myblog-img.qiniudn.com/github/E7C861EB-0640-45CA-9E71-1F3B96ADC961.png)
![](http://myblog-img.qiniudn.com/github/F1988665-3C57-4028-881A-318CF65E674C.png)
