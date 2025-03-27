#include <ESP8266WiFi.h>
#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include "HX711.h"
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#define SDA_PIN D3 /* Define the SDA pin here  */
#define SCL_PIN D4 /* Define the SCL Pin here */

LiquidCrystal_I2C lcd(0x27,16,2);  /* set the LCD address to 0x27 for a 16 chars and 2 line display */

 
HX711 scale(D6, D7);

const int maxCount = 12;  // Maximum count to track
int weightBelowThresholdCount = 0;  // Counter for weight < -0.15

float weight;
float calibration_factor = -619525.00; // for me this vlaue works just perfect 419640

int aboveThresholdCount = 0; // Counter to track how many times weight is above 0.500

const char *ssid = "CANALBOX-350A-2G";
const char *password = "VpT4bsxuhs";

WiFiClient client;
SoftwareSerial mySerial(D2, D1);  // RX, TX
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

const int wifiLedPin = D5;
const int scanLedPin = D0;
const int enrollLedPin = D8;

void sendCompletionNotification(uint8_t id) {
    HTTPClient http;
    String url = "http://192.168.1.67/smart/get.php?enrolled=" + String(id);
    
    http.begin(client, url);
    int httpCode = http.GET();
    if (httpCode > 0) {
        Serial.println("Notification sent successfully!");
        delay(2000);
    } else {
        Serial.println("Failed to send notification.");
    }
    http.end();
}

void sendDataa(uint8_t id) {
    HTTPClient http;
    String url = "http://192.168.1.67/smart/lecture_dash/scan.php?scanned=" + String(id);
    
    http.begin(client, url);
    int httpCode = http.GET();
    if (httpCode > 0) {
        Serial.println("Scan sent successfully!");
        delay(2000);
    } else {
        Serial.println("Failed to send notification.");
    }
    http.end();
}

uint8_t fetchEnrollmentID() {
    HTTPClient http;
    http.begin(client, "http://192.168.1.67/smart/finger_number.php");
    int httpCode = http.GET();
    
    if (httpCode > 0) {
        String payload = http.getString();
        Serial.print("Received Enrollment ID: ");
        Serial.println(payload);
        http.end();
        return (uint8_t)payload.toInt();
    }

    http.end();
    return 0;  // Default to scanning if request fails
}

void enrollFingerprint() {
    int p = -1;
    uint8_t id = 0;
    Serial.println("Starting fingerprint enrollment...");
    digitalWrite(enrollLedPin, HIGH);

    // First fingerprint scan
    do {
        Serial.println("Waiting for first finger placement...");
        p = finger.getImage();
        delay(100);
    } while (p != FINGERPRINT_OK);
    
    Serial.println("Image taken. Processing...");
    p = finger.image2Tz(1);
    if (p != FINGERPRINT_OK) {
        Serial.println("Error in processing the first image.");
        digitalWrite(enrollLedPin, LOW);
        return;
    }

    Serial.println("Remove finger and wait...");
    delay(2000);
    
    while (finger.getImage() != FINGERPRINT_NOFINGER) {
        delay(100);
    }

    // Second fingerprint scan
    do {
        Serial.println("Place the same finger again...");
        p = finger.getImage();
        delay(100);
    } while (p != FINGERPRINT_OK);
    
    Serial.println("Image taken. Processing...");
    p = finger.image2Tz(2);
    if (p != FINGERPRINT_OK) {
        Serial.println("Error in processing the second image.");
        digitalWrite(enrollLedPin, LOW);
        return;
    }

    Serial.println("Creating model...");
    p = finger.createModel();
    if (p != FINGERPRINT_OK) {
        Serial.println("Error in creating model.");
        digitalWrite(enrollLedPin, LOW);
        return;
    }

    Serial.println("Fetching ID...");
    id = fetchEnrollmentID(); // Fetch the ID after second fingerprint scan
    if (id == 0) {
        Serial.println("Invalid ID received, aborting enrollment.");
        digitalWrite(enrollLedPin, LOW);
        return;
    }

    Serial.print("Storing fingerprint with ID: ");
    Serial.println(id);
    p = finger.storeModel(id);
    
    if (p == FINGERPRINT_OK) {
        Serial.println("Fingerprint enrolled successfully!");
        sendCompletionNotification(id);
    } else {
        Serial.println("Fingerprint storage failed!");
    }
    
    digitalWrite(enrollLedPin, LOW);
}

void sendweight(int status) {
  if(status == 1) {
     HTTPClient http;
      String url = "http://192.168.1.67/smart/getload.php?load="+ String(status);
      
      http.begin(client, url);
      int httpCode = http.GET();
      if (httpCode > 0) {
          Serial.println("Weight sent successfully!");
          delay(2000); // Small delay to prevent rapid re-sending
      } else {
          Serial.println("Failed to send weight.");
      }
      http.end();
      
  } else {
     HTTPClient http;
      String url = "http://192.168.1.67/smart/getload.php?load="+ String(status);
      
      http.begin(client, url);
      int httpCode = http.GET();
      if (httpCode > 0) {
          Serial.println("Weight sent successfully!");
          delay(2000); // Small delay to prevent rapid re-sending
      } else {
          Serial.println("Failed to send weight.");
      }
      http.end();
    
  }
}


