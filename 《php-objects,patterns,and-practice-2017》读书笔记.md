* Chapter 3 Object Basics  
  
对传入方法的参数进行数据类型的限制，可以减少对象内再次验证数据类型的逻辑  
  
Type declaration Since Description  
| array          | 5.1 An array. Can default to null or an array                          |  
| string         | 5.0 Character data. Can default to null or a string.                   |  
| self           | 5.0 A reference to the containing class                                |  
| [a class type] | 5.0 The type of a class or interface. Can default to null              |  
| callable       | 5.4 Callable code (such as an anonymous function). Can default to null |  
| bool           | 7.0 A Boolean. Can default to null or a Boolean.                       |  
| int            | 7.0 An integer Can default to null or an integer                       |  
| float          | 7.0 A floating point number (a number with a decimal point).           |  
                       An integer willbe accepted—even with strict mode enabled.  
                       Can default to null, a float,or an integer  
  
声明有隐式转化的功能，比如对bool类型的声明  
```
function hello (bool $is_real) {
   //...
}
```
当 $is_real = 'false';会隐式转化成 true，所以不能用来判断  
  
参考PHP7新特性  
标量类型声明 http://php.net/manual/zh/migration70.new-features.php  
```
字符串(string), 整数 (int), 浮点数 (float), 以及布尔值 (bool)。它们扩充了PHP5中引入的其他类型：类名，接口，数组和 回调类型。

<?php
// Coercive mode
function sumOfInts(int ...$ints)
{
    return array_sum($ints);
}

var_dump(sumOfInts(2, '3', 4.1));
以上例程会输出：

int(9)
```
  
示例  
```
class ShopProduct
{
    public $title;
    public $producerMainName;
    public $producerFirstName;
    public $price = 0;
    public function __construct(
        $title,
        $firstName,
        $mainName,
        $price
    ) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }
    public function getProducer()
    {
        return $this->producerFirstName . " "
            . $this->producerMainName;
    }
}

class ShopProductWriter
{
// ShopProduct用来验证传入的$shopProduct，所以在write()方法内部不需要再次验证
// 传入的$shopProduct是否符合要求
    public function write(ShopProduct $shopProduct)
    {
        $str  = $shopProduct->title . ": "
            . $shopProduct->getProducer()
            . " (" . $shopProduct->price . ")\n";
        print $str;
    }
}

$product1 = new ShopProduct("My Antonia", "Willa", "Cather", 5.99);
// 因为类ShopProductWriter内部方法write()的入参有ShopProduct声明，所以实例化时
// 的同时限定了类型
$writer = new ShopProductWriter();
$writer->write($product1);

//This outputs the following:
//My Antonia: Willa Cather (5.99)
```
以上示例用两个类表示的目的是为了责任划分，ShopProduct用来管理产品，ShopProductWriter用来打印描述  
  
*inheritance*  
  
```
class ShopProduct
{
    public $title;
    public $producerMainName;
    public $producerFirstName;
    public $price;
    function __construct(
        $title,
        $firstName,
        $mainName,
        $price
    ) {
        $this->title             = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName  = $mainName;
        $this->price             = $price;
    }

    function getProducer()
    {
        return $this->producerFirstName . " "
            . $this->producerMainName;
    }
    function getSummaryLine()
    {
        $base  = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }
}
// listing 03.40
class BookProduct extends ShopProduct
{
    public $numPages;
    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float  $price,
        int    $numPages
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->numPages = $numPages;
    }
    public function getNumberOfPages()
    {
        return $this->numPages;
    }
    public function getSummaryLine()
    {
        $base  = parent::getSummaryLine();
        $base .= ": page count - $this->numPages";
        return $base;
    }
}
// listing 03.41
class CdProduct extends ShopProduct
{
    public $playLength;
    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float  $price,
        int    $playLength
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->playLength = $playLength;
    }
    public function getPlayLength()
    {
        return $this->playLength;
    }
    public function getSummaryLine()
    {
        $base  = parent::getSummaryLine();
        $base .= ": playing time - {$this->playLength}";
        return $base;
    }
}
```
  
