
echo ''
echo 'RESET STARTED'
echo ''
echo ''
echo 'Last chance to see this info...'
mysql -u root -p -D xvglotto -e "select * from tickets;select * from referals;select * from potinfo;delete from tickets;delete from referals;"