void calculate() {
  scale.set_scale(calibration_factor);  // Adjust to this calibration factor

  weight = scale.get_units(5); 
  Serial.print("Weight: ");
  Serial.print(weight);
  Serial.println(" KG");
  Serial.println();

  if(weight < -0.15) {
    weightBelowThresholdCount++;  // Increment the counter when weight is below -0.15
    if(weightBelowThresholdCount >= 8) {
      sendweight(1);  // Execute sendweight(1) if the weight condition is met 8 or more times
      weightBelowThresholdCount = 0;  // Reset the counter after executing the function
    }
  } else {
    weightBelowThresholdCount = 0;  // Reset the counter if weight is above -0.15
  }

  if (weightBelowThresholdCount >= maxCount) {
    // If max count is reached, execute sendweight(0) based on the condition
    if (weightBelowThresholdCount >= 8) {
      sendweight(1);  // Execute sendweight(1) if the weight condition is met
    } else {
      sendweight(0);  // Execute sendweight(0) if less than 8
    }
    weightBelowThresholdCount = 0;  // Reset the counter after executing
  }
}

void scanFingerprint() {
    int p = -1;
    Serial.println("Waiting for fingerprint...");
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Waiting for fingerprint...");
    digitalWrite(scanLedPin, HIGH);

    while (p != FINGERPRINT_OK) {
        p = finger.getImage();
        delay(500);
    }

    Serial.println("Image taken. Processing...");
    p = finger.image2Tz(1);
    if (p != FINGERPRINT_OK) {
        Serial.println("Error in processing the image.");
        digitalWrite(scanLedPin, LOW);
        return;
    }

    Serial.println("Searching for fingerprint match...");
    p = finger.fingerSearch();
    delay(500);

    if (p == FINGERPRINT_OK) {
        Serial.print("Fingerprint matched with ID: ");
        Serial.println(finger.fingerID); // Use fingerID, not finger.ID
        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("Fingerprint matched with ID:");
        lcd.setCursor(0,1);
        lcd.print(finger.fingerID);
        sendDataa(finger.fingerID);     // Corrected to use finger.fingerID
    } else {
        Serial.println("No match found.");
    }

    digitalWrite(scanLedPin, LOW);
}

void checkFingerprintMode() {
    HTTPClient http;
    http.begin(client, "http://192.168.1.67/smart/finger_mode.php");
    int httpCode = http.GET();
    
    if (httpCode > 0) {
        String payload = http.getString();
        Serial.print("Fingerprint mode status: ");
        Serial.println(payload);
        
        if (payload == "1") {
            enrollFingerprint();
        } else if(payload == "0") {
            scanFingerprint();
        }else{
          calculate();
         }
    } else {
        Serial.println("Failed to connect to server for mode check.");
    }
    http.end();
}

void setup() {
    Serial.begin(115200);
    Wire.begin(SDA_PIN, SCL_PIN);  /* Initialize I2C communication */
    lcd.init();                 /* initialize the lcd  */
    lcd.backlight();
    lcd.clear();
    delay(10);
    pinMode(wifiLedPin, OUTPUT);
    pinMode(scanLedPin, OUTPUT);
    pinMode(enrollLedPin, OUTPUT);
    scale.set_scale();
    scale.tare(); //Reset the scale to 0
    long zero_factor = scale.read_average(); //Get a baseline reading 

    Serial.print("Connecting to WiFi...");
    lcd.setCursor(0,0);
    lcd.print("Connecting to WiFi...");
    WiFi.begin(ssid, password);
    
    while (WiFi.status() != WL_CONNECTED) {
        digitalWrite(wifiLedPin, LOW);
        delay(500);
        digitalWrite(wifiLedPin, HIGH);
        delay(500);
    }

    digitalWrite(wifiLedPin, HIGH);
    Serial.println("Connected to WiFi");
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Connected to WiFi");

    finger.begin(57600);
    if (!finger.verifyPassword()) {
        Serial.println("Fingerprint sensor not found!");
        lcd.setCursor(0,1);
        lcd.print("Fingerprint sensor not found!");
        while (1) delay(1);
    }
    
    Serial.println("Fingerprint sensor initialized!");
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("Fingerprint sensor initialized!");
}

void loop() {
    static unsigned long lastModeCheck = 0;

    if (millis() - lastModeCheck > 2000) {  // Check mode every 5 seconds
        lastModeCheck = millis();
        checkFingerprintMode();
    }
}