访问或者设置属性时可以用方法getter(),setter()，更加灵活，  
getter()可以得到更丰富的对象内容，如下例的write()，  
setter()可以检查限制传入参数的类型  
```
class ShopProductWriter
{
    // 外部不能访问或直接操作$products数组
    private $products = [];
    // 检查加入的$shopProduct是否符合
    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[] = $shopProduct;
    }
    public function write()
    {
        $str =  "";
        foreach ($this->products as $shopProduct) {
            $str .= "{$shopProduct->title}: ";
            $str .= $shopProduct->getProducer();
            $str .= " ({$shopProduct->getPrice()})\n";
        }
        print $str;
    }
}
```
  
```
//加入封装的实例
class ShopProduct
{

    private   $title;
    private   $producerMainName;
    private   $producerFirstName;
    protected $price;
    private   $discount = 0;
    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float  $price
    ) {
        $this->title             = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName  = $mainName;
        $this->price             = $price;
    }

    public function getProducerFirstName()
    {
        return $this->producerFirstName;
    }
    public function getProducerMainName()
    {
        return $this->producerMainName;
    }
    public function setDiscount($num)
    {
        $this->discount = $num;
    }
    public function getDiscount()
    {
        return $this->discount;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getPrice()
    {
        return ($this->price - $this->discount);
    }
    public function getProducer()
    {
        return $this->producerFirstName . ” ”
            . $this->producerMainName;
    }
    public function getSummaryLine()
    {
        $base  = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        return $base;
    }
}
// listing 03.49
class CdProduct extends ShopProduct
{
    private $playLength;
    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float  $price,
        int    $playLength
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->playLength = $playLength;
    }
    public function getPlayLength()
    {
        return $this->playLength;
    }
    public function getSummaryLine()
    {
        $base  = parent::getSummaryLine();
        $base .= ": playing time - {$this->playLength}";
        return $base;
    }
}
// listing 03.50
class BookProduct extends ShopProduct
{
    private $numPages;
    public function __construct(
        string $title,
        string $firstName,
        string $mainName,
        float  $price,
        int    $numPages
    ) {
        parent::__construct(
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->numPages = $numPages;
    }
    public function getNumberOfPages()
    {
        return $this->numPages;
    }
    public function getSummaryLine()
    {
        $base  = parent::getSummaryLine();
        $base .= ": page count - $this->numPages";
        return $base;
    }
    public function getPrice()
    {
        return $this->price;
    }
}
```
  
* Chapter 4 Advanced Feature  
  
## 静态方法
静态方法或静态属性引用时必须用::语法，比如StaticExample::$aNum;  
使用::语法时不一定时引用静态方法，比如ShopProductWriter::write()  
参考P48 Note  
  
抽象类和方法的应用  
```
abstract class ShopProductWriter
{
    // $products已定义为数组，所以子类引用的时候可以不再验证数据类型
    protected $products = [];
    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[]=$shopProduct;
    }
    // 抽象方法在被继承的时候必须被实现或者也被声明为抽象方法
    abstract public function write();
}

// listing 04.06
class XmlProductWriter extends ShopProductWriter
{
    public function write()
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement("products");
        foreach ($this->products as $shopProduct) {
            $writer->startElement("product");
            $writer->writeAttribute("title", $shopProduct->getTitle());
            $writer->startElement("summary");
            $writer->text($shopProduct->getSummaryLine());
            $writer->endElement(); // summary
            $writer->endElement(); // product
        }
        $writer->endElement(); // products
        $writer->endDocument();
        print $writer->flush();
    }
}
// listing 04.07
class TextProductWriter extends ShopProductWriter
{
    public function write()
    {
        $str = "PRODUCTS:\n";
        foreach ($this->products as $shopProduct) {
            $str .= $shopProduct->getSummaryLine()."\n";
        }
        print $str;
    }
}
```
  
## Trait
*trait作用*  
trait相当于类中的可共用的部分，单独以Trait的方式首先声明，  
可以在已经实例化的对象中直接应用  
  
