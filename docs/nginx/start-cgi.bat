@ECHO OFF
ECHO Starting PHP FastCGI...
C:\env\nginx\RunHiddenConsole.exe C:\env\php\php-cgi.exe -b 127.0.0.1:9000
