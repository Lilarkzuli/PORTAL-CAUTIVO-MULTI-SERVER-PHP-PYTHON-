


/sbin/iptables -F
/sbin/iptables -X
/sbin/iptables -Z
/sbin/iptables -t nat -F
/sbin/iptables -t nat -X
/sbin/iptables -t nat -Z
/sbin/iptables -t mangle -F
/sbin/iptables -t mangle -X

/sbin/iptables -P INPUT ACCEPT
/sbin/iptables -P OUTPUT ACCEPT
/sbin/iptables -P FORWARD ACCEPT
/sbin/iptables -t nat -P PREROUTING ACCEPT
/sbin/iptables -t nat -P POSTROUTING ACCEPT
/sbin/iptables -t mangle -P INPUT ACCEPT
/sbin/iptables -t mangle -P OUTPUT ACCEPT
/sbin/iptables -t mangle -P FORWARD ACCEPT


sudo echo 1 > /proc/sys/net/ipv4/ip_forward


/sbin/iptables -t nat -A POSTROUTING -s 192.168.70.0/24 -o enp0s3 -j MASQUERADE
/sbin/iptables -t nat -A POSTROUTING -s 192.168.80.0/24 -o enp0s3 -j MASQUERADE


