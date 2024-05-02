
import subprocess
import mysql.connector
import time
from datetime import datetime, timedelta

iptables="/usr/sbin/iptables"


# Función para ejecutar comandos iptables
def run_iptables_command(command):
    subprocess.run(command, shell=True, check=True)

# Función para desmarcar la dirección MAC en iptables


# Función para ejecutar comandos en el sistema
def run_command(command):
    subprocess.run(command, shell=True)




while True:
    # Conexión a la base de datos
    conexion1 = mysql.connector.connect(host="192.168.80.20", user="root", passwd="123")
    cursor1 = conexion1.cursor()
    programa1=f"sudo tc qdisc add dev enp0s8 root handle 1: htb default 12"
    run_command(programa1)
    cursor1.execute("USE Acceso")
    cursor1.execute("SELECT * FROM registro_conexiones")
    print(datetime.now())
    resultados = cursor1.fetchall()
    
    if resultados:  # Verificar si hay resultados
        for base in resultados:
            ip = base[3]
            nombre=base[2]
            tiempo=base[7]
            
            print(ip, nombre, tiempo)
            total = f"arp -n {ip}"
            
            # Ejecutar comando arp
            aprobado = subprocess.run(total, shell=True, check=True, capture_output=True, text=True)
            salida = aprobado.stdout
            print(salida)
            lineas = salida.splitlines()
            linea = lineas[1]
            linea = linea.split()
            print(linea)
            mac = linea[2]
            tipo=linea[5]
            print(mac)
            inserta="UPDATE registro_conexiones SET mac = %s WHERE ip = %s"
            
            datos=(mac,ip,)
            cursor1.execute(inserta, datos)
            # Cerrar la conexión actual
           
            coma=f"sudo {iptables} -t mangle -A PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 1"
            run_iptables_command(coma)
            print(coma)
         
        
           # Listar y filtrar dispositivos en la red
            

            # programa2=f"sudo tc class add dev enp0s8 proot 1: classid 1:1 htb rate 1mbit ceil 1mbit"
            # run_command(programa2)
            # programa3=f"sudo tc filter add dev enp0s8 protocol ip parent 1:0 prio 1 u32 match ip src {ip} flowid 1:1"
            # run_command(programa3)
          # Restaurar la velocidad de un dispositivo
            if tipo=="gratis":
                fecha_actual = datetime.now()
                una_hora = timedelta(hours=1)
                
            elif tipo=="pago":
                fecha_actual = datetime.now()
                una_hora = timedelta(hours=5)
                
                
                
            fecha_en_una_hora = fecha_actual + una_hora
            print(fecha_en_una_hora, fecha_actual)
            onsulta = "INSERT INTO exusuarios (mac,ip, nombre, tiempo_registro, tiempo_expiracion) VALUES (%s,%s, %s, %s, %s)"
            datos2 = (mac,ip ,nombre, tiempo,fecha_en_una_hora)
            cursor1.execute(onsulta, datos2)
            conexion1.commit()
            conexion1.close()  

        
            conexion2 = mysql.connector.connect(host="192.168.80.20", user="root", passwd="123")
            cursor2 = conexion2.cursor()
            cursor2.execute("USE Acceso")
            borrar = "DELETE FROM registro_conexiones WHERE ip = %s"
            cursor2.execute(borrar, (ip,))
            conexion2.commit()
            conexion2.close()
            

    else:
        print("No hay datos en la tabla de registros.")
        time.sleep(0.4)
        fecha_actual = datetime.now()
        cursor1.execute("SELECT * FROM exusuarios")
        result = cursor1.fetchall()
        if result:  # Verificar si hay resultados
            for base in result:
                print(base[5])
                if fecha_actual > base[5]:
                    mac=base[1]
                    ip=base[2]
                    
                    print(base[5])
                     
                    print("se acabo el tiempo")
                    coma=f"sudo {iptables} -t mangle -A PREROUTING  -m mac --mac-source {mac} -j MARK --set-mark 0"
                    run_iptables_command(coma)
                    # del1=f"sudo tc class del dev eth0 parent 1: classid 1:1"
                    # del2=f"sudo tc filter del dev eth0 protocol ip parent 1:0 prio 1 u32 match ip src {ip}"
            

                    conexion2 = mysql.connector.connect(host="192.168.80.20", user="root", passwd="123")
                    cursor2 = conexion2.cursor()
                    cursor2.execute("USE Acceso")
                    borrar = "DELETE FROM exusuarios WHERE mac = %s"
                    cursor2.execute(borrar, (mac,))
                    conexion2.commit()
                    conexion2.close()
                    
                    
                            
                    
                    
        else:
            print("no hay nada")
        
        

    # Cerrar la conexión a la base de datos fuera del bucle
    conexion1.close()




