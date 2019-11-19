! #！/bin/bash

total=100
filename=readme.txt
for ((i=1;i<=$total;i++));
do
echo $i|awk '{printf("%05d\n",$0)}' >> $filename
done
