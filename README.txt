# Requirements:

sudo apt install apache2 php php-mysql libapache2-mod-php php-bcmath -y

# Directions how to replace the default apache folder with this registration page

cd ~
git clone https://github.com/trumpetx/cmagnos-web.git
cd /var/www 
rm -rf html # remove default apache webpage
sudo ln -s /home/$USER/cmagnos-web html