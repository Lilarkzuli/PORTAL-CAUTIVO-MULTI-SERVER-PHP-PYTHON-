#!/bin/bash
ipt=/sbin/iptables


$ipt -F
$ipt -X
$ipt -Z
$ipt -t nat -F
$ipt -t nat -X
$ipt -t	nat -Z
$ipt -P INPUT  DROP
$ipt -P OUTPUT DROP
$ipt -P FORWARD DROP
$ipt -t nat -P PREROUTING ACCEPT
$ipt -t nat -P POSTROUTING ACCEPT



$ipt -A INPUT -i enp0s9 -j ACCEPT

# Permitir todo el tráfico saliente en la interfaz enp0s9
$ipt -A OUTPUT -o enp0s9 -j ACCEPT


#comunicacion local

$ipt -A INPUT -i lo -j ACCEPT
$ipt -A OUTPUT -o lo -j ACCEPT



#ssh 
$ipt -A INPUT -p tcp --dport 22   -j ACCEPT
$ipt -A OUTPUT -p tcp --sport 22 -j ACCEPT




$ipt -A FORWARD -s 192.168.70.0/24 -i enp0s8 -j ACCEPT

#WEB Y WEB SEGURA
$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p tcp --dport 80 -j ACCEPT
$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p tcp --dport 443 -j ACCEPT

$ipt -A FORWARD -i enp0s3 -p tcp --sport 80 -d 192.168.70.0/24 -j ACCEPT
$ipt -A FORWARD -i enp0s3 -p tcp --sport 443 -d 192.168.70.0/24 -j ACCEPT

#DNS
$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p udp --dport 53 -d 192.168.110.1 -j ACCEPT
$ipt -A FORWARD -i enp0s3 -s 192.168.110.1 -p udp --sport 53 -d 192.168.70.0/24 -j ACCEPT

$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p udp --dport 53 -d 8.8.4.4 -j ACCEPT
$ipt -A FORWARD -i enp0s3 -s 8.8.4.4 -p udp --sport 53 -d 192.168.70.0/24 -j ACCEPT

$ipt -A INPUT -i enp0s3 -m state --state ESTABLISHED,RELATED -j ACCEPT






#MYSQL
$ipt -A FORWARD -i enp0s8 -p tcp -d 192.168.80.20 --dport 3306 -j ACCEPT
$ipt -A FORWARD -i enp0s9 -p tcp -s  192.168.80.20 --sport 3306 -j ACCEPT
$ipt -t nat -A PREROUTING -i enp0s8 -p tcp -d 192.168.70.10 --dport 3306 -j DNAT --to 192.168.80.20:3306
#mysql hacia firewall
#$ipt -A FORWARD -i enp0s9 -p tcp -s 192.168.80.20 --sport 3306 -j ACCEPT
#$ipt -A FORWARD -i enp0s9 -p tcp -d 192.168.80.20 --dport 3306 -j ACCEPT
#$ipt -t nat -A PREROUTING -i lo -p tcp -d 192.168.80.10 --dport 3306 -j DNAT --to 192.168.80.20:3306

# Permitir tráfico entrante desde la red 192.168.80.20 hacia el firewall en el puerto 3306
#$ipt -A INPUT -i enp0s9 -s 192.168.80.20 -p tcp --dport 3306 -j ACCEPT

# Permitir tráfico saliente desde el firewall hacia la red 192.168.80.20 en el puerto 3306

#$ipt -A OUTPUT -o enp0s9 -d 192.168.80.20 -p tcp --sport 3306 -m state --state RELATED,ESTABLISHED -j ACCEPT


#start



#permitir trafico entre dmz y internet

$ipt -A FORWARD -i enp0s3 -p tcp -d 192.168.80.20 --dport 80 -j ACCEPT
$ipt -A FORWARD -i enp0s9 -p tcp -s 192.168.80.20 --sport 80 -j ACCEPT
$ipt -t nat -A PREROUTING -i enp0s3 -p tcp  --dport 80 -j DNAT --to 192.168.80.20:80

$ipt -A FORWARD -i enp0s8 -p tcp -d 192.168.80.20 --dport 80 -j ACCEPT
$ipt -A FORWARD -i enp0s9 -p tcp -d 192.168.80.20 --sport 80 -j ACCEPT
$ipt -t nat -A PREROUTING -i enp0s8 -p tcp -d 192.168.70.10 --dport 80 -j DNAT --to 192.168.80.20:80



DB_HOST="192.168.80.20"
DB_USER="root"
DB_PASS="123"
DB_NAME="Acceso"

# Consulta SQL para ejecutar
SQL_QUERY="SELECT * FROM registro_conexiones;"
echo "$RESULTS" | while IFS=$'\t' read -r col1 col2 col3; do
    echo "Columna 1: $col1, Columna 2: $col2, Columna 3: $col3"
done


#portal cautivo
$ipt -t nat -A PREROUTING -i enp0s8 -p tcp  --dport 80 -j DNAT --to 192.168.80.20:80


echo 1 > /proc/sys/net/ipv4/ip_forward
$ipt -t nat -A POSTROUTING -s 192.168.70.0/24 -o enp0s3 -j MASQUERADE
