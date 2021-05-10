## php扩展编写之封装c语言  
- https://www.alibabacloud.com/forum/read-405
  
```
awk: /home/kyronbao/php-7.2.7/ext/skeleton/create_stubs:56: warning: escape sequence `\|' treated as plain `|'
Creating basic files: config.m4 config.w32 .gitignore myfile.c php_myfile.h CREDITS EXPERIMENTAL tests/001.phpt myfile.php [done].

To use your new extension, you will have to execute the following steps:

1.  $ cd ..
2.  $ vi ext/myfile/config.m4
3.  $ ./buildconf
4.  $ ./configure --[with|enable]-myfile
5.  $ make
6.  $ ./sapi/cli/php -f ext/myfile/myfile.php
7.  $ vi ext/myfile/myfile.c
8.  $ make

Repeat steps 3-6 until you are satisfied with ext/myfile/config.m4 and
step 6 confirms that your module is compiled into PHP. Then, start writing
code and repeat the last two steps as often as necessary.

NOTE! Because some arguments to functions were resources, the code generated
cannot yet be compiled without editing. Please consider this to be step 4.5
in the instructions above.
```
  
```
PHP_ARG_ENABLE(myfile, whether to enable myfile support,

[  --enable-myfile           Enable myfile support])
```
  
```
cd ..
make clean
./buildconf --force
./configure --prefix=/opt/php/test --enable-myfunctions --enable-myfile
```
  
```
Generating files
configure: creating ./config.status
creating main/internal_functions.c
creating main/internal_functions_cli.c
+--------------------------------------------------------------------+
| License:                                                           |
| This software is subject to the PHP License, available in this     |
| distribution in the file LICENSE.  By continuing this installation |
| process, you are bound by the terms of this license agreement.     |
| If you do not agree with the terms of this license, you must abort |
| the installation process at this point.                            |
+--------------------------------------------------------------------+

Thank you for using PHP.

config.status: creating php7.spec
config.status: creating main/build-defs.h
config.status: creating scripts/phpize
config.status: creating scripts/man1/phpize.1
config.status: creating scripts/php-config
config.status: creating scripts/man1/php-config.1
config.status: creating sapi/cli/php.1
config.status: creating sapi/cgi/php-cgi.1
config.status: creating ext/phar/phar.1
config.status: creating ext/phar/phar.phar.1
config.status: creating main/php_config.h
config.status: executing default commands
```
  
一些资源  
- https://devzone.zend.com/446/extension-writing-part-iii-resources/#Heading1
- https://stackoverflow.com/questions/1311389/getting-started-with-php-extension-development
- https://github.com/andot/bped
