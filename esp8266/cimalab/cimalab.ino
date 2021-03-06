//---------LIBRERIAS CORRESPONDIENTES A OLED i2c----------------------
#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>

//--------------Librerias correspondientes a la conexion wifi-----------------
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
SoftwareSerial softSerial(12, 13); //RX, TX: pin 2 corresponde al D4 que se conecta a TX del DE2120 y pin 16 corresponde al D0 que se conecta al RX del DE2120 

//------------------VARIABLES PARA OLED i2c----------------------
#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 64 // OLED display height, in pixels

#define OLED_RESET     -1 // Reset pin # (or -1 if sharing Arduino reset pin)
#define SCREEN_ADDRESS 0x3C ///< See datasheet for Address; 0x3D for 128x64, 0x3C for 128x32

#define LOGO_HEIGHT   64
#define LOGO_WIDTH    128

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

static const unsigned char PROGMEM image[] = {
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xf8, 0xff, 0xff, 0x00, 0x7f, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0x7f, 0xf0, 0x7f, 0xfe, 0x00, 0x3f, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0x3f, 0xff, 0x3f, 0xb0, 0x7f, 0xc4, 0x00, 0x1f, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xfe, 0x3f, 0xfa, 0x1e, 0x00, 0x3f, 0x80, 0x00, 0x0f, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xe0, 0x3f, 0xc0, 0x1e, 0x00, 0x3f, 0x00, 0x00, 0x0f, 0xff, 0x8f, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xe0, 0x3f, 0x80, 0x0c, 0x00, 0x1c, 0x00, 0x00, 0x0f, 0xfe, 0x0f, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xc0, 0x3f, 0x80, 0x00, 0x00, 0x18, 0x00, 0x00, 0x07, 0xe0, 0x0f, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xc0, 0x3f, 0x00, 0x00, 0x00, 0x18, 0x00, 0x00, 0x07, 0xc0, 0x1f, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x80, 0x0f, 0x80, 0x00, 0x00, 0x18, 0x00, 0x00, 0x03, 0x80, 0x3f, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x80, 0x1f, 0x80, 0x00, 0x00, 0x18, 0x00, 0x00, 0x03, 0x00, 0x3f, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x80, 0x1f, 0x80, 0x00, 0x00, 0x08, 0x00, 0x00, 0x02, 0x00, 0x09, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x80, 0x1f, 0x00, 0x00, 0x00, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x3f, 0x00, 0x00, 0x00, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x3f, 0x00, 0x00, 0x00, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x3f, 0xfc, 0x0e, 0x03, 0x08, 0xff, 0xc0, 0x06, 0x30, 0x03, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x7f, 0x78, 0x04, 0x07, 0x00, 0x78, 0xe0, 0x1c, 0x08, 0x07, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x7f, 0x78, 0x04, 0x07, 0x80, 0x78, 0x70, 0x38, 0x0c, 0x0f, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x7f, 0x78, 0x04, 0x0f, 0x80, 0x78, 0x70, 0x70, 0x04, 0x1f, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x7e, 0x78, 0x04, 0x0b, 0xc0, 0x78, 0x70, 0x70, 0x00, 0x3f, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x7e, 0x78, 0x04, 0x1b, 0xc0, 0x78, 0x60, 0xf0, 0x00, 0x7f, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x7e, 0x78, 0x04, 0x11, 0xc0, 0x78, 0xc0, 0xe0, 0x00, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x7e, 0x78, 0x04, 0x11, 0xe0, 0x7f, 0xf0, 0xe0, 0x00, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x7c, 0x78, 0x04, 0x21, 0xe0, 0x78, 0x78, 0xe0, 0x01, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x38, 0x78, 0x04, 0x20, 0xe0, 0x78, 0x3c, 0xe0, 0x01, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x00, 0x78, 0x04, 0x60, 0xf0, 0x78, 0x3c, 0xf0, 0x03, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x00, 0x38, 0x04, 0x7f, 0xf0, 0x78, 0x3c, 0x70, 0x03, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x00, 0x38, 0x08, 0xc0, 0xf8, 0x78, 0x3c, 0x70, 0x07, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x00, 0x3c, 0x18, 0x80, 0x78, 0x78, 0x3c, 0x38, 0x0f, 0xff, 0xf9, 0xff, 0xff, 
  0xff, 0xfe, 0x00, 0x00, 0x1f, 0xf0, 0x80, 0x7c, 0x78, 0x78, 0x1c, 0x1f, 0xff, 0xf1, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x00, 0x07, 0xc1, 0xc0, 0x7c, 0xff, 0xe0, 0x06, 0x27, 0xff, 0xe1, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x07, 0xff, 0x81, 0xff, 0xff, 
  0xff, 0xff, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x03, 0xfe, 0x01, 0xff, 0xff, 
  0xff, 0xff, 0x80, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xe0, 0x01, 0xff, 0xff, 
  0xff, 0xff, 0x80, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x03, 0xff, 0xff, 
  0xff, 0xff, 0xc0, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 
  0xff, 0xff, 0xc0, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 
  0xff, 0xff, 0xe0, 0x04, 0x40, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0xff, 0xff, 
  0xff, 0xff, 0xf0, 0x3d, 0xc0, 0x7f, 0xfc, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x01, 0xff, 0xff, 
  0xff, 0xff, 0xf8, 0xff, 0xd0, 0xff, 0xfc, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x03, 0xff, 0xff, 
  0xff, 0xff, 0xfe, 0xff, 0xfc, 0xff, 0xfe, 0x00, 0x00, 0x07, 0x00, 0x00, 0x00, 0x07, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xfd, 0xff, 0xfe, 0x00, 0x3f, 0xff, 0x80, 0x00, 0x00, 0x0f, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xfe, 0x00, 0x7f, 0xff, 0xc0, 0x00, 0x00, 0x3f, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x00, 0x7f, 0xff, 0xe0, 0x00, 0x00, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x01, 0x7f, 0xff, 0xfc, 0x00, 0x3f, 0xbf, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x03, 0xff, 0xff, 0xff, 0x03, 0xf8, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x03, 0xff, 0xff, 0xff, 0xc0, 0x03, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x03, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0x3f, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 
  0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff, 0xff
};