下面例子中，ShopProduct需要计算税费，UtilityService也要计算税费，但他们继承自不同的抽象方法  
可以用trait实现计算税费功能的复用  
```
// listing 04.12
trait PriceUtilities
{
    private $taxrate = 17;
    public function calculateTax(float $price): float
    {
        return (($this->taxrate / 100) * $price);
    }
    // other utilities
}
// listing 04.13
class ShopProduct
{
    use PriceUtilities;
}
// listing 04.14
abstract class Service
{
    // service oriented stuff
}
// listing 04.15
class UtilityService extends Service
{
    use PriceUtilities;
}
// listing 04.16
$p = new ShopProduct();
print $p->calculateTax(100) . "\n";
$u = new UtilityService();
print $u->calculateTax(100) . "\n";
```
  
*trait在接口中的使用*  
在不同类中可以用trait实现相同的功能，但是这样的话，trait实现的功能方法  
在实例实现时中就不是同一方法，解决办法是，在接口中首先定义好trait类，然后在  
在继承的类中引入trait来实现对应的功法  
```
// listing 04.20
interface IdentityObject
{
    public function generateId(): string;
}
// listing 04.21
trait IdentityTrait
{
    public function generateId(): string
    {
        return uniqid();
    }
}
// listing 04.22
class ShopProduct implements IdentityObject
{
    use PriceUtilities, IdentityTrait;
// listing 04.23
// 因为IdentityObject定义为了一个接口，所以在这里可以对此方法入参限制类型
    public static function storeIdentityObject(IdentityObject $idobj)
    {
        // do something with the IdentityObject
    }
}

// listing 04.24
$p = new ShopProduct();
self::storeIdentityObject($p);
print $p->calculateTax(100) . "\n";
print $p->generateId() . "\n";
```
  
*trait中方法冲突时可以用instead of关键字*  
下面例子中两个trait都有calculateTax()方法，所以会出现冲突  
```
// listing 04.25
trait TaxTools
{
    function calculateTax(float $price): float
    {
        return 222;
    }
}
// listing 04.26
trait PriceUtilities
{
    private $taxrate = 17;
    public function calculateTax(float $price): float
    {
        return (($this->taxrate / 100) * $price);
    }
    // other utilities
}
// listing 04.31
class UtilityService extends Service
{
    use PriceUtilities, TaxTools {
        TaxTools::calculateTax insteadof PriceUtilities;
        PriceUtilities::calculateTax as basicTax;
    }
}
// listing 04.32
$u = new UtilityService();
print $u->calculateTax(100) . "\n";
print $u->basicTax(100) . "\n";
```
注意：  
当trait中有方法冲突时仅仅用as关键字重命名是不够的，必须用instead of决定使用那个方法  
为主要的方法，弃用的方法可以用as来重命名来再次使用。  
偶然情况下，也可以用as来重命名未冲突的方法，forexample, want to use a trait method to  
implement an abstract method signature declared in a parent class or in an interface  
  
*改变trait方法的权限*  
类中引用trait后，可以使用trait的方法来来复用，把trait中的方法封装（定义为private）,这样  
原来trait的方法可以不能被访问  
```
// listing 04.42
trait PriceUtilities
{
    public function calculateTax(float $price): float
    {
        return (($this->getTaxRate() / 100) * $price);
    }
    public abstract function getTaxRate(): float;
    // other utilities
}
// listing 04.43
class UtilityService extends Service
{
    use PriceUtilities {
        // 封装
        PriceUtilities::calculateTax as private;
    }
    private $price;
    public function __construct(float $price)
    {
        $this->price = $price;
    }
    public function getTaxRate(): float
    {
        return 17;
    }
    public function getFinalPrice(): float
    {
                               // 复用
        return ($this->price + $this->calculateTax($this->price));
    }
}
// listing 04.44
$u = new UtilityService(100);
print $u->getFinalPrice() . "\n";
```
注意：这样print $u->calculateTax()."\n";将报错，达到封装的效果  
  
