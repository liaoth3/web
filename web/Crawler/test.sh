clear
while true
do
	/etc/init.d/nginx restart
    /etc/init.d/php5-fpm restart
	#/etc/init.d/redis-server restart
	for((i=0; i<$5; i++))
	do
		php ./run.php $1 $2 $3
		sleep $4
	done

done
