/*
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.0 of the PHP license,       |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_0.txt.                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Authors: Andrew Curioso <andrew@example.com>                         |
   +----------------------------------------------------------------------+
*/

/* $ Id: $ */ 

#include "php_helloworld.h"
#include "standard/php_string.h"
#include<zend_interfaces.h>

#if HAVE_HELLOWORLD

#define OUTPUT_PRINT	0
#define OUTPUT_ARRAY	1
#define OUTPUT_STRING	2


/* {{{ globals and ini entries */
ZEND_DECLARE_MODULE_GLOBALS(helloworld)


#ifndef ZEND_ENGINE_2
#define OnUpdateLong OnUpdateInt
#endif
PHP_INI_BEGIN()
  STD_PHP_INI_ENTRY("helloworld.greeting", "hello", PHP_INI_USER, OnUpdateString, greeting, zend_helloworld_globals, helloworld_globals)
PHP_INI_END()

static void php_helloworld_init_globals(zend_helloworld_globals *helloworld_globals)
{
	helloworld_globals->greeting = NULL;

}

static void php_helloworld_shutdown_globals(zend_helloworld_globals *helloworld_globals)
{
}/* }}} */

/* {{{ phpinfo logo definitions */

#include "php_logos.h"


static unsigned char helloworld_logo[] = {
#include "helloworld_logos.h"
}; 
/* }}} */

/* {{{ Interface definitions */

/* {{{ Interface IGreeting */

static zend_class_entry * IGreeting_ce_ptr = NULL;

static zend_function_entry IGreeting_methods[] = {
	ZEND_FENTRY(sayGreeting, NULL, IGreeting__sayGreeting_args, ZEND_ACC_ABSTRACT |  ZEND_ACC_INTERFACE | ZEND_ACC_PUBLIC)
	{ NULL, NULL, NULL }
};

static void interface_init_IGreeting(void)
{
	zend_class_entry ce;

	INIT_CLASS_ENTRY(ce, "IGreeting", IGreeting_methods);
	IGreeting_ce_ptr = zend_register_internal_interface(&ce TSRMLS_CC);
}

/* }}} Class IGreeting */

/* }}} Interface definitions*/

/* {{{ Class definitions */

/* {{{ Class SimpleGreeter */

static zend_class_entry * SimpleGreeter_ce_ptr = NULL;

/* {{{ Methods */


/* {{{ proto mixed sayGreeting(string name [, bool do_return])
   */
PHP_METHOD(SimpleGreeter, sayGreeting)
{
	zend_class_entry * _this_ce;

	zval * _this_zval = NULL;
	const char * name = NULL;
	int name_len = 0;
	zend_bool do_return = 0;

	char *ret, *greeting;
	int ret_len;

	if (zend_parse_method_parameters(ZEND_NUM_ARGS() TSRMLS_CC, getThis(), "Os|b", &_this_zval, SimpleGreeter_ce_ptr, &name, &name_len, &do_return) == FAILURE) {
		return;
	}

	greeting = HELLOWORLD_G(greeting);

	if ( do_return ) {
		ret_len = spprintf(&ret, 0, "%s %s", greeting, name);
		RETURN_STRINGL(ret, ret_len, 1);
	} else {
		php_printf("%s %s", greeting, name);
	}
}
/* }}} say */


static zend_function_entry SimpleGreeter_methods[] = {
	PHP_ME(SimpleGreeter, sayGreeting, SimpleGreeter__say_args, /**/ZEND_ACC_PUBLIC & ~ZEND_ACC_ABSTRACT)
	{ NULL, NULL, NULL }
};

/* }}} Methods */

static void class_init_SimpleGreeter(void)
{
	zend_class_entry ce;

	INIT_CLASS_ENTRY(ce, "SimpleGreeter", SimpleGreeter_methods);
	SimpleGreeter_ce_ptr = zend_register_internal_class(&ce);

	zend_class_implements(SimpleGreeter_ce_ptr TSRMLS_CC, 1, IGreeting_ce_ptr);
}

/* }}} Class SimpleGreeter */

/* {{{ Class ComplexGreeter */

static zend_class_entry * ComplexGreeter_ce_ptr = NULL;

/* {{{ Methods */


/* {{{ proto array arraySay(array names)
   */