## 迟静态绑定late static bingdings
static可以被用来当作工厂模式的关键字  
示例 通过static()子类的实例化  
```
abstract class DomainObject
{
    public static function create(): DomainObject
    {
       // static
       return new static();
    }
}
class User extends DomainObject
{
}
class Document extends DomainObject
{
}
print_r(Document::create());
Document Object
(
)
```
注意：如果用return new self();则调用print_r(Document::create());报错  
理解self和static的区别  
self()包含当前类，指向了类DomainObject  
static()指向当前的引用,指向了Document  
  
static可以用作静态方法调用的标识符（像self,parent一样）  
示例  
抽象域对象有默认的分组default,在继承类中可以被覆盖为其他分组比如document  
```
// listing 04.52
abstract class DomainObject
{
    private $group;
    public function __construct()
    {
        $this->group = static::getGroup();
    }
    public static function create(): DomainObject
    {
        return new static();
    }
    public static function getGroup(): string
    {
        return "default";
    }
}

// listing 04.53
class User extends DomainObject
{
}
// listing 04.54
class Document extends DomainObject
{
    public static function getGroup(): string
    {
        return "document";
    }
}
// listing 04.55
class SpreadSheet extends Document
{
}
// listing 04.56
print_r(User::create());
print_r(SpreadSheet::create());

/*
I introduced a constructor to the DomainObject class. It uses the static keyword to invoke a static
method: getGroup(). DomainObject provides the default implementation, but Document overrides it. I also
created a new class, SpreadSheet, that extends Document. Here’s the output:

popp\ch04\batch07\User Object
(
    [group:popp\ch04\batch07\DomainObject:private] => default
)
popp\ch04\batch07\SpreadSheet Object
(
    [group:popp\ch04\batch07\DomainObject:private] => document
)
*/
```
解释：  
组属性在抽象类中定义为私有属性，并在构造函数中通过static关键字调用静态方法getGroup()赋值给$group  
print_r(User::create());User类可以通过new static()继承DomainObject  
print_r(SpreadSheet::create());继承后getGroup()方法也可以被覆盖，setGroup()首先在SpreadSheet中查找，  
找不到后，在父类Document中找到  
  
## Handle Errors
  
*Exception*  
  
对xml文件  
<?xml version="1.0"?>  
<conf>  
    <item name="user">bob</item>  
    <item name="pass">newpass</item>  
    <item name="host">localhost</item>  
</conf>  
设计一个类，含有读取、添加方法，对报错记录在日志中  
```
// listing 04.61
class XmlException extends \Exception
{
    private $error;
    public function __construct(\LibXmlError $error)
    {
        $shortfile = basename($error->file);
        $msg = "[{$shortfile}, line {$error->line}, col {$error->column}] {$error->message}";
        $this->error = $error;
        parent::__construct($msg, $error->code);
    }
    public function getLibXmlError()
    {
        return $this->error;
    }
}
// listing 04.62
class FileException extends \Exception
{
}
// listing 04.63
class ConfException extends \Exception
{
}

// Conf类
// 可以对xml文件读取、写操作
// listing 04.57
class Conf
{
    private $file;
    private $xml;
    private $lastmatch;
// listing 04.64
// Conf class...
    function __construct(string $file)
    {
        $this->file = $file;
        if (! file_exists($file)) {
            throw new FileException("file '$file' does not exist");
        }
        $this->xml = simplexml:load_file($file, null, LIBXML_NOERROR);
        if (! is_object($this->xml)) {
            throw new XmlException(libxml:get_last_error());
        }
        $matches = $this->xml->xpath("/conf");
        if (! count($matches)) {
            throw new ConfException("could not find root element: conf");
        }
    }
    function write()
    {
        if (! is_writeable($this->file)) {
            throw new FileException("file '{$this->file}' is not writeable");
        }
        file_put_contents($this->file, $this->xml->asXML());
    }
    public function get(string $str)
    {
        $matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");
        if (count($matches)) {
            $this->lastmatch = $matches[0];
            return (string)$matches[0];
        }
        return null;
    }
    public function set(string $key, string $value)
    {
        if (! is_null($this->get($key))) {
            $this->lastmatch[0]=$value;
            return;
        }
        $conf = $this->xml->conf;
        $this->xml->addChild('item', $value)->addAttribute('name', $key);
    }
}

// 客户端
    public static function init()
    {
        $fh = fopen(__DIR__ . "/log.txt", "a");
        try {
            fputs($fh, "start\n");
            $conf = new Conf(dirname(__FILE__) . "/conf.broken.xml");
            print "user: " . $conf->get('user') . "\n";
            print "host: " . $conf->get('host') . "\n";
            $conf->set("pass", "newpass");
            $conf->write();
        } catch (FileException $e) {
            // permissions issue or non-existent file
            fputs($fh, "file exception\n");
        } catch (XmlException $e) {
            fputs($fh, "xml exception\n");
            // broken xml
        } catch (ConfException $e) {
            fputs($fh, "conf exception\n");
            // wrong kind of XML file
        } catch (Exception $e) {
            fputs($fh, "general exception\n");
            // backstop: should not be called
        } finally {
            fputs($fh, "end\n");
            fclose($fh);
        }
    }
```
  
