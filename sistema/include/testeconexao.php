<?php
$con_string = "host= ".getenv('HOST')." port= ".getenv('PORT')." dbname= ".getenv('DBNAME')." user= ".getenv('USER')." password= ".getenv('PASSWORD');
//$dbcon = pg_connect($con_string);

echo("HOST -> ".getenv('HOST')."<br />");
echo("PORT -> ".getenv('PORT')."<br />");
echo("LDADBNAMEPDOMINIO -> ".getenv('DBNAME')."<br />");
echo("USER -> ".getenv('USER')."<br />");
echo("PASSWORD -> ".getenv('PASSWORD')."<br />");

echo("SESAPI -> ".getenv('SESAPI')."<br />");
echo("LDAPSERVER -> ".getenv('LDAPSERVER')."<br />");
echo("LDAPDOMINIO -> ".getenv('LDAPDOMINIO')."<br />");
echo("LDAPENDERECO -> ".getenv('LDAPENDERECO')."<br />");
echo("LDAPPASS -> ".getenv('LDAPPASS')."<br />");

//@pg_close($dbcon);
?>