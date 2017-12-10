if [ $# -eq "3" ]; then

	mysql -u root -p -D xvglotto -e "update potinfo SET ticketsSold ="$1",ticketPrice="$2",seedAmount="$3";select*from potinfo;"
	echo 'Updating pot info'
	echo 'Setting Tickets Sold:'$1
	echo 'Setting Ticket Price:'$2
	echo 'Setting Seed Amount:'$3

else
	echo 'In order to update the pot info, please run'
	echo ''
	echo './UpdatePot.sh <ticektsSold> <ticketPrice> <seedAmount>'
	echo ''
	echo 'Example:'
	echo './UpdatePot.sh 10 300 5000'
fi
