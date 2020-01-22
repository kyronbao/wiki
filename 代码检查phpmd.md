- https://www.cnblogs.com/cxscode/p/9319759.html
phpmd的rule配置规则本地位置 ~/.composer/vendor/phpmd/phpmd/src/main/resources/rulesets/cleancode.xml  
例如  
<rule name="StaticAccess"  
          since="1.4.0"  
          message="Avoid using static access to class '{0}' in method '{1}'."  
          class="PHPMD\Rule\CleanCode\StaticAccess"  
          externalInfoUrl="http://phpmd.org/rules/cleancode.html#staticaccess">  
        <description>  
            <![CDATA[  
Static access causes unexchangeable dependencies to other classes and leads to hard to test code. Avoid  
using static access at all costs and instead inject dependencies through the constructor. The only  
case when static access is acceptable is when used for factory methods.  
