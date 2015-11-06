#!/bin/sh
#edit www.jbxue.com
#
processname="firefox"
echo "firefox"
for pid in $(ps aux |grep $processname |grep -v grep|awk '{print $2}'); do
kill -9 $pid

sleep 1
firefox
done
