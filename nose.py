from scapy.all import ARP, sniff

def detectar_dispositivo_conectado(pkt):
    if ARP in pkt and pkt[ARP].op == 1: # Si es una solicitud ARP (op = 1)
        print(f"Dispositivo detectado: {pkt[ARP].psrc} - {pkt[ARP].hwsrc}")

# Especifica la interfaz de red en la que deseas escuchar
interfaz = "enp0s8"  # Cambia "eth0" por la interfaz de red que desees monitorear

# Configura el filtro para detectar paquetes ARP en la interfaz especificada
filtro = "arp"
# Define la función de llamada para manejar los paquetes
llamada = detectar_dispositivo_conectado

# Comienza a escuchar la red en la interfaz especificada para detectar dispositivos
sniff(iface=interfaz, filter=filtro, prn=llamada, store=0)