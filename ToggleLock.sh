if [ "$1" == "lock" ];
then
echo 'LOCKING SITE SALES'
sudo mv /var/www/html/xvglotto/index.php /var/www/html/xvglotto/.index.php
sudo chmod 700 /var/www/html/xvglotto/.index.php
sudo mv /var/www/html/xvglotto/index.php.lock /var/www/html/xvglotto/index.php
echo 'SALES LOCKED'
fi

if [ "$1" == "unlock" ];
then
echo 'UNLOCKING SITE SALES'
sudo mv /var/www/html/xvglotto/index.php /var/www/html/xvglotto/index.php.lock
sudo mv /var/www/html/xvglotto/.index.php /var/www/html/xvglotto/index.php
sudo chmod 755 /var/www/html/xvglotto/index.php
echo 'SALES UNLOCKED'
fi

if [ "$#" -eq "0" ] ;
then
echo ''
echo "Please use the command lock or unlock"
echo 'example:'
echo './ToggleLock.sh lock'
echo './ToggleLock.sh unlock'
fi