//-------------------VARIABLES PARA WIFI--------------------------
int contconexion = 0;
//
//const char *ssid = "RedNoDisponible2.4";
//const char *password = "FAA53462t5FGe259";

//const char *ssid = "FIM_Alumnos";
//const char *password = "ingenieria";

const char *ssid = "iPhone";
const char *password = "78657418";

unsigned long previousMillis = 0;

char host[48];
//String strhost = "192.168.100.21";
//String strhost = "10.30.54.90";
String strhost = "172.20.10.4";
String strurl = "/cimalab/models/esp8266_connection.php";
String chipid = "";
//----------------VARIABLES LABORATORIO--------------------------
int j=0;
const int id_laboratory = 3;
char matricula[BUFFER_LEN];

//-------Funci??n para Enviar Datos a la Base de Datos MySQL--------

String enviardatos(String datos) {

  scanner.stopScan();
  
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

   //Validaciones desactivadas de momento para mejorar la rapidez de la subida de datos a la base de datos
  //Estos tambios son tentativos a cambiarse por una subida mas optima
  Serial.print("Enviando datos a SQL...");
  unsigned long timeout = millis();
  while (client.available() == 0) {
    display.setTextSize(1);     
    printDisplay("Validando...");
    if (millis() - timeout > 5000) {
      Serial.println("Cliente fuera de tiempo!");
      client.stop();
      return linea;
    }
  }

//   Lee todas las lineas que recibe del servidor y las imprime por la terminal serial
  while(client.available()){
    linea = client.readStringUntil('\r');
  }  

Serial.println("Se han enviado los datos con exito.");
  
  if(linea.length() < 5){
    Serial.println("Estas Dentro");
    display.setTextSize(1);     
    printDisplay("Ingresaste");
    delay(1000);
  }else{
    Serial.println("Laboratorio Lleno");
    display.setTextSize(1);     
    printDisplay("Lab. Lleno");
    delay(1000);
  }

  scanner.startScan();
  return linea;
}

