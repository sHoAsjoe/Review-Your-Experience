[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-24ddc0f5d75046c5622901739e7c5dd533143b0c8e959d652212380cedb1ea36.svg)](https://classroom.github.com/a/nv3Mm3uJ)
# HealthOne Sportcentrum
Uitwerking Project P6
File structure:
https://www.ictshore.com/php/php-project-structure/

# Configureer de vhosts
Je kan je XAMP zo configureren dat je meerdere PHP apps kan hosten op je locale PC. De 
apps kan je dan draaien op bijvoorbeeld: http://healthone.localhost/, http://app2.localhost/
Om dit zo te configureren moet je een aantal configuratie onderdelen bewerken.

## Windows
Zorg ervoor dat de Virtual host config file ingeladen wordt:
* Open Xammp
* Klik op Apache config -> Apache(httpd.conf)
* Zoek naar `Include conf/extra/httpd-vhosts.conf` en verwijder de `#` als deze vooraan deze regel aanwezig is.
* Voeg de onderstaande code toe aan de virtual host config: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
```
<VirtualHost *:80>
DocumentRoot "C:/xampp/htdocs"
ServerName localhost
</VirtualHost>

Listen 4001    
NameVirtualHost *:4001
<VirtualHost *:80 *:4001>
    DocumentRoot "C:/xampp/apps/healthone/htdocs/if-sd-php-healthone/public"
    ServerName healthone.localhost
    <Directory "C:/xampp/apps/healthone/htdocs/if-sd-php-healthone/public">
        Options Indexes FollowSymLinks ExecCGI Includes

	RewriteEngine on
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule ^(.*)$ index.php [NC,L,QSA]

        # AllowOverride controls what directives may be placed in .htaccess files.
        # It can be "All", "None", or any combination of the keywords:
        #   Options FileInfo AuthConfig Limit
        #
        #AllowOverride None
        # since XAMPP 1.4:
        AllowOverride All

        # Controls who can get stuff from this server.
        Require all granted
    </Directory>
</VirtualHost>
```
* Vervang `C:/xampp/apps/healthone/htdocs/if-sd-php-healthone/public` met de locatie waar jouw project staat. Zorg wel dat er `/public` er achter blijft staan. **Let op:** dit staat er twee keer in.
* Restart Apache in de XAMPP.
* Open nu de je project in PHPStorm.

