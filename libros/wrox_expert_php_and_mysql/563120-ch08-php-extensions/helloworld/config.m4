dnl
dnl $ Id: $
dnl

PHP_ARG_ENABLE(helloworld, whether to enable helloworld functions,
[  --enable-helloworld         Enable helloworld support])

if test "$PHP_HELLOWORLD" != "no"; then
  export OLD_CPPFLAGS="$CPPFLAGS"
  export CPPFLAGS="$CPPFLAGS $INCLUDES -DHAVE_HELLOWORLD"

  AC_MSG_CHECKING(PHP version)
  AC_TRY_COMPILE([#include <php_version.h>], [
#if PHP_VERSION_ID < 50100
#error  this extension requires at least PHP version 5.1.0rc1
#endif
],
[AC_MSG_RESULT(ok)],
[AC_MSG_ERROR([need at least PHP 5.1.0rc1])])

  export CPPFLAGS="$OLD_CPPFLAGS"


  PHP_SUBST(HELLOWORLD_SHARED_LIBADD)
  AC_DEFINE(HAVE_HELLOWORLD, 1, [ ])

  PHP_NEW_EXTENSION(helloworld, helloworld.c , $ext_shared)

fi

