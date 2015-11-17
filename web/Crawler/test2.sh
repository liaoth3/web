clear
while true
do
	/etc/init.d/php5-fpm restart
	/etc/init.d/nginx restart
	for((i=0;i<2000;i++))
	do
		php ./run.php 10 20 1
		sleep 1
	done
done



