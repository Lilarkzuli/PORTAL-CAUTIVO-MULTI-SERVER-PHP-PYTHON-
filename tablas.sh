#!/bin/bash

ipt=/sbin/iptables

# Limpiar todas las reglas y cadenas existentes
$ipt -F
$ipt -X
$ipt -Z
$ipt -t nat -F
$ipt -t nat -X
$ipt -t nat -Z

# Establecer las políticas predeterminadas de los chains
$ipt -P INPUT DROP
$ipt -P OUTPUT DROP
$ipt -P FORWARD DROP
$ipt -t nat -P PREROUTING ACCEPT
$ipt -t nat -P POSTROUTING ACCEPT

# Aceptar tráfico entrante y saliente en la interfaz enp0s9
$ipt -A INPUT -i enp0s9 -j ACCEPT
$ipt -A OUTPUT -o enp0s9 -j ACCEPT

# Permitir comunicación local
$ipt -A INPUT -i lo -j ACCEPT
$ipt -A OUTPUT -o lo -j ACCEPT

# Permitir SSH
$ipt -A INPUT -p tcp --dport 22 -j ACCEPT
$ipt -A OUTPUT -p tcp --sport 22 -j ACCEPT



#$ipt -t nat -A PREROUTING -s 192.168.70.10 -p tcp --dport 80 -j DNAT --to-destination www.msftconnecttest.com

#$ipt -A INPUT -p tcp --dport 80 -j ACCEPT
#$ipt -A OUTPUT -p tcp --sport 80 -j ACCEPT

#$ipt -t mangle -A PREROUTING -i enp0s8 -s 192.168.70.10 -m mark --mark 0x2 -j DROP
# Crear la cadena "internet" en la tabla mangle





$ipt -t mangle -A PREROUTING -i enp0s8 -s 192.168.70.10 -j MARK --set-mark 1
$ipt -t nat -A PREROUTING -i enp0s8 -p tcp --dport 80 -m mark ! --mark 1 -j DNAT --to 192.168.80.20:80
$ipt -t nat -A PREROUTING -i enp0s8 -p tcp --dport 443 -m mark ! --mark 1 -j DNAT --to 192.168.80.20:443






#$ipt -t mangle -A PREROUTING -i enp0s8 -p tcp --dport 80 -j internet
#$ipt -t mangle -A internet -j MARK --set-mark 99

# Redirigir tráfico HTTP al portal cautivo
#$ipt -t nat -A PREROUTING -i enp0s8 -p tcp -m mark --mark 99 --dport 80 -j DNAT --to-destination 192.168.80.20:80

$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24  -p tcp --dport 80 -j ACCEPT
$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24  -p tcp  --dport 443 -j ACCEPT
$ipt -A FORWARD -i enp0s3 -p tcp --sport 80  -d 192.168.70.0/24 -j ACCEPT
$ipt -A FORWARD -i enp0s3 -p tcp --sport 443 -d 192.168.70.0/24 -j ACCEPT

# Permitir tráfico DNS
$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p udp --dport 53 -d 192.168.110.1 -j ACCEPT
$ipt -A FORWARD -i enp0s3 -s 192.168.110.1 -p udp --sport 53 -d 192.168.70.0/24 -j ACCEPT
$ipt -A FORWARD -i enp0s8 -s 192.168.70.0/24 -p udp --dport 53 -d 8.8.4.4 -j ACCEPT
$ipt -A FORWARD -i enp0s3 -s 8.8.4.4 -p udp --sport 53 -d 192.168.70.0/24 -j ACCEPT

# Permitir tráfico establecido y relacionado
$ipt -A INPUT -i enp0s3 -m state --state ESTABLISHED,RELATED -j ACCEPT
$ipt -A INPUT -i enp0s8 -m state --state ESTABLISHED,RELATED -j ACCEPT

# Permitir tráfico MySQL
$ipt -A FORWARD -i enp0s8 -p tcp -d 192.168.80.20 --dport 3306 -j ACCEPT
$ipt -A FORWARD -i enp0s9 -p tcp -s 192.168.80.20 --sport 3306 -j ACCEPT
$ipt -t nat -A PREROUTING -i enp0s8 -p tcp -d 192.168.70.10 --dport 3306 -j DNAT --to 192.168.80.20:3306

# Permitir tráfico entre DMZ e Internet
$ipt -A FORWARD -i enp0s3 -p tcp -d 192.168.80.20 --dport 80 -j ACCEPT
$ipt -A FORWARD -i enp0s9 -p tcp -s 192.168.80.20 --sport 80 -j ACCEPT
$ipt -t nat -A PREROUTING -i enp0s3 -p tcp -d 192.168.110.170  --dport 80 -j DNAT --to 192.168.80.20:80

$ipt -A FORWARD -i enp0s8 -p tcp -d 192.168.80.20 --dport 80 -j ACCEPT
$ipt -A FORWARD -i enp0s9 -p tcp -d 192.168.80.20 --sport 80 -j ACCEPT
$ipt -t nat -A PREROUTING -i enp0s8 -p tcp -d 192.168.70.10 --dport 80 -j DNAT --to 192.168.80.20:80





# Habilitar el reenvío de paquetes
echo 1 > /proc/sys/net/ipv4/ip_forward

# Realizar el masquerading (NAT) para la red interna
$ipt -t nat -A POSTROUTING -s 192.168.70.0/24 -o enp0s3 -j MASQUERADE
