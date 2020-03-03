ziyuwong.com
===============

> The operating environment requires PHP7.1 +.
> 
> The operating environment requires 10.1.38-MariaDB +

## INSTALL

* Go to the project root directory and open the command line input
~~~
php think run
~~~

* Find .env file and configure your database connection
~~~
APP_DEBUG = true

[APP]
DEFAULT_TIMEZONE = Asia/Shanghai

[DATABASE]
TYPE = mysql
HOSTNAME = 127.0.0.1
DATABASE = test
USERNAME = root
PASSWORD = 123456
HOSTPORT = 3306
CHARSET = utf8
DEBUG = true

[LANG]
default_lang = zh-cn
~~~

* Open the sql folder and import the data in migrate.sql into the database
~~~
|—— sql
     |—— migrate.sql
~~~


* Open your Browser and enter to http://127.0.0.1:8000/migrate
~~~  
Once you enter this page, you will not be able to enter again.
It will take a little time for the first entry.
~~~

* Refresh your Browser



* Admin page 
~~~  
http://127.0.0.1:8000/admin
~~~  


## INFORMATION

* This project using SPA(single page application) technology
* Front and rear separation project architecture