## Working with Interceptors 类中的拦截方法（魔术方法）
  
__get() __set() __isset() __unset()  
  
使用拦截方法后，对类中不存在的属性读取、设置时返回null，不报错处理  
```
class Person
{
    public function __get(string $property)
    {
        $method = "get{$property}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }
    public function getName(): string
    {
        return "Bob";
    }
    public function getAge(): int
    {
        return 44;
    }

// listing 04.72
    public function __isset(string $property)
    {
        $method = "get{$property}";
        return (method_exists($this, $method));
    }
}

$p = new Person();
print $p->name; // Bob
//__isset()起作用
if (isset($p->name)) {
    print $p->name;
}
```
  
```
// listing 04.73
class Person
{
    private $myname;
    private $myage;
    public function __set(string $property, string $value)
    {
        $method = "set{$property}";
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }
    }
    public function setName(string $name)
    {
        $this->myname = $name;
        if (! is_null($name)) {
            $this->myname = strtoupper($this->myname);
        }
    }
    public function setAge(int $age)
    {
        $this->myage = $age;
    }

    public function __unset(string $property)
    {
        $method = "set{$property}";
        if (method_exists($this, $method)) {
            $this->$method(null);
        }
    }
}

$p = new Person();
$p->name = "bob";
// the $myname property becomes 'BOB'
```
  
__call()调用类中不存在的方法时自动触发  
__call()可以实现一种委托机制，在本类中实现调用其他类的方法  
```
// listing 04.75
class PersonWriter
{
    public function writeName(Person $p)
    {
        print $p->getName() . "\n";
    }
    public function writeAge(Person $p)
    {
        print $p->getAge() . "\n";
    }
}

// listing 04.76
class Person
{
    private $writer;
    public function __construct(PersonWriter $writer)
    {
        $this->writer = $writer;
    }
    public function __call(string $method, array $args)
    {
        if (method_exists($this->writer, $method)) {
            //return $this->writer->$method($this);
            return call_user_func_array(
                [
                     $this->thirdpartyShop,
                     $method
                ],
                $args
            );// listing 05.33重写
        }
    }
    public function getName(): string
    {
        return "Bob";
    }
    public function getAge(): int
    {
        return 44;
    }
}


$person = new Person(new PersonWriter());
// 通过__call()可以调用PersonWriter类的方法
$person->writeName();
```
注意：这样设计同时降低了程序的可读性，__call()隐藏了类其他可用的方法  
  
