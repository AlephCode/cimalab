#include <ESP8266WiFi.h>
#include <WiFiClient.h> 

//-------------------VARIABLES GLOBALES--------------------------
int contconexion = 0;

//const char *ssid = "INFINITUM5u5m";
//const char *password = "301ce5aabf";


const char *ssid = "RedNoDisponible2.4";
const char *password = "FAA53462t5FGe259";

unsigned long previousMillis = 0;

char host[48];
//String strhost = "192.168.1.252";
String strhost = "192.168.100.21";
String strurl = "/cimalab/models/esp8266_connection.php";
String chipid = "";
//----------------VARIABLES LABORATORIO--------------------------

const int id_laboratory = 3;
const int matricula = 1165438;

//-------Función para Enviar Datos a la Base de Datos MySQL--------

String enviardatos(String datos) {
  String linea = "error";
  WiFiClient client;
  strhost.toCharArray(host, 49);
  if (!client.connect(host, 80)) {
    Serial.println("Fallo de conexion");
    return linea;
  }

  client.print(String("POST ") + strurl + " HTTP/1.1" + "\r\n" + 
               "Host: " + strhost + "\r\n" +
               "Accept: */*" + "*\r\n" +
               "Content-Length: " + datos.length() + "\r\n" +
               "Content-Type: application/x-www-form-urlencoded" + "\r\n" +
               "\r\n" + datos);           
  delay(10);             
  
  Serial.print("Enviando datos a SQL...");
  
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println("Cliente fuera de tiempo!");
      client.stop();
      return linea;
    }
  }
  // Lee todas las lineas que recibe del servidor y las imprime por la terminal serial
  while(client.available()){
    linea = client.readStringUntil('\r');
  }  
  Serial.println(linea);
  return linea;
}

//-------------------------------------------------------------------------

void setup() {

  // Inicia Serial
  Serial.begin(115200);
  Serial.println("");

  Serial.print("chipId: "); 
  chipid = String(ESP.getChipId());
  Serial.println(chipid); 

  // Conexión WIFI
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED and contconexion <50) { //Cuenta hasta 50 si no se puede conectar lo cancela
    ++contconexion;
    delay(500);
    Serial.print(".");
  }
  Serial.println(WiFi.localIP());

  //Comente esto con tentativa de volverse a implementar al configurar una servidor con IP Fija.
//  if (contconexion <50) {
//      //para usar con ip fija
//      IPAddress ip(192,168,2,156); 
//      IPAddress gateway(192,168,2,1); 
//      IPAddress subnet(255,255,255,0); 
//      WiFi.config(ip, gateway, subnet);
//      
//      Serial.println("");
//      Serial.println("WiFi conectado");
//      Serial.println(WiFi.localIP());
//  }
//  else { 
//      Serial.println("");
//      Serial.println("Error de conexion");
//  }
}

//--------------------------LOOP--------------------------------
void loop() {

  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= 10000) { //Envia los datos cada 10 segundos
    previousMillis = currentMillis;
    enviardatos("chipid=" + chipid + "&id_laboratory=" + id_laboratory + "&matricula=" + matricula);
  }

  
}
