# twembedsh
Retweets automáticos e incrustados

Crear una aplicación en Twitter: https://apps.twitter.com/app/new.

Establecer para la aplicación permisos “Read and write”.

En "Keys and Accces Tokens" obtienes los parametros de configuración necesarios para la autenticación y autorización. 
Para este fin utiliza la librería TwitterAPIExchange.php. El certificado que utiliza es cacert.pem.

Index.php: realiza los retweets de forma automática e imprime los tweets en pantalla.
Twembed.php: incrusta los tweets en la página.
Config.php: permite establecer los valores de búsqueda. Palabras y cuentas de usuario donde buscar.
