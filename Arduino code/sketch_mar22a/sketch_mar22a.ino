#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <ESP8266WiFi.h>  // Ensure this is correct for your ESP32 or ESP8266

Adafruit_SSD1306 display(128, 64, &Wire, -1);

const char* ssid = "CANALBOX-900A-2G";
const char* password = "yi6j3LeX4cDQ";

void setup() {
  Serial.begin(115200);
 
  // Connect to Wi-Fi
  Serial.printf("Connecting to %s ");
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println(" CONNECTED");

  /***************************************************/

  // Initialize the display
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);  // Initialize the display with I2C address 0x3C
  display.clearDisplay();                     // Clear the display buffer
  display.setTextSize(1);                     // Set text size
  display.setTextColor(SSD1306_WHITE);        // Set text color to white
  display.setCursor(0, 0);                   // Set cursor to the top-left corner
  display.print(F("Wi-Fi Connected!"));      // Using F() macro to store string in flash memory
  display.display();                          // Update the display
}

void loop() {
  // The message is already displayed, no need to repeat it
}
