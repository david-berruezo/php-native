It is a complete simple rest server. To use it, copy files into a document root directory. 
Then you can use your browser: http://yourserver.com/rest/User/example
or bash: $ curl -u username:password -X POST http://yourserver.com/rest/User/login
URL parts: http://yourserver.com/rest/[REST OBJECT]/[REST OBJECT METHOD]/[PARAM]/[PARAM]/[PARAM]
File restObjects/rest_User.php is an example how to write your rest objects
