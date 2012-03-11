<?php # this file is a IDE honeypot :)

// HOWTO: 
// declare the class you want autocomplete for then extend the class you need it 
// to map methods to; IDEs will crawl this file and make the connection--this 
// won't affect autoloading or the application in any way (the file isn't used)

// [!!] changes may not take effect imediatly

namespace app;

class Kohana extends kohana\core\Kohana {}

# bridge mapping

class Config_File extends \Config_File {}
class Config_Group extends \Config_Group {} 
class Controller_Template extends \Controller_Template {}
class HTTP_Exception_400 extends \HTTP_Exception_400 {}
class HTTP_Exception_401 extends \HTTP_Exception_401 {}
class HTTP_Exception_402 extends \HTTP_Exception_402 {}
class HTTP_Exception_403 extends \HTTP_Exception_403 {}
class HTTP_Exception_404 extends \HTTP_Exception_404 {}
class HTTP_Exception_405 extends \HTTP_Exception_405 {}
class HTTP_Exception_406 extends \HTTP_Exception_406 {}
class HTTP_Exception_407 extends \HTTP_Exception_407 {}
class HTTP_Exception_408 extends \HTTP_Exception_408 {}
class HTTP_Exception_409 extends \HTTP_Exception_409 {}
class HTTP_Exception_410 extends \HTTP_Exception_410 {}
class HTTP_Exception_411 extends \HTTP_Exception_411 {}
class HTTP_Exception_412 extends \HTTP_Exception_412 {}
class HTTP_Exception_413 extends \HTTP_Exception_413 {}
class HTTP_Exception_414 extends \HTTP_Exception_414 {}
class HTTP_Exception_415 extends \HTTP_Exception_415 {}
class HTTP_Exception_416 extends \HTTP_Exception_416 {}
class HTTP_Exception_417 extends \HTTP_Exception_417 {}
class HTTP_Exception_500 extends \HTTP_Exception_500 {}
class HTTP_Exception_501 extends \HTTP_Exception_501 {}
class HTTP_Exception_502 extends \HTTP_Exception_502 {}
class HTTP_Exception_503 extends \HTTP_Exception_503 {}
class HTTP_Exception_504 extends \HTTP_Exception_504 {}
class HTTP_Exception_505 extends \HTTP_Exception_505 {}
class HTTP_Cache extends \HTTP_Cache {}
class HTTP_Exception extends \HTTP_Exception {}
class HTTP_Header extends \HTTP_Header {}
class HTTP_Message extends \HTTP_Message {}
class HTTP_Request extends \HTTP_Request {}
class HTTP_Response extends \HTTP_Response {}
class Log_File extends \Log_File {}
class Log_Stderr extends \Log_Stderr {}
class Log_Stdout extends \Log_Stdout {}
class Log_Syslog extends \Log_Syslog {}
abstract class Log_Writer extends \Log_Writer {}
class Request_Client_Curl extends \Request_Client_Curl {}
abstract class Request_Client_External extends \Request_Client_External {}
class Request_Client_HTTP extends \Request_Client_HTTP {}
class Request_Client_Internal extends \Request_Client_Internal {}
class Request_Client_Stream extends \Request_Client_Stream {}
abstract class Request_Client extends \Request_Client {}
class Request_Exception extends \Request_Exception {}
class Session_Cookie extends \Session_Cookie {}
class Session_Exception extends \Session_Exception {}
class Session_Native extends \Session_Native {}
class Utf8_Exception extends \Utf8_Exception {}
class Validation_Exception extends \Validation_Exception {}
class View_Exception extends \View_Exception {}
class Arr extends \Arr {}
class CLI extends \CLI {}
class Config extends \Config {}
class Controller extends \Controller {}
class Cookie extends \Cookie {}
class Date extends \Date {}
class Debug extends \Debug {}
class Ecnrypt extends \Ecnrypt {}
class Feed extends \Feed {}
class File extends \File {}
class Form extends \Form {}
class Fragment extends \Fragment {}
class HTML extends \HTML {}
class HTTP extends \HTTP {}
class I18n extends \I18n {}
class Inflector extends \Inflector {}
class Log extends \Log {}
class Model extends \Model {}
class Num extends \Num {}
class Profiler extends \Profiler {}
class Request extends \Request {}
class Response extends \Response {}
class Route extends \Route {}
class Security extends \Security {}
abstract class Session extends \Session {}
class Text extends \Text {}
class Upload extends \Upload {}
class URL extends \URL {}
class UTF8 extends \UTF8 {}
class Valid extends \Valid {}
class Validation extends \Validation {}
class View extends \View {}