PHP_METHOD(ComplexGreeter, arraySay)
{
	zend_class_entry * _this_ce;

	zval * _this_zval = NULL;
	zval * names = NULL;
	HashTable * names_hash = NULL;

	HashPosition pointer;
	zval **data;
	char *greeting;
	int ret_len;
	char *ret;

	if (zend_parse_method_parameters(ZEND_NUM_ARGS() TSRMLS_CC, getThis(), "Oa/", &_this_zval, ComplexGreeter_ce_ptr, &names) == FAILURE) {
		return;
	}

	_this_ce = Z_OBJCE_P(_this_zval);

	names_hash = HASH_OF(names);

	array_init(return_value);

	greeting = HELLOWORLD_G(greeting);

	for ( zend_hash_internal_pointer_reset_ex(names_hash, &pointer);
	      zend_hash_get_current_data_ex(names_hash, (void **) &data, &pointer ) == SUCCESS;
	      zend_hash_move_forward_ex(names_hash, &pointer) ) {

		if ( Z_TYPE_PP(data) == IS_STRING ) {
			ret_len = spprintf(&ret, 0, "%s %s", greeting, Z_STRVAL_PP(data) );
			add_next_index_stringl(return_value, ret, ret_len, 0);
		}
	}
}
/* }}} arraySay */



/* {{{ proto mixed mysqliSay( mixed result [, int output_type] )
   */
PHP_METHOD(ComplexGreeter, mysqliSay)
{
	zend_class_entry * _this_ce;
	zend_class_entry ** mysqli_result_ce = NULL;

	zval *separator;
	char *greeting;

	zval * _this_zval = NULL;
	zval * result = NULL;
	long output_type = 0;

	char *field_name;
	int field_name_len;
	zval **field;

	zval *row;
	HashTable *row_hash;

	zval *greetings;

	if (zend_parse_method_parameters(ZEND_NUM_ARGS() TSRMLS_CC, getThis(), "Oos|l", &_this_zval, ComplexGreeter_ce_ptr, &result, &field_name, &field_name_len, &output_type) == FAILURE) {
		return;
	}

	_this_ce = Z_OBJCE_P(_this_zval);

	separator = zend_read_property(_this_ce, _this_zval, "separator", 9, 1 TSRMLS_CC);

	zend_lookup_class( "mysqli_result", 13, &mysqli_result_ce );

	if ( !mysqli_result_ce ) {
		php_error(E_WARNING, "MySQLi is required for the method mysqliSay on ComplexGreeter");
		RETURN_FALSE;
	}

	if ( instanceof_function( Z_OBJCE_P(result), *mysqli_result_ce ) == 0 ) {
		php_error(E_WARNING,"ComplexGreeter::mysqliSay(): Expected parameter 1 to be mysql_result, %s given",
			  Z_OBJCE_P(result)->name);
		RETURN_FALSE;
	}

	greeting = HELLOWORLD_G(greeting);

	if ( output_type ) {
		MAKE_STD_ZVAL( greetings );
		array_init( greetings );
	}

	zend_call_method_with_0_params( &result, NULL, NULL, "fetch_assoc", &row);
	while ( Z_TYPE_P( row ) != IS_NULL ) { 
		row_hash = Z_ARRVAL_P(row);

		if ( zend_hash_find( row_hash, field_name, field_name_len+1, (void **)&field ) == SUCCESS ) {

			if ( output_type ) {
				char *ret;
				int ret_len = spprintf(&ret, 0, "%s %s", greeting, Z_STRVAL_PP(field) );
				add_next_index_stringl(greetings, ret, ret_len, 0);

			} else {
				php_printf("%s %s%s", greeting, Z_STRVAL_PP(field), Z_STRVAL_P(separator) );
			}

		} else {
			RETURN_FALSE;
		}

		zval_dtor( row );
	        zend_call_method_with_0_params( &result, NULL, NULL, "fetch_assoc", &row);
	}
	efree(row);
	
	if ( output_type == OUTPUT_ARRAY ) {
		RETURN_ZVAL( greetings, 0, 0 );

	} else if ( output_type == OUTPUT_STRING ) {
		php_implode( separator, greetings, return_value TSRMLS_CC );
		concat_function( return_value, return_value, separator );	

		zval_dtor(greetings);
		efree(greetings);
		return;
	}

	RETURN_TRUE;

}
/* }}} mysqliSay */


static zend_function_entry ComplexGreeter_methods[] = {
	PHP_ME(ComplexGreeter, arraySay, ComplexGreeter__arraySay_args, /**/ZEND_ACC_PUBLIC)
	PHP_ME(ComplexGreeter, mysqliSay, ComplexGreeter__mysqliSay_args, /**/ZEND_ACC_PUBLIC)
	{ NULL, NULL, NULL }
};

/* }}} Methods */