__get() __set()也可以对组合属性进行管理  
如下面的例子实现了：  
在类中地址用$number,$address两个字段管理数据，  
外部客户端访问数据时用$adress->streetadress访问和设置  
```
// listing 04.77
class Address
{
    private $number;
    private $street;
    public function __construct(string $maybenumber, string $maybestreet = null)
    {
        if (is_null($maybestreet)) {
            // 调用__set()
            $this->streetaddress = $maybenumber;
        } else {
            $this->number = $maybenumber;
            $this->street = $maybestreet;
        }
    }
    public function __set(string $property, string $value)
    {
        if ($property === "streetaddress") {
            if (preg_match("/^(\d+.*?)[\s,]+(.+)$/", $value, $matches)) {
                $this->number = $matches[1];
                $this->street = $matches[2];
            } else {
                throw new \Exception("unable to parse street address: '{$value}'");
            }
        }
    }
    public function __get(string $property)
    {
        if ($property === "streetaddress") {
            return $this->number . " " . $this->street;
        }
    }
}
// listing 04.78
$address = new Address("441b Bakers Street");
print "street address: {$address->streetaddress}\n";
/*
Address Object
(
    [number:Address:private] => 441b
    [street:Address:private] => Bakers Street
)
*/
$address = new Address("15", "Albert Mews");
print "street address: {$address->streetaddress}\n";
$address->streetaddress = "34, West 24th Avenue";
print "street address: {$address->streetaddress}\n";
```
  
  
  
## __clone 复制对象
含义  
```
class CopyMe
{
}
$first = new CopyMe();
$second = $first;
// PHP 4: $second and $first are 2 distinct objects
// PHP 5 plus: $second and $first refer to one object

$second = clone $first;
// PHP 5 plus: $second and $first are 2 distinct objects
```
  
使用  
当复制对象时，对象中可能含有唯一标识符ID对应于数据库，所以复制对象时会出想2个相同的ID，  
使用__clone(),可以在复制对象时让被复制后的对象的ID变为0  
```
// listing 04.81
// listing 04.83
class Account
{
    public $balance;
    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }
}

class Person
{
    private $name;
    private $age;
    private $id;
    public  $account;
    public function __construct(string $name, int $age, Account $account)
    {
        $this->name = $name;
        $this->age  = $age;
        $this->account = $account;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function __clone()
    {
        $this->id = 0;
    }
}

// listing 04.82
$person = new Person("bob", 44);
$person->setId(343);
$person2 = clone $person;
// $person2 :
//     name: bob
//     age: 44
//     id: 0.
// give $person some money
$person->account->balance += 10;
// $person2 sees the credit too
print $person2->account->balance;
This gives the following output:
210
```
注释：  
当clone对象时，复制对象$person2里的$account仍然指向相同的$account  
可用以下方法处理  
    function __clone()  
    {  
        $this->id   = 0;  
        $this->account = clone $this->account;  
    }  
  
  
  
## Callbacks, Anonymous Functions, and Closures
  
现在有产品，需要对产品有不同的处理方式，每种处理方式可以在ProcessSale中注册，  
这样，就可以不必把所有处理方式放到同一个函数中，达到有效的解耦，可以对每种  
处理方式进行管理  
```
// listing 04.89
class Product {
    public $name;
    public $price;
    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}
class ProcessSale
{
    private $callbacks;
    public function registerCallback(callable $callback)
    {
        if (! is_callable($callback)) {
            throw new Exception("callback not callable");
        }
        $this->callbacks[] = $callback;
    }
    public function sale(Product $product)
    {
        print "{$product->name}: processing \n";
        foreach ($this->callbacks as $callback) {
            call_user_func($callback, $product);
        }
    }
}

// listing 04.91
$logger2 = function ($product) {
    print "    logging ({$product->name})\n";
};
$processor = new ProcessSale();
$processor->registerCallback($logger2);

$processor->sale(new Product("shoes", 6));
print "\n";
$processor->sale(new Product("coffee", 6));

/*
shoes: processing
    logging (shoes)
coffee: processing
    logging (coffee)
*/
```
注释：  
类Product管理产品  
类ProcessSale处理产品管理，有两个方法，一是RegisterCallback()，注册处理产品的方法，另一个方法  
循环通过注册的方法来处理$product，  
其中is_callable()传入参数为函数，确保传入的函数可以被call_user_func()可以调用，  
call_user_func($logger2, $product)指执行匿名函数$logger2，入参是对象$product  
  
调用匿名函数也可以是数组格式  
```
// listing 04.92
class Mailer
{
    public function doMail(Product $product)
    {
        print "    mailing ({$product->name})\n";
    }
}
// listing 04.93
$processor = new ProcessSale();
// 格式为数组中第一个参数是实例，第二个参数为执行的函数
$processor->registerCallback([new Mailer(), "doMail"]);
$processor->sale(new Product("shoes", 6));
print "\n";
$processor->sale(new Product("coffee", 6));

/*
shoes: process
ing
    mailing (shoes)
coffee: processing
    mailing (coffee)
*/
```
  
