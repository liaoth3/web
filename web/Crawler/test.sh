clear
while true
do
	/etc/init.d/nginx restart
    sleep 1
	/etc/init.d/php5-fpm restart
	sleep 1
	for((i=0; i<$5; i++))
	do
		php ./run.php $1 $2 $3
		sleep $4
	done

done