static void class_init_ComplexGreeter(void)
{
	zend_class_entry ce;

	INIT_CLASS_ENTRY(ce, "ComplexGreeter", ComplexGreeter_methods);
	ComplexGreeter_ce_ptr = zend_register_internal_class_ex(&ce, SimpleGreeter_ce_ptr, NULL TSRMLS_CC);

	/* {{{ Property registration */

	zend_declare_property_string(ComplexGreeter_ce_ptr, 
		"separator", 9, "<br />\n", 
		ZEND_ACC_PUBLIC TSRMLS_DC);

	/* }}} Property registration */


	/* {{{ Constant registration */

	do {
		zval *tmp, *val;

		tmp = (zval *) malloc(sizeof(zval));
		INIT_PZVAL(tmp);
		ZVAL_LONG(tmp, 0);
		zend_symtable_update(&(ComplexGreeter_ce_ptr->constants_table), "OUTPUT_PRINT", 13, (void *) &tmp, sizeof(zval *), NULL);

		tmp = (zval *) malloc(sizeof(zval));
		INIT_PZVAL(tmp);
		ZVAL_LONG(tmp, 1);
		zend_symtable_update(&(ComplexGreeter_ce_ptr->constants_table), "OUTPUT_ARRAY", 13, (void *) &tmp, sizeof(zval *), NULL);

		tmp = (zval *) malloc(sizeof(zval));
		INIT_PZVAL(tmp);
		ZVAL_LONG(tmp, 2);
		zend_symtable_update(&(ComplexGreeter_ce_ptr->constants_table), "OUTPUT_STRING", 14, (void *) &tmp, sizeof(zval *), NULL);

	} while(0);

	/* } Constant registration */

}

/* }}} Class ComplexGreeter */

/* }}} Class definitions*/

/* {{{ helloworld_functions[] */
function_entry helloworld_functions[] = {
	{ NULL, NULL, NULL }
};
/* }}} */

/* {{{ cross-extension dependencies */

#if ZEND_EXTENSION_API_NO >= 220050617
static zend_module_dep helloworld_deps[] = {
	ZEND_MOD_REQUIRED("standard")
	ZEND_MOD_OPTIONAL("mysqli")
	{NULL, NULL, NULL, 0}
};
#endif
/* }}} */

/* {{{ helloworld_module_entry
 */
zend_module_entry helloworld_module_entry = {
#if ZEND_EXTENSION_API_NO >= 220050617
		STANDARD_MODULE_HEADER_EX, NULL,
		helloworld_deps,
#else
		STANDARD_MODULE_HEADER,
#endif

	"helloworld",
	helloworld_functions,
	PHP_MINIT(helloworld),     /* Replace with NULL if there is nothing to do at php startup   */ 
	PHP_MSHUTDOWN(helloworld), /* Replace with NULL if there is nothing to do at php shutdown  */
	PHP_RINIT(helloworld),     /* Replace with NULL if there is nothing to do at request start */
	PHP_RSHUTDOWN(helloworld), /* Replace with NULL if there is nothing to do at request end   */
	PHP_MINFO(helloworld),
	"0.1", 
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_HELLOWORLD
ZEND_GET_MODULE(helloworld)
#endif




/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(helloworld)
{
	ZEND_INIT_MODULE_GLOBALS(helloworld, php_helloworld_init_globals, php_helloworld_shutdown_globals)
	REGISTER_INI_ENTRIES();
	php_register_info_logo("HELLOWORLD_LOGO_ID", "", helloworld_logo, 197);
	interface_init_IGreeting();
	class_init_SimpleGreeter();
	class_init_ComplexGreeter();

	/* add your stuff here */

	return SUCCESS;
}
/* }}} */


/* {{{ PHP_MSHUTDOWN_FUNCTION */
PHP_MSHUTDOWN_FUNCTION(helloworld)
{
	UNREGISTER_INI_ENTRIES();
	php_unregister_info_logo("HELLOWORLD_LOGO_ID");

	/* add your stuff here */

	return SUCCESS;
}
/* }}} */


/* {{{ PHP_RINIT_FUNCTION */
PHP_RINIT_FUNCTION(helloworld)
{
	/* add your stuff here */

	return SUCCESS;
}
/* }}} */


/* {{{ PHP_RSHUTDOWN_FUNCTION */
PHP_RSHUTDOWN_FUNCTION(helloworld)
{
	/* add your stuff here */

	return SUCCESS;
}
/* }}} */


/* {{{ PHP_MINFO_FUNCTION */
PHP_MINFO_FUNCTION(helloworld)
{
	php_info_print_box_start(0);

	php_printf("<img src='");
	if (SG(request_info).request_uri) {
		php_printf("%s", (SG(request_info).request_uri));
	}   
	php_printf("?=%s", "HELLOWORLD_LOGO_ID");
	php_printf("' align='right' alt='image' border='0'>\n");

	php_printf("<p>A Hello World extension</p>\n");
	php_printf("<p>Version 0.1alpha (2009-10-12)</p>\n");
	php_printf("<p><b>Authors:</b></p>\n");
	php_printf("<p>Andrew Curioso &lt;andrew@example.com&gt; (lead)</p>\n");
	php_info_print_box_end();
	/* add your stuff here */

	DISPLAY_INI_ENTRIES();
}
/* }}} */

#endif /* HAVE_HELLOWORLD */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
