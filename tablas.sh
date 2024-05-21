

/sbin/iptables -F
/sbin/iptables -X
/sbin/iptables -Z
/sbin/iptables -t nat -F
/sbin/iptables -t nat -X
/sbin/iptables -t nat -Z


/sbin/iptables -P INPUT DROP
/sbin/iptables -P OUTPUT DROP
/sbin/iptables -P FORWARD DROP
/sbin/iptables -t nat -P PREROUTING ACCEPT
/sbin/iptables -t nat -P POSTROUTING ACCEPT

/sbin/iptables -A INPUT -i enp0s9 -j ACCEPT
/sbin/iptables -A OUTPUT -o enp0s9 -j ACCEPT


/sbin/iptables -A INPUT -i lo -j ACCEPT
/sbin/iptables -A OUTPUT -o lo -j ACCEPT

/sbin/iptables -A INPUT -p tcp --dport 22 -j ACCEPT
/sbin/iptables -A OUTPUT -p tcp --sport 22 -j ACCEPT


/sbin/iptables -A INPUT -p udp --dport 53 -j ACCEPT
/sbin/iptables -A OUTPUT -p udp --sport 53 -j ACCEPT



/sbin/iptables  -A INPUT -p tcp --dport 53 -j ACCEPT 
/sbin/iptables  -A OUTPUT -p tcp --sport 53 -j ACCEPT
/sbin/iptables  -A INPUT -p udp --dport 67 -j ACCEPT 
/sbin/iptables  -A OUTPUT -p udp --sport 67 -j ACCEPT
/sbin/iptables -A INPUT -p udp --dport 68 -j ACCEPT 
/sbin/iptables  -A OUTPUT -p udp --sport 68 -j ACCEPT
/sbin/iptables -A INPUT -p tcp --dport 67 -j ACCEPT
/sbin/iptables  -A OUTPUT -p tcp --sport 67 -j ACCEPT
/sbin/iptables  -A INPUT -p tcp --dport 68 -j ACCEPT 
/sbin/iptables -A OUTPUT -p tcp --sport 68 -j ACCEPT


/sbin/iptables -t nat -A PREROUTING -p tcp -s 192.168.70.0/24 --dport 80 -j REDIRECT --to-port 3129
/sbin/iptables -t nat -A PREROUTING -p tcp -s 192.168.70.0/24 --dport 443 -j REDIRECT --to-port 3130

/sbin/iptables  -A OUTPUT -d 192.168.110.170 -p udp --dport 53 -j ACCEPT 
/sbin/iptables -A INPUT -s 192.168.110.170 -p udp --sport 53 -m state --state RELATED,ESTABLISHED -j ACCEPT 
/sbin/iptables -A OUTPUT -d 192.168.110.170 -p tcp --dport 53 -j ACCEPT 
/sbin/iptables  -A INPUT -s 192.168.110.170  -p tcp --sport 53 -m state --state RELATED,ESTABLISHED -j ACCEPT

/sbin/iptables  -A OUTPUT -d 8.8.8.8 -p udp --dport 53 -j ACCEPT 
/sbin/iptables  -A INPUT -s 8.8.8.8 -p udp --sport 53 -m state --state RELATED,ESTABLISHED -j ACCEPT 
/sbin/iptables  -A OUTPUT -d 8.8.8.8 -p tcp --dport 53 -j ACCEPT
/sbin/iptables  -A INPUT -s 8.8.8.8 -p tcp --sport 53 -m state --state RELATED,ESTABLISHED -j ACCEPT

/sbin/iptables -t mangle -A PREROUTING -i enp0s8 -s 192.168.70.10 -j MARK --set-mark 1
/sbin/iptables -t nat -A PREROUTING -i enp0s8 -p tcp --dport 80 -m mark ! --mark 1 -j DNAT --to 192.168.80.20:80
/sbin/iptables -t nat -A PREROUTING -i enp0s8 -p tcp --dport 443 -m mark ! --mark 1 -j DNAT --to 192.168.80.20:443

/sbin/iptables -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p tcp --dport 80 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p tcp --dport 443 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s3 -p tcp --sport 80 -d 192.168.70.0/24 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s3 -p tcp --sport 443 -d 192.168.70.0/24 -j ACCEPT


/sbin/iptables -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p udp --dport 53 -d 192.168.110.170  -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s3 -s 192.168.110.170  -p udp --sport 53 -d 192.168.70.0/24 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p udp --dport 53 -d 8.8.8.8 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s3 -s 8.8.8.8 -p udp --sport 53 -d 192.168.70.0/24 -j ACCEPT


/sbin/iptables -A INPUT -i enp0s3 -m state --state ESTABLISHED,RELATED -j ACCEPT
/sbin/iptables -A INPUT -i enp0s8 -m state --state ESTABLISHED,RELATED -j ACCEPT


/sbin/iptables -A FORWARD -i enp0s8 -p tcp -d 192.168.80.20 --dport 3306 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s9 -p tcp -s 192.168.80.20 --sport 3306 -j ACCEPT
/sbin/iptables -t nat -A PREROUTING -i enp0s8 -p tcp -d 192.168.70.10 --dport 3306 -j DNAT --to 192.168.80.20:3306


/sbin/iptables -A FORWARD -i enp0s3 -p tcp -d 192.168.80.20 --dport 80 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s9 -p tcp -s 192.168.80.20 --sport 80 -j ACCEPT
/sbin/iptables -t nat -A PREROUTING -i enp0s3 -p tcp -d 192.168.110.170 --dport 80 -j DNAT --to 192.168.80.20:80

/sbin/iptables -A FORWARD -i enp0s8 -p tcp -d 192.168.80.20 --dport 80 -j ACCEPT
/sbin/iptables -A FORWARD -i enp0s9 -p tcp -d 192.168.80.20 --sport 80 -j ACCEPT
/sbin/iptables -t nat -A PREROUTING -i enp0s8 -p tcp -d 192.168.70.10 --dport 80 -j DNAT --to 192.168.80.20:80