闭包  
```
// listing 04.96
class Totalizer2
{
    public static function warnAmount($amt)
    {
        $count=0;
        return function ($product) use ($amt, &$count) {
            $count += $product->price;
            print "   count: $count\n";
            if ($count > $amt) {
                print "   high price reached: {$count}\n";
            }
        };
    }
}
// listing 04.97
$processor = new ProcessSale();
$processor->registerCallback(Totalizer2::warnAmount(8));
$processor->sale(new Product("shoes", 6));
print "\n";
$processor->sale(new Product("coffee", 6));

/*
shoes: processing
   count: 6
coffee: processing
   count: 12
   high price reached: 12
*/
```
注释：  
不仅演示了类中产生匿名函数的工厂模式，而且介绍了闭包。  
新的匿名函数可以应用父作用域的参数，就好象匿名函数可以记住创建它的上下文  
* Chapter 5 Object Tools  
## PHP and Packages
### PHP Packages and Namespaces
require()和include()区别  
require()引入文件后，当文件出错时，程序脚本立即中断  
include()引入文件后，出错时当前当前文件报错处理，继续执行后面的脚本  
具体使用需要权衡运行效率和严谨性  
考虑程序严谨性，可以使用require_once()  
考虑效率使用require()  
  
包管理  
为了定义不同文件下类的冲突  
PHP官方扩展中，类命名采用下划线格式 XML_RPC_Server()  
另一种是命名空间格式  
namespace Kyronbao\util  
  
use com\bear  
  
包含目录方式  
php.ini中有include_path可以添加，apache也可以设置.htaccess  
  
### Autoload
```
spl_autoload_register();
$writer = new Writer();
```
spl_autoload_register();注册后，当Writer()实例化时，如果没有找到Writer类，PHP会再次寻找  
writer.php(小写)或writer.inc的文件，当再次找到时进行实例化。  
  
如果想加载如Writer.php（首字母大写）的文件，也可以自定义函数来注册  
  
  
下面函数实现了命名空间和下划线两种方式类文件的加载  
```
// listing 05.13
class util_Blah
{
    public function wave()
    {
        print "saying hi from root";
    }
}

namespace util;
class LocalPath
{
    public function wave()
    {
        print "hello from ".get_class();
    }
}

// listing 05.18
$namespaces = function ($path) {
    if (preg_match('/\\\\/', $path)) {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    }
    if (file_exists("{$path}.php")) {
        require_once("{$path}.php");
    }
};

$underscores = function ($classname) {
    $path = str_replace('_', DIRECTORY_SEPARATOR, $classname);
    $path = __DIR__ . "/$path";
    if (file_exists("{$path}.php")) {
        require_once("{$path}.php");
    }
};

\spl_autoload_register($namespaces);
\spl_autoload_register($underscores);

$blah = new util_Blah();
$blah->wave(); // 经过测试，执行了类中的方法时，才会再次寻找并加载文件
$obj = new util\LocalPath();
$obj->wave();
```
  
可以看出，这种加载机制开销比较大，真实项目中，大型系统中的组件或第三方库可以有自己的自动加载策略  
  
## The Class and Object Functions
  
检查类中的函数  
```
// listing 05.26
$product = self::getProduct(); // acquire an object
$method = "getTitle";          // define a method name
print $product->$method();     // invoke the method

if (is_callable(array($product, $method))) {
    $product->$method();
}

if (method_exists($product, $method)) {
    print $product->$method(); // invoke the method
}
```
method_exists()除了返回public类型的，也返回protected和private类型的函数，所以  
不能保证is callable  
  
call_user_func_array(array)  
```
// listing 05.33
    public function __call($method, $args)
    {
        if (method_exists($this->thirdpartyShop, $method)) {
            return call_user_func_array(
                [
                     $this->thirdpartyShop,
                     $method
                ],
                $args
            );

