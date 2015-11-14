<?php
	/*该文档纪录PHP与C/C++不同之处*/
	1	变量为弱数据类型
	2	不支持无符号整数故int型数最大值为2^31-1;
	3   如果结果超出了整型，会被自动转换成float型
	4	数字与字符串的加法
	
	$foo = 1 + "10.5";                // $foo is float (11.5)
	$foo = 1 + "-1.3e3";              // $foo is float (-1299)
	$foo = 1 + "bob-1.3e3";           // $foo is integer (1)
	$foo = 1 + "bob3";                // $foo is integer (1)
	$foo = 1 + "10 Small Pigs";       // $foo is integer (11)
	$foo = 4 + "10.2 Little Piggies"; // $foo is float (14.2)
	$foo = "10.0 pigs " + 1;          // $foo is float (11)
	$foo = "10.0 pigs " + 1.0;        // $foo is float (11)     

	5	float 精度为14个有效数字
	6	函数名不区分大小写 ,这个与变量不一样.

	7   如果在函数中，我们不希望使用某个变量，
		或者是希望彻底的不再某个变量,则可以使用 
		 unset(变量名) ; 将该变量彻底删除.

	8   类名.class.php 类文件命名规范。
	9	静态方法的特点
			1.        静态方法去操作静态变量
			2.        静态方法不能操作非静态变量.
					  这里请注意 : 普通的成员方法，
					  既可以操作非静态变量，
				      也可以操作静态变量
	10	如果一个方法没有访问修饰符，则默认是public，但是属性 必须指定访问修饰符
	11	方法之间可以互相调用. 但是需要使用 $this引用
	12  继承方法是class A extends B.
	13	父类的 public  、protected 的属性和方法被继承. private 的属性和方法没有被继承
	14	一个类只能继承一个父类，（直接继承）.如果你希望继承多个类的属性和方法，则使用多层继承
	15	当创建子类对象的时候，默认情况下，不会自动调用父类的构造方法.
	16	如果想调用父类的构造方法则在构造函数内部显式调用父类的构造函数parent::__construct()
	17	PHP5不能重载函数，但是可以通过魔术函数__call($method,$p)来实现函数的重载。
	18	要实现重写，要求 子类的那个方法的名字和参数列表个数一摸一样，但是并不要求参数的名称一样.
	19  如果子类要去调用父类的某个方法(public / protected) 
		则可以使用 parent::方法名(参数..) , 父类名::方法名(参数...)
	20	在实现方法覆盖的时候，访问修饰符可以不一样   
	    //但是必须满足: 子类的访问范围>=父类的访问范围
	21	多态：当子类没有覆盖父类的方法则 直接调用父类，当子类覆盖了父类的方法，则调用自己的方法。
	22	抽象类：实际开发中，我们可能有这样一种类,是其它类的父类，但是它本身并不需要实例化,
		主要用途是用于让子类来继承，这样可以到达代码复用. 同时利于项目设计者，设计类
	23	如果一个类使用abstract 来修饰，则该类就是抽象类, 如果一个方法被abstract修饰，
		则该方法就是抽象方法【抽象方法就不能有方法体.】 
	24	抽象类可以没有抽象方法.同时还可以有实现了的方法.
	25	如果一个类中，只要有抽象方法，则该类必须声明为abstract
	26	如果A类继承了一个抽象类 B，则要求A类实现从B类继承的所有抽象方法
	27	接口一般是用来定义规范的。接口的使用基本语法
		interface 接口名{
       		//属性
       		//接口的方法都不能有方法体
		}
	28	接口的实现:
		class 类名 implements 接口名1,接口2.{},当一个类实现了一个接口那么必须实现接口的所有方法。
	29	接口就是给出一些没有实现的方法，封装到一起，到某个类要使用的时候，再根据具体情况把这些方法写出来。
		可以同时实现多个接口，可以有一个接口列表
		接口可以理解为更加抽象的抽象类，抽象类可以有些已经实现的抽象方法，但是接口不行。
		体现了程序设计的多态和高内聚低耦合的特点。编程要低耦合
		接口可以定义公共规范来实现，同样当多各类之间是平级的关系，但是都有相同的需求
		但是实现不同时，可以抽象为接口。同时可以约束这几个类必须实现相关方法。
	30	印度一百个程序员写的程序像一个人写的，中国一百个程序员写的程序像两百个人写的
	31  接口细节：1 接口不能实例化 2 不能有方法体，3 一个类可以实现多个接口但是必须用","隔开
				  4 接口可以有属性，但是必须是常量，但是访问范围必须是public 默认为public。
				  5	可以引用接口里定义的常量，常量前面不要加$符号
				  6 接口的方法是public的 7 一个接口不能继承其他的类，但是可以继承其他的接口
				  8 接口可以继承多个接口，但是类不行。
				  9	但是继承了多个接口，不用再里面重复定义，当然更不能去实现。
				  10 但是如果一个类实现了一个接口，但是该接口又继承了几个接口，那么该类必须同时实现所有接口
				  11 当父类中没有某属性，但是子类又不能去继承其他类了，那么就可以用接口
	32	若想一个类不被任何类继承，则可以在类的定义时加上final关键字			  
	33  在类的外部访问可以用类名::常量名的形式，内部用self::常量名或是类名::常量名，并且可以被子类继承
		一个常量时属于一个类的
	34	file_exists(filename) or die("文件不存在")
	35	$_SERVER预定义常量，可以用来获取相关信息
		如$_SERVER[HTTP_HOST];
		HTTP_HOST
		REMOTE_ADDR 访问该页面的ip
		DOCUMENT_ROOT  可以获取 apche的主目录
		REQUEST_URI 可以获取 请求的资源名
	36	post比get 更安全 get 请求的数据会显示在 地址栏上, post请求的数据，放在http协议的消息体
	37	get请求可以更好的添加到收藏夹
	38	项目流程 需求分析->架构设计->编码
	39	变量命名是如果是数据库里面的数据可以用表名_属性名的形式定义
	40	如果跳转到新页面，在header()后面加上exit();
	41	查询语句中如果有类似"where name = $name" 要写成 "where name = '".$name."'";这里容易出错；
	42  注意mysqli 和 mysql不要混用
	43	分页中有几个变量是必须的
		1 $pageNow -> 要显示的页数
		2 $pageCount -> 总共的页数
		3 $rowCount -> 记录的数量
		4 $pageSize -> 每页显示记录的数量
	44  select * from table where limit a,b取出从第a条开始b条记录，编号从0开始；
	45	得到表中数据的行数select count(id) form table_name;
	46	mysql 自我复制语句，insert into emp (name,email,salary) select name,email,salary from emp;
	47	MVC基本概念：强制把数据的输入，数据的处理，数据的显示分开
	48	界面层用PHP，业务逻辑用类
	49	对象本身就是按引用传递的，所以传进函数里面的对象会被修改
	50	cookie可以保存中文不过会用urlencode加密
	51	虽然一个cookie可以有多个记录，但是每一个过期时间可以不同
	52	删除所有cookie用循环遍历
	53	session 可以保存任意类型的数据
	54	utf-8是三个字节表示一个汉字
	55	去访问session里的对象的信息时，必须带上对象的定义，如果没有，无法取到完整的对象信息，
		所以在取session里面对象的信息时，该页面必须包含该类的定义
	56	一个会话对应一个session文件
	57	删除一个session用unset函数，删除所有用session_destroy();
	58	安全退出会删除在服务器保存的大量数据，如果没有选择，可以能回留下数据被他人攻击
	59	session 默认存在时间是24min,但是可以自己在php.ini设置,但是这个时间是指当前如果有24min没有
		使用过session文件，那么失效，这里和cookie不一样，指的是“发呆”时间。
	60	每个页面如果要使用session都必须先调用session_start()函数，也可以在php.ini中配置session.auto_start=1;
		但是不推荐使用，会影响效率
	61	服务器在第一次开始会话是在服务器创建一个session，然后会自动设置一个cookie 内容为sessionID 当开始另一个页面时
		会将该cookie的值带过去，然后在同一进程之间可以共享该变量
	62	经检测，现在session变量可以在同一浏览器的多个窗口（不是标签页）之间共享，即使禁用了cookie，这个和
		韩老师的视频里面讲的有出入，即使禁用了cookie也可以正常使用session
	63	var 和public 都是表示公开 但是var兼容5.0以下版本
	64	preg_replace(pattern, replacement, subject)函数用正则表达式来替换制定字符串
	65	获取文件修改时间filemtime(),可以用来设置是否更新，如果上次模板修改时间大于所依赖的源文件，则更新，
		否则不更新

	66	smarty安装配置过程：
		1 解压后吧libs文件放在网站第一级目录下
		2 在第一级目录新建两个文件夹templates(放模板文件) 和templates_c(放编译后的文件)
	67 smarty 默认的分隔符是$smarty->left_delimiter="{" ,$smarty->right_delimiter="}";
	   为了和JavaScript和内联css兼容，把上面两个符号改为'<{}>',注意经自己测试，修改要在类的定义文件里面改;
	   之后改没用
	68	$Smarty->caching = fasle;//禁用缓存
		$Smarty->template_dir ="./templates";//设置模板目录
		$Smarty->compile_dir ="./templates_c";//设置编译目录
		$Smarty->cache_dir = "./smarty_cache"//缓存文件夹
	69	php数据类型：
		基本数据类型：int double string bool等
		复合数据类型：arry object
		特殊数据类型：resource null
	70	如果是关联数组，表示为<{$array.att}>,若是索引则类似<{$array[1]}>;多维类似

	71	如果类型是对象，则类似<{$objec->att}> <{$objec->arr[0]}> <$object->arr[1].att>
	72	可以从配置文件中获取变量值，这样可以使程序更灵活,方法是config_load file ="#"
	   	!注意load和file中间没有下划线
	73 	可以直接获取post、get传递的信息。用法$name = $smarty.get.name
	74 	可以直接以插件函数的形式放在函数的Plugin的目录下可以不用手动注册，这样可以简化自定义函数
	   	但是要保证命名的规范，具体规范见function.config_load.php函数的例子
	75 	也可以定义块的形式注册一个插件，方法如下：和上面类似，只是命名有所同，同样参考block.textformat.php函数的格式
	76	如果分割符号改了，如将"{"改为"<{"，那么注释也得改为"<{*";
	77	smarty内可以使用四则运算，但是不能使用"()"改变运算顺序，可以使用的符号为+-*/%
	78	如果要取出常量，用$smarty.const.name取出,注意smarty小写，常量额可以用define(name,value)的形式定义
	79	smarty变量调节器可以自定义，也可以自己写，参数也可以自定义
		用法类似这个<{$str|capitalize}>,或者跟参数{$str|function_name:"a,b,c"}
	80	smarty自带的truncate变量调节器显示中文时会乱码，可以去网上下载中文的代码放到函数目录下命名为truncate2
	81  <br /><a href="#" title='<{$content}>'><{$content|truncate2:11}></a>
		这样可以做出鼠标没选中显示部分文字，选中后显示全文的效果
	82	变量调节器可以组合使用类似这样：
		<{$str|upper|truncate2:8}>
	83	<{include file=""}>可以在模板里面引入其他模板文件，并且传入的变量可以在模板之间公用
		也可在include 的时候指定分配变量
	84	insert内建函数比较重要，面试必问
	85 	启用缓存机制，可以生成html格式的模板文件，比php格式的脚本文件执行效率高很多
		但是必须在项目的第一级目录下新建一个cache目录，并且加上$Smarty->cache_dir ='路径';
	86 	但是缓存有一个缺点，如果数据需要动态更新的话，这就有问题了，需要使用局部缓存
	87	计数器用法<{counter start=0 skip=1 assign=counter print=false}><br />
		要使用计数器必须给counter赋值，可以以$counter来引用，print=false表示不显示counter的结果
	88  可以使用$Smarty->debugging=true 开启调试模式，显示变量信息
	89  smarty缓存技术:
		使用缓存必须1 建立缓存文件夹 2 指定缓存目录$Smarty->cache_dir = "../cache/";
					3 开启缓存 $Smarty->caching = true 	4 指定缓存时间
	90	局部缓存：定义一个inser函数 
		//test.php
		function insert_mytime(){
			return date("y-m-d H:i:s");
		}
		//test.tpl
		<insert name=mytime>
		这样这部分的数据不会被缓存可以实时更新
	91  记录网页访问次数，两种方案，一种用文件，一种用数据库
	92	@        不显示错误信息(加在函数前)
	93	可以在使用id号来生成不同的缓存页面display("test.tpl",$id)
		如果id号不同则生成不同的缓存，若相同则不生成，可以用
		$Smarty->clear_all_cache函数删除所有缓存，也可以用指
		定删除$smarty->clear_cache("test.tpl","CACHEID");
	94	如果独立执行的文件最好使用?>结尾，如果被引用的文件如类推荐不要用;
	95	header("Content-Type: text/xml;charset=utf-8");
		header("Cache-Control: no-cache");
		一般把这两句话放在ajax响应页面的开头，设置格式和编码，并且禁用缓存
	96	ajax 推荐使用post传递参数，因为不限制字数，并且不会有中文乱码
	97	json可以混用各种数据类型，类似
		$res = '{
			info:
			[
				{"first":"1"},
				{"second":"2"}
			],
			"name":"liaoth"
			}';
	98	ajax如果没有特别要求时优先选择json，若远程应用程序未知时一般用xml,比较少使用html格式
	


?>
