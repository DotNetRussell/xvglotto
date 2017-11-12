
dbpass=$1
ticket=$(mysql -u root --password=$dbpass -D xvglotto -e "SELECT * FROM tickets \G" | grep ticketNumber | sort -R | head -n 1 | grep ticketNumber | cut -d " " -f4)

echo 'WINNER WINNER CHICKEN DINNER! '
echo 'Ticket Number: ' $ticket 

payoutAddress=$(mysql -u root --password=$dbpass -D xvglotto -e "SELECT paymentAddress FROM tickets WHERE ticketNumber='"$ticket"';")
echo ''
echo 'PAY WINNINGS TO THIS ADDRESS'
echo $payoutAddress | cut -d " " -f2

