dbpass=$1

sudo mysql -u root --password=$dbpass -D xvglotto -e "SELECT * FROM tickets;"

echo 'TOTAL TICKETS SOLD: ' 

count=sudo mysql -u root --password=$dbpass -D xvglotto -e "SELECT count(*) FROM tickets;"


