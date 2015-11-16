clear
while true
do
	for((i=0; i<$5; i++))
	do
		php ./run.php $1 $2 $3
		sleep $4
	done

done
