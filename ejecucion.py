#!/usr/bin/ python3
import subprocess
import mysql.connector
import time
from datetime import datetime, timedelta

import logging

logger = logging.getLogger(__name__)
logging.basicConfig(filename='example.log', encoding='utf-8', level=logging.DEBUG, format='%(asctime)s - %(name)s - %(levelname)s - %(message)s', datefmt='%Y-%m-%d %H:%M:%S')

ch = logging.StreamHandler()
ch.setLevel(logging.DEBUG)
formatter = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s', datefmt='%Y-%m-%d %H:%M:%S')
ch.setFormatter(formatter)
logger.addHandler(ch)


#LOGS

print("inicio")
iptables="/usr/sbin/iptables"

def run_iptables_command(command):
    subprocess.run(command, shell=True, check=True)


def correr(command):
    subprocess.run(command, shell=True, check=True)
    

    
logger.info('YA SE INICIO EL SISTEMA')

velocidadgratis="1mbit"
velocidadpago="5mbit"

archivo= open("/etc/iptables/limpia.sh")
lineas = archivo.readlines()
print(lineas)
for linea in lineas:
    if linea != "\n":
        texto= "sudo " + linea
        print(texto)
        
        correr(texto)
logger.info('SE BORRO TODO IPTABLES')
archivo.close()
 
correr ("echo 1 | sudo tee /proc/sys/net/ipv4/ip_forward")

try:
    logger.info('se ejecuto EL ARCHIVO DE IPTABLES')
    archivo2= open("/etc/iptables/tablas.sh")
    lineas2 = archivo2.readlines()
    for linea2 in lineas2:

        if linea2 != "\n":
            texto2= "sudo " + linea2
            print(texto2)
            correr(texto2)
        
    correr ("echo 1 | sudo tee /proc/sys/net/ipv4/ip_forward")
    correr ("sudo /sbin/iptables -t nat -A POSTROUTING -s 192.168.70.0/24 -o enp0s3 -j MASQUERADE")
            
except:
        logger.info('NO SE EJECUTO EL ARCHIVO DE IPTABLES')

borrar_todo="sudo tc qdisc delete dev enp0s8 root"

try:
    correr(borrar_todo)
except:
    print("no existe ya")
    logger.info('YA SE BORRO EL TRAFIC CONTROL AL INICIO')


try:
    run="sudo tc qdisc add dev enp0s8 root"
    correr(run)
    logger.info('NO SE PUDO ESTABLECER LOS PARAMETROS  DEL TRAFIC CONTROL AL INICIO')
except:
    print("no se pudo")

run2=f"sudo tc qdisc add dev enp0s8 root handle 1: htb default 11"
correr(run2)

run3=f"sudo tc class add dev enp0s8 parent 1: classid 1:10 htb rate 5mbit ceil 5mbit"
correr(run3)

run4=f"sudo tc class add dev enp0s8 parent 1: classid 1:11 htb rate 1mbit ceil 1mbit"
correr(run4)
conexion1 = mysql.connector.connect(host="192.168.80.20", user="root", passwd="123")
cursor1 = conexion1.cursor()
cursor1.execute("USE Acceso")

cursor1.execute("SELECT * FROM exusuarios")

resulta2 = cursor1.fetchall()
if resulta2:
    for  inicio in resulta2:  
        tipo=inicio[3]
        ip = inicio[2]
        mac=inicio[1]
        
        if tipo=="gratis":

            comavel=f"sudo tc filter add dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:11"
            print("se ha insertado gratis")
        elif tipo=="pago":
            
            comavel=f"sudo tc filter add dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
            print("se ha insertado pago")
            
        elif tipo=="ticket":
            
            
            print("se ha insertado ticket")
            comavel=f"sudo tc filter add dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
            
        run_iptables_command(comavel)
        logger.info('se ha ingresado el paquete de tc')
        coma=f"sudo {iptables} -t mangle -A PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 1"
        run_iptables_command(coma)
        


while True:
  
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
            logger.info('se ha marcado la mac')
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
                

            correr(comavel)
            consulta = "INSERT INTO exusuarios (mac, ip, tipo, nombre, tiempo_registro, tiempo_expiracion) VALUES (%s, %s, %s, %s, %s, %s)"
            datos = (mac, ip, tipo, nombre, hora_registro, tiempo_exp)
            cursor1.execute(consulta, datos)
            logger.info('Se ha insertado un registro dentro de exusuarios')
            borrar = "DELETE FROM registro_conexiones WHERE ip = %s"
            
            cursor1.execute(borrar, (ip,))
            
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
                      
                        comavel=f"sudo tc filter delete dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:11"
                        print("se borro gratis")

                    elif tipo=="pago":
    
                        comavel=f"sudo tc filter delete dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
                        print("se borro pago")
                     
                    elif tipo=="ticket":
                        
                        comavel=f"sudo tc filter delete dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip dst {ip} flowid 1:10"
                        print("se borro ticket")
                        
                    
                    try:
                        run_iptables_command(comavel)
                        logger.info('Se borro la velocidad del tc')
                        
                    except:
                        print("no se pudo borrar")
                        logger.info('No se pudo borrar de trafic control despues de eliminar usuarios')
                        
                        
                    borrar_marca=f"sudo {iptables} -t mangle -D PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 1"
                    
                    try:  
                        run_iptables_command(borrar_marca)
                        logger.info('Se borro la marca')
                    except:
                        print("No se pudo borrar por que ya se elimino")
                        logger.info('No se pudo borrar el check al eliminar usuarios de exusuarios')
               

                    poner_segunda=f"sudo {iptables} -t mangle -A PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 2"
                    try: 
                        run_iptables_command(poner_segunda)
                        logger.info('se puso la segunda marca')
                    except:
                        
                        print("no se pudo poner nada por que ya no esta")
                        logger.info('No se pudo poner el check de no acceso')
                        
                 
                    borrar = "DELETE FROM exusuarios WHERE mac = %s"
                    try:
                        cursor1.execute(borrar, (mac,))
                        logger.info('Se borro el registro')
                    except:
                        print("no se pudo borrar de la base de datos")
                        logger.info('No se pudo borrar d exusuarios')
                    insertar= "INSERT INTO antiguos_usuarios (ip , nombre, mac,fecha ) VALUES (%s, %s,%s,%s)"
                    
                    info=(ip,nombre, mac,fecha_actual)
                    try:
                        cursor1.execute(insertar, info)
                        logger.info('Se inserto en antiguos usuarios')
                    except:
                        print("no se pudo insertar en antiguos usuarios")
                        logger.info('No se pudo insertar en antiguos usuarios')
                    conexion1.commit()
                    conexion1.close()
                    
                    
                            

        
        

    conexion1.close()




