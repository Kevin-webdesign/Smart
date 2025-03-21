#include <ESP8266WiFi.h>
#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <ESP8266HTTPClient.h>

const char *ssid = "CANALBOX-350A-2G";
const char *password = "VpT4bsxuhs";

WiFiClient client;
SoftwareSerial mySerial(D2, D1);  // RX, TX
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

const int wifiLedPin = D5;
const int scanLedPin = D0;
const int enrollLedPin = D3;
const int buttonPin = D6;  // Button pin to switch modes

void sendCompletionNotification(uint8_t id) {
    HTTPClient http;
    String url = "http://192.168.1.81/smart/get.php?enrolled=" + String(id);
    
    http.begin(client, url);
    int httpCode = http.GET();
    if (httpCode > 0) {
        Serial.println("Notification sent successfully!");
        delay(2000); // Add a small delay before proceeding
    } else {
        Serial.println("Failed to send notification.");
    }
    http.end();
}

uint8_t fetchEnrollmentID() {
    HTTPClient http;
    http.begin(client, "http://192.168.1.81/smart/finger_number.php");
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
    static unsigned long lastEnrollTime = 0;
    if (millis() - lastEnrollTime < 100) return; // Prevent frequent scanning
    lastEnrollTime = millis();

    int p = -1;
    uint8_t id = 0;
    Serial.println("Starting fingerprint enrollment...");
    digitalWrite(enrollLedPin, HIGH);

    // First fingerprint scan
    do {
        checkFingerprintMode();
        Serial.println("Waiting for first finger placement...");
        p = finger.getImage();
        delay(100); // Non-blocking, short delay
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

void scanFingerprint() {
    static unsigned long lastScanTime = 0;
    if (millis() - lastScanTime < 100) return; // Prevent frequent scanning
    lastScanTime = millis();

    int p = -1;
    Serial.println("Waiting for fingerprint...");
    digitalWrite(scanLedPin, HIGH);

    while (p != FINGERPRINT_OK) {
        p = finger.getImage();
        delay(500);  // Short delay to prevent WDT reset
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
        Serial.println(finger.fingerID);
    } else {
        Serial.println("No match found.");
    }

    digitalWrite(scanLedPin, LOW);
}

void checkFingerprintMode() {
    static unsigned long lastActionTime = 0;
    if (millis() - lastActionTime >= 500) { // Prevents too frequent checking
        lastActionTime = millis();
        int x = digitalRead(buttonPin);
        Serial.println(x);
        if (x == 1){
            enrollFingerprint();
        } else {
            scanFingerprint();
        }
    }
}

void setup() {
    Serial.begin(115200);
    delay(10);
    pinMode(wifiLedPin, OUTPUT);
    pinMode(scanLedPin, OUTPUT);
    pinMode(enrollLedPin, OUTPUT);
    pinMode(buttonPin, INPUT_PULLUP);  // Set button pin to input with pull-up resistor

    Serial.print("Connecting to WiFi...");
    unsigned long wifiStartTime = millis();
    while (WiFi.status() != WL_CONNECTED && millis() - wifiStartTime < 10000) {  // Wait for 10 seconds max
        digitalWrite(wifiLedPin, LOW);
        delay(500);
        digitalWrite(wifiLedPin, HIGH);
        delay(500);
    }

    if (WiFi.status() == WL_CONNECTED) {
        digitalWrite(wifiLedPin, HIGH);
        Serial.println("Connected to WiFi");
    } else {
        Serial.println("Failed to connect to WiFi!");
    }

    finger.begin(57600);
    if (!finger.verifyPassword()) {
        Serial.println("Fingerprint sensor not found!");
        while (1) delay(1);
    }
    Serial.println("Fingerprint sensor initialized!");
}

void loop() {
    static unsigned long lastModeCheck = 0;

    if (millis() - lastModeCheck > 2000) {  // Check mode every 2 seconds
        lastModeCheck = millis();
        checkFingerprintMode();
    }

    yield();  // Ensure the watchdog timer is reset
}
