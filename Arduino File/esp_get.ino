#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>
#include "DHT.h"

#include <OneWire.h>
#include <DallasTemperature.h>
#define ONE_WIRE_BUS 2
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

#define DHTTYPE DHT11   // DHT 11

// DHT Sensor
uint8_t DHTPin = 14;

// Initialize DHT sensor.
DHT dht(DHTPin, DHTTYPE);

float Temperature;
float Humidity;
float Probe;
int Charge;
int delayTime;
String device = "1";

#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>

#include <ESP8266HTTPClient.h>
#include <WiFiClientSecureBearSSL.h>
// Fingerprint for demo URL, expires on June 2, 2019, needs to be updated well before this date
// const uint8_t fingerprint[20] = {0x5A, 0xCF, 0xFE, 0xF0, 0xF1, 0xA6, 0xF4, 0x5F, 0xD2, 0x11, 0x11, 0xC6, 0x1D, 0x2F, 0x0E, 0xBC, 0x39, 0x8D, 0x50, 0xE0};

ESP8266WiFiMulti WiFiMulti;
String slp, st1, st2, st3, st4;

void setup() {

  pinMode(DHTPin, INPUT);

  dht.begin();
  sensors.begin();

  Serial.begin(115200);
  Serial.println();
  Serial.println();
  Serial.println();

  for (uint8_t t = 4; t > 0; t--) {
    Serial.printf("[SETUP] WAIT %d...\n", t);
    Serial.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("****", "****");
  WiFi.setAutoReconnect(true);
  WiFi.persistent(true);
}

void loop() {
  // wait for WiFi connection
  if ((WiFiMulti.run() == WL_CONNECTED)) {

    std::unique_ptr<BearSSL::WiFiClientSecure>client(new BearSSL::WiFiClientSecure);

    //client->setFingerprint(fingerprint);
    client->setInsecure();

    HTTPClient https;

    Temperature = dht.readTemperature(); // Gets the values of the temperature
    Humidity = dht.readHumidity(); // Gets the values of the humidity

    sensors.requestTemperatures();
    Probe = sensors.getTempCByIndex(0);

    Charge = analogRead(A0);
    Charge = map(Charge, 400, 830, 0, 100);
    if (Charge >= 100) {
      Charge = 100;
    }

    String TempVal, HumVal, ProbVal, getData, Link, ChargeVal;
    TempVal = String(Temperature);   //String to interger conversion
    HumVal = String(Humidity);
    ProbVal = String(Probe);
    ChargeVal = String(Charge);

    //GET Data
    getData = "?temp=" + TempVal + "&hum=" + HumVal + "&probe=" + ProbVal + "&charge=" + ChargeVal + "&device=" + device;  //Note "?" added at front
    Link = "https://yilmazyurdakul.com/projects/esp/espget.php" + getData;

    Serial.print("[HTTPS] begin...\n");
    if (https.begin(*client, Link)) {  // HTTPS

      Serial.print("[HTTPS] GET...\n");
      // start connection and send HTTP header
      int httpCode = https.GET();

      // httpCode will be negative on error
      if (httpCode > 0) {
        // HTTP header has been send and Server response header has been handled
        Serial.printf("[HTTPS] GET... code: %d\n", httpCode);
        Serial.println(Link);
        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = https.getString();

          slp = payload.substring(0, 1);
          st1 = payload.substring(1, 2);
          st2 = payload.substring(2, 3);
          st3 = payload.substring(3, 4);
          st4 = payload.substring(4);
          delayTime = (st4.toInt() * 60000);

          Serial.println(slp);
          Serial.println(st1);
          Serial.println(st2);
          Serial.println(st3);
          Serial.println(st4);

          if (st1 == "1") {
            //Do something...
          } else {
            //
          }

        }
        if (slp == "1") {
          Serial.println("deep sleep");
          ESP.deepSleep(delayTime*1000);
        }
      } else {
        Serial.printf("[HTTPS] GET... failed, error: %s\n", https.errorToString(httpCode).c_str());
      }

      https.end();
    } else {
      Serial.printf("[HTTPS] Unable to connect\n");
    }
  }

  Serial.println("Wait before next round...");
  Serial.println(delayTime);
  delay(delayTime);
}
