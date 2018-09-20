@echo off
if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe
"%PHP_COMMAND%" "%~dp0archive.php" %*
@endlocal
