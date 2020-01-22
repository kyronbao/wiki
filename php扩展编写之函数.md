  
```
cd /opt/php-7.2.7/ext/
sudo ./ext_skel --extname=myfunctions --proto=myfunctions.def
```
  
```
Creating directory myfunctions
awk: /opt/php-7.2.7/ext/skeleton/create_stubs:56: warning: escape sequence `\|' treated as plain `|'
Creating basic files: config.m4 config.w32 .gitignore myfunctions.c php_myfunctions.h CREDITS EXPERIMENTAL tests/001.phpt myfunctions.php [done].

To use your new extension, you will have to execute the following steps:

1.  $ cd ..
2.  $ vi ext/myfunctions/config.m4
3.  $ ./buildconf
4.  $ ./configure --[with|enable]-myfunctions
5.  $ make
6.  $ ./sapi/cli/php -f ext/myfunctions/myfunctions.php
7.  $ vi ext/myfunctions/myfunctions.c
8.  $ make

Repeat steps 3-6 until you are satisfied with ext/myfunctions/config.m4 and
step 6 confirms that your module is compiled into PHP. Then, start writing
code and repeat the last two steps as often as necessary.

```
编辑 =sudo vim myfunctions/config.m4= ，去掉这两行的注释  
```
PHP_ARG_ENABLE(myfunctions, whether to enable myfunctions support,
[  --enable-myfunctions           Enable myfunctions support])
```
  
在源码根目录下运行  
```
./buildconf --force
```
查看是否配置成功  
```
./configure --help | grep myfunctions
```
  
configure安装时报错  
```
error: xml2-config not found. Please check your libxml2 installation
```
解决  
```
sudo apt install libxml2-dev
```
再次configure  
```
./configure \
--prefix=/opt/php/test \
--enable-myfunctions
```
  
成功后提示  
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
  
```
make
```
```
Generating phar.php
Generating phar.phar
PEAR package PHP_Archive not installed: generated phar will require PHP's phar extension be enabled.
directorytreeiterator.inc
pharcommand.inc
clicommand.inc
invertedregexiterator.inc
directorygraphiterator.inc
phar.inc

Build complete.
Don't forget to run 'make test'.
```
  
```
sudo make install
```
```
Installing shared extensions:     /opt/php/test/lib/php/extensions/no-debug-non-zts-20170718/
Installing PHP CLI binary:        /opt/php/test/bin/
Installing PHP CLI man page:      /opt/php/test/php/man/man1/
Installing phpdbg binary:         /opt/php/test/bin/
Installing phpdbg man page:       /opt/php/test/php/man/man1/
Installing PHP CGI binary:        /opt/php/test/bin/
Installing PHP CGI man page:      /opt/php/test/php/man/man1/
Installing build environment:     /opt/php/test/lib/php/build/
Installing header files:          /opt/php/test/include/php/
Installing helper programs:       /opt/php/test/bin/
  program: phpize
  program: php-config
Installing man pages:             /opt/php/test/php/man/man1/
  page: phpize.1
  page: php-config.1
Installing PEAR environment:      /opt/php/test/lib/php/
[PEAR] Archive_Tar    - installed: 1.4.3
[PEAR] Console_Getopt - installed: 1.4.1
[PEAR] Structures_Graph- installed: 1.1.1
[PEAR] XML_Util       - installed: 1.4.2
[PEAR] PEAR           - installed: 1.10.5
Wrote PEAR system config file at: /opt/php/test/etc/pear.conf
You may want to add: /opt/php/test/lib/php to your php.ini include_path
/home/kyronbao/php-7.2.7/build/shtool install -c ext/phar/phar.phar /opt/php/test/bin
ln -s -f phar.phar /opt/php/test/bin/phar
Installing PDO headers:           /opt/php/test/include/php/ext/pdo/
```
  
执行测试文件  
```
print confirm_myfunctions_compiled("myextension");
```
提示  
```
Congratulations! You have successfully modified ext/myfunctions/config.m4. Module myextension is now compiled into PHP.

Warning: self_concat: not yet implemented ...
```
  
编写self_concat函数  
```
PHP_FUNCTION(self_concat)
{
	char *str = NULL;
	int argc = ZEND_NUM_ARGS();
	size_t str_len;
	zend_long n;

	char *result; /* Points to resulting string */
	char *ptr; /* Points at the next location we want to copy to */
	int result_length; /* Length of resulting string */

	if (zend_parse_parameters(argc, "sl", &str, &str_len, &n) == FAILURE)
		return;

	// php_error(E_WARNING, "self_concat: not yet implemented");

	/* Calculate length of result */
	result_length = (str_len * n);
	/* Allocate memory for result */
	result = (char *) emalloc(result_length + 1);
	/* Point at the beginning of the result */
	ptr = result;
	while (n--) {
		/* Copy str to the result */
		memcpy(ptr, str, str_len);
		/* Increment ptr to point at the next position we want to
		➥ write to */
		ptr += str_len;
	}
	/* Null terminate the result. Always null-terminate your strings
	even if they are binary strings */
	*ptr = '\0';
	/* Return result to the scripting engine without duplicating it
	➥ */
	RETURN_STRINGL(result, result_length);
}
```
备注：修复了在PHP7.2下报错  
```
error: macro "RETVAL_STRINGL" passed 3 arguments, but takes just 2
  RETVAL_STRINGL
```
修改  
```
RETURN_STRINGL(result, result_length, 0);
```
为  
```
RETURN_STRINGL(result, result_length);
```
  
重新编译安装  
```
make clean
make
sudo make install
```
测试  
```
echo self_concat('Bbbb', 3);
```
显示  
```
BbbbBbbbBbbb
