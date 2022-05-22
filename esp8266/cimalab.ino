//Librerias correspondientes a la conexion wifi
#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
//Libreria para el SoftSerial
#include "SoftwareSerial.h"
//Libreria de Sensor DE2120
#include "SparkFun_DE2120_Arduino_Library.h" //Click here to get the library: http://librarymanager/All#SparkFun_DE2120
#define BUFFER_LEN 40 //Longitud de la cadena que almacenara el codigo

//----------------VARIABLES PARA EL DE2120-----------------------
DE2120 scanner;//Objeto principal para manipular el DE2120 

char scanBuffer[BUFFER_LEN]; //Cadena que almacena el codigo
SoftwareSerial softSerial(2, 16); //RX, TX: pin 2 corresponde al D4 que se conecta a TX del DE2120 y pin 16 corresponde al D0 que se conecta al RX del DE2120 

//-------------------VARIABLES PARA WIFI--------------------------
int contconexion = 0;

const char *ssid = "RedNoDisponible2.4";
const char *password = "FAA53462t5FGe259";

unsigned long previousMillis = 0;

char host[48];
String strhost = "192.168.100.21";
String strurl = "/cimalab/models/esp8266_connection.php";
String chipid = "";
//----------------VARIABLES LABORATORIO--------------------------
int j=0;
const int id_laboratory = 3;
char matricula[BUFFER_LEN];

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

void setup() {
  
// Inicia Serial
  Serial.begin(115200);
  Serial.println("");

  Serial.print("chipId: "); //Identifico el ESP8266
  chipid = String(ESP.getChipId());
  Serial.println(chipid); 
  
//-----COMPRUEBO EL CORRECTO FUNCIONAMIENTO DEL DE2120--------------
  Serial.println("DE2120 Scanner Example");

  if (scanner.begin(softSerial) == false)
  {
    Serial.println("Scanner did not respond. Please check wiring. Did you scan the POR232 barcode? Freezing...");
    while (1)
      ;
  }
  Serial.println("Scanner online!");

//------------------END---------------------------
  

//----COMPRUEBO QUE LA CONEXION AL WIFI ES SATISFACTORIA----------------
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED and contconexion <50) { //Cuenta hasta 50 si no se puede conectar lo cancela
    ++contconexion;
    delay(500);
    Serial.print(".");
  }
  Serial.println(WiFi.localIP());
//---------------END----------------------------

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
  
  if(j++ == 0)Serial.println("Listo");
  
  if (scanner.readBarcode(scanBuffer, BUFFER_LEN) && strlen(scanBuffer) == 11)
  {
    Serial.print("Code found: ");
    for (int i = 0; i < strlen(scanBuffer); i++){
      Serial.print(scanBuffer[i]);
      matricula[i] = scanBuffer[i];
    }
      
    Serial.println();
    enviardatos("chipid=" + chipid + "&id_laboratory=" + id_laboratory + "&matricula=" + matricula);
  }

  delay(500);

//  unsigned long currentMillis = millis();

//  if (currentMillis - previousMillis >= 10000) { //Envia los datos cada 10 segundos
//    previousMillis = currentMillis;
//    enviardatos("chipid=" + chipid + "&id_laboratory=" + id_laboratory + "&matricula=" + matricula);
//  }

  
}