void setup() {
// Inicia Serial
  Serial.begin(115200);
  Serial.println("");

//----------------CORRESPONDIENTE AL OLED------------------------------
  
// SSD1306_SWITCHCAPVCC = generate display voltage from 3.3V internally
  if(!display.begin(SSD1306_SWITCHCAPVCC, SCREEN_ADDRESS)) {
    Serial.println(F("SSD1306 allocation failed"));
    for(;;); // Don't proceed, loop forever
  }

  display.clearDisplay();
  display.drawBitmap(0, 0, image, LOGO_WIDTH, LOGO_HEIGHT, WHITE);
  display.display(); // Show the display buffer on the screen
  delay(2000);        // Pause for 2 seconds

  Serial.print("chipId: "); //Identifico el ESP8266
  chipid = String(ESP.getChipId());
  Serial.println(chipid); 
  
//-----COMPRUEBO EL CORRECTO FUNCIONAMIENTO DEL DE2120--------------
  Serial.print("Preparando DE2120 Scanner...");

  if (scanner.begin(softSerial) == false)
  {
    Serial.println("Scanner did not respond. Please check wiring. Did you scan the POR232 barcode? Freezing...");
    while (1)
      ;
  }
  Serial.println("ONLINE!");
  

//------------------END---------------------------
  
//----COMPRUEBO QUE LA CONEXION AL WIFI ES SATISFACTORIA----------------
  Serial.print("Conectandose al WIFI");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED and contconexion <50) { //Cuenta hasta 50 si no se puede conectar lo cancela
    ++contconexion;
    delay(500);
    Serial.print(".");
  }
//  Serial.println(WiFi.localIP());
  Serial.println("ONLINE!");
  printDisplay("ONLINE!");
  

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
  
  if(j++ == 0){
    scanner.startScan();
    Serial.println("PREPARADO!");
    printDisplay("PREPARADO!");
  }
  
  if (scanner.readBarcode(scanBuffer, BUFFER_LEN) && strlen(scanBuffer) == 11)
  {
    Serial.print("Matricula: ");
    for (int i = 0; i < strlen(scanBuffer); i++){
      Serial.print(scanBuffer[i+3]);
      matricula[i] = scanBuffer[(i+3)];
    }
    
    Serial.println();
    enviardatos("chipid=" + chipid + "&id_laboratory=" + id_laboratory + "&matricula=" + matricula);
    
    printMatricula(matricula);
    
    display.clearDisplay();
    display.drawBitmap(0, 0, image, LOGO_WIDTH, LOGO_HEIGHT, WHITE);
    display.display(); // Show the display buffer on the screen
  }

  delay(500);

//Codigo en caso de que quiera mandar los datos cada cierto tiempo para terminos de prueba
//  unsigned long currentMillis = millis();

//  if (currentMillis - previousMillis >= 10000) { //Envia los datos cada 10 segundos
//    previousMillis = currentMillis;
//    enviardatos("chipid=" + chipid + "&id_laboratory=" + id_laboratory + "&matricula=" + matricula);
//  }

  
}

String printMatricula(String matricula){
  display.clearDisplay();
  display.setTextSize(3);             // Normal 1:1 pixel scale
  display.setTextColor(SSD1306_WHITE);        // Draw white text
  display.setCursor(0,20);             // Start at top-left corner
  display.println((matricula));
  display.display();
  delay(1000);
}

void printDisplay(String text){
  
  display.clearDisplay();
  display.setTextSize(2);             // Normal 1:1 pixel scale
  display.setTextColor(SSD1306_WHITE);        // Draw white text
  display.setCursor(0,20);             // Start at top-left corner
  display.print(text);
  display.display();
  delay(1000);
}
