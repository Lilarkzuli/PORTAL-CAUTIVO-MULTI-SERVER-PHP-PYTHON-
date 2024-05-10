
import subprocess
import mysql.connector
import time
from datetime import datetime, timedelta
import scapy.all as scapy  
import argparse
import socket
import requests


print("inicio")
iptables="/usr/sbin/iptables"

def run_iptables_command(command):
    subprocess.run(command, shell=True, check=True)


def correr(command):
    subprocess.run(command, shell=True, check=True)
    
    
    
borrar_todo="sudo tc qdisc del dev enp0s8 root"

try:
    correr(borrar_todo)
except:
    print("no existe ya")


try:
    run="sudo tc qdisc add dev enp0s8 root"
    correr(run)
except:
    print("no se pudo")

run2="sudo tc qdisc add dev enp0s8 root handle 1: htb default 11"
correr(run2)

run3="sudo tc class add dev enp0s8 parent 1: classid 1:10 htb rate 5mbit ceil 5mbit"
correr(run3)

run4="sudo tc class add dev enp0s8 parent 1: classid 1:11 htb rate 1mbit ceil 1mbit"
correr(run4)



while True:
  
    
    # Conexión a la base de datos
    conexion1 = mysql.connector.connect(host="192.168.80.20", user="root", passwd="123")
    cursor1 = conexion1.cursor()
    cursor1.execute("USE Acceso")
    cursor1.execute("SELECT * FROM registro_conexiones")
    resultados = cursor1.fetchall()


    if resultados:  # Verificar si hay resultados
        
        for base in resultados:         
            print(resultados)
            ip = base[3]
            nombre=base[2]
            tiempo=base[7]
            tipo=base[6]
            print(tipo)
            print(ip, nombre, tiempo)
            total = f"arp -n {ip}"
            aprobado = subprocess.run(total, shell=True, check=True, capture_output=True, text=True)
            salida = aprobado.stdout
            print(salida)
            lineas = salida.splitlines()
            linea = lineas[1]
            linea = linea.split()
            print(linea)
            mac = linea[2]
        
                
            
            print(mac)
            inserta="UPDATE registro_conexiones SET mac = %s WHERE ip = %s"
            datos=(mac,ip,)
            cursor1.execute(inserta, datos)
            
            coma=f"sudo {iptables} -t mangle -A PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 1"
            run_iptables_command(coma)
            print(coma)
         
            hora_registro = datetime.now()
            if tipo=="gratis":
                una_hora = timedelta(hours=1)
                tiempo_exp= hora_registro + una_hora
                comavel=f"sudo tc filter add dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:11"
                print("se ha insertado gratis")
            elif tipo=="pago":
                una_hora = timedelta(hours=5)
                comavel=f"sudo tc filter add dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
                print("se ha insertado pago")
                tiempo_exp = hora_registro + una_hora
            elif tipo=="ticket":
                una_hora = timedelta(hours=5)
                tiempo_exp = hora_registro + una_hora
                print("se ha insertado ticket")
                comavel=f"sudo tc filter add dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
                

            run_iptables_command(comavel)
            consulta = "INSERT INTO exusuarios (mac, ip, tipo, nombre, tiempo_registro, tiempo_expiracion) VALUES (%s, %s, %s, %s, %s, %s)"
            datos = (mac, ip, tipo, nombre, hora_registro, tiempo_exp)
          
            cursor1.execute(consulta, datos)
            borrar = "DELETE FROM registro_conexiones WHERE ip = %s"
            
            cursor1.execute(borrar, (ip,))
            print("error al borrar de conexiones")
            conexion1.commit()
           
         
            
            
    else:
        print("no hay registros")
        time.sleep(0.4)
        fecha_actual = datetime.now()
        cursor1.execute("SELECT * FROM exusuarios")
        result = cursor1.fetchall()
        if result:  # Verificar si hay resultados
            print(result)
            for base in result:
                if fecha_actual > base[6]:
                    mac=base[1]
                    ip=base[2]
                    nombre=base[3]
                    tipo=base[3]
                        
                    if tipo=="gratis":
                      
                        comavel=f"sudo tc filter del dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:11"
                        print("se borro gratis")

                    elif tipo=="pago":
    
                        comavel=f"sudo tc filter del dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
                        print("se borro pago")
                     
                    elif tipo=="ticket":
                        
                        comavel=f"sudo tc filter del dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
                        print("se borro ticket")
                        
                    try:
                        run_iptables_command(comavel)
                        
                    except:
                        print("no existe")
                    
                    borrar_marca=f"sudo {iptables} -t mangle -D PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 1"
                    try:
                        
                        run_iptables_command(borrar_marca)
                    except:
                        print("ya se borro ya")
                
                    print("se acabo el tiempo")
                    
                    poner_segunda=f"sudo {iptables} -t mangle -A PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 2"
                    try:
                        run_iptables_command(poner_segunda)
                        
                    except:
                        print("no existe ya")


                 
                    borrar = "DELETE FROM exusuarios WHERE mac = %s"
                    try:
                        cursor1.execute(borrar, (mac,))
                    except:
                        print("no se pudo borrar de la base de datos")
                    insertar= "INSERT INTO antiguos_usuarios (ip , nombre, mac,fecha ) VALUES (%s, %s,%s,%s)"
                    
                    info=(ip,nombre, mac,fecha_actual)
                    try:
                        cursor1.execute(insertar, info)
                    except:
                        print("no se pudo insertar en antiguos usuarios")
                    conexion1.commit()
                    conexion1.close()
                    
                    
                            

        
        

    # Cerrar la conexión a la base de datos fuera del bucle
    conexion1.close()




