#!/bin/bash
echo "Fem neteja d'IPTABLES de la màquina"

## DEFINIM LA VARIABLE QUE CONTÉ LA RUTA ABSOLUTA
## A L'EXECUTABLE DEL IPTABLES
ipt=/usr/sbin/iptables

## Eliminem les regles
$ipt -F
$ipt -X
$ipt -Z
$ipt -t nat -F
$ipt -t nat -X
$ipt -t nat -Z

## Política per defecte
$ipt -P INPUT ACCEPT
$ipt -P OUTPUT ACCEPT
$ipt -P FORWARD ACCEPT
$ipt -t nat -P PREROUTING ACCEPT
$ipt -t nat -P POSTROUTING ACCEPT



iptables -t mangle -F
iptables -t mangle -X
iptables -t mangle -P INPUT ACCEPT
iptables -t mangle -P OUTPUT ACCEPT
iptables -t mangle -P FORWARD ACCEPT

# Habilitem el bit de Forwarding
echo 1 > /proc/sys/net/ipv4/ip_forward

# Fem que la xarxa LAN pugui sortir a internet
$ipt -t nat -A POSTROUTING -s 192.168.70.0/24 -o enp0s3 -j MASQUERADE
$ipt -t nat -A POSTROUTING -s 192.168.80.0/24 -o enp0s3 -j MASQUERADE

# Fem que la xarxa DMZ pugui sortir a internet

# Fi
echo "Neteja finalitzada"

