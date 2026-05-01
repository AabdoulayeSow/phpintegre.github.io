<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>PROJET_01: CODE_SOURCE // SMART_BIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@300;400;500&family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style-code.css">
</head>
<body class="bg-custom-surface text-custom-on-surface font-body selection:bg-custom-primary-container selection:text-custom-on-primary-container cursor-crosshair min-h-screen flex flex-col">
    
    <header class="header-glass fixed top-0 w-full border-b border-custom-neon flex justify-between items-center px-6 py-4 z-50">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-custom-neon">terminal</span>
            <span class="text-xl font-bold text-custom-neon tracking-tighter font-headline uppercase">SMART BIN // SRC</span>
        </div>
        <a href="./arduino.php">
            <button class="text-xs md:text-sm font-medium tracking-widest hover:bg-custom-neon hover:text-custom-surface transition-all duration-0 px-4 py-2 border border-custom-neon active:opacity-80 uppercase font-headline">
                RETOUR AUX PROJETS
            </button>
        </a>
    </header>

    <main class="flex-grow pt-32 pb-16 px-4 md:px-8 max-w-7xl mx-auto w-full">
        <div class="mb-12">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-3 h-3 bg-custom-primary-container animate-pulse shadow-neon-small"></div>
                <span class="font-mono text-xs uppercase tracking-widest text-custom-primary-fixed">Status: Engineering_Access_Granted</span>
            </div>
            <h1 class="font-headline text-4xl md:text-6xl font-bold uppercase tracking-tight neon-glow-text leading-none mb-6">
                PROJET_01: <br />
                <span class="text-custom-primary-container">CODE_SOURCE // SMART_BIN</span>
            </h1>
            <p class="font-mono text-sm max-w-2xl opacity-70 border-l-2 border-custom-primary-container pl-4">
                Firmware architecturé pour ESP32. Gestion de capteurs ultrasoniques, environnementaux (DHT11) et actionneurs cinétiques via servo-moteur. Interface monitoring I2C et serveur Web asynchrone embarqué.
            </p>
        </div>

        <div class="relative group">
            <div class="absolute -top-4 -right-4 w-24 h-24 border-t border-r border-custom-primary-container/30 pointer-events-none"></div>
            <div class="absolute -bottom-4 -left-4 w-24 h-24 border-b border-l border-custom-primary-container/30 pointer-events-none"></div>

            <div class="bg-custom-surface-lowest border border-custom-primary-container shadow-terminal overflow-hidden">
                <div class="bg-custom-surface-high px-4 py-3 flex items-center justify-between border-b border-custom-outline-variant/30">
                    <div class="flex gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="font-mono text-[10px] uppercase tracking-widest opacity-50 hidden md:block">smart_bin_firmware.ino</span>
                        <button class="flex items-center gap-2 bg-custom-primary-container text-custom-on-primary-fixed px-3 py-1 font-mono text-[10px] uppercase font-bold hover:bg-custom-primary-fixed transition-colors duration-200">
                            <span class="material-symbols-outlined text-sm">content_copy</span>
                            COPIER LE CODE
                        </button>
                    </div>
                </div>

                <div class="p-6 md:p-8 font-mono text-sm md:text-base overflow-x-auto code-scrollbar max-h-[618px]">
<pre class="text-[#ceffbe]"><code class="language-cpp">#include &lt;WiFi.h&gt;
#include &lt;DHT.h&gt;
#include &lt;Adafruit_Sensor.h&gt;
#include &lt;ESP32Servo.h&gt;
#include &lt;Wire.h&gt;
#include &lt;LiquidCrystal_I2C.h&gt;

<span class="text-custom-outline">// WIFI</span>
const char *ssid = "Abdoulaye";
const char *password = "00112233";

<span class="text-custom-outline">// DHT11</span>
#define DHTPIN 4
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

<span class="text-custom-outline">// Ultrason</span>
#define TRIG 5
#define ECHO 34

<span class="text-custom-outline">// LED</span>
#define LED_VERTE 26
#define LED_ROUGE 27

<span class="text-custom-outline">// Buzzer</span>
#define BUZZER 25

<span class="text-custom-outline">// Servo</span>
Servo servo;
#define SERVO_PIN 13

<span class="text-custom-outline">// LCD</span>
LiquidCrystal_I2C lcd(0x27, 16, 2);

<span class="text-custom-outline">// Web</span>
WiFiServer server(80);

float distance;

unsigned long lcdTimer = 0;
unsigned long porteTimer = 0;
unsigned long buzzerTimer = 0;

bool porteOuverte = false;
bool buzzerOn = false;

void setup()
{
  Serial.begin(115200);

  pinMode(TRIG, OUTPUT);
  pinMode(ECHO, INPUT);

  pinMode(LED_VERTE, OUTPUT);
  pinMode(LED_ROUGE, OUTPUT);

  pinMode(BUZZER, OUTPUT);

  servo.attach(SERVO_PIN);

  Wire.begin(32, 14);
  lcd.init();
  lcd.backlight();

  dht.begin();

  // WIFI
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED)
  {
    delay(1000);
    Serial.print(".");
  }

  Serial.println("WiFi Connecte");
  Serial.println(WiFi.localIP());

  server.begin();
}

void loop()
{
  // ===== DISTANCE =====

  digitalWrite(TRIG, LOW);
  delayMicroseconds(2);

  digitalWrite(TRIG, HIGH);
  delayMicroseconds(10);

  digitalWrite(TRIG, LOW);

  distance = pulseIn(ECHO, HIGH) * 0.034 / 2;

  // ===== DHT =====

  float h = dht.readHumidity();
  float t = dht.readTemperature();

  // ===== OUVERTURE PORTE =====

  if (distance &lt;= 5 &amp;&amp; !porteOuverte)
  {
    servo.write(90);

    digitalWrite(LED_VERTE, HIGH);
    digitalWrite(LED_ROUGE, LOW);

    porteTimer = millis();
    porteOuverte = true;

    digitalWrite(BUZZER, HIGH);
    buzzerTimer = millis();
    buzzerOn = true;
  }

  // ===== FERMETURE APRES 4s =====

  if (porteOuverte &amp;&amp; millis() - porteTimer &gt; 4000)
  {
    servo.write(0);

    digitalWrite(LED_VERTE, LOW);
    digitalWrite(LED_ROUGE, HIGH);

    porteOuverte = false;
  }

  // ===== ARRET BUZZER =====

  if (buzzerOn &amp;&amp; millis() - buzzerTimer &gt; 1000)
  {
    digitalWrite(BUZZER, LOW);
    buzzerOn = false;
  }

  // ===== LCD ALIGNÉ 16x2 =====

  if (millis() - lcdTimer &gt; 2000)
  {
    lcd.clear();

    // Ligne 1
    lcd.setCursor(0, 0);

    if (porteOuverte)
      lcd.print("P:Ouverte ");
    else
      lcd.print("P:Fermee  ");

    lcd.print("T:");
    lcd.print((int)t);
    lcd.print("C");

    // Ligne 2
    lcd.setCursor(0, 1);

    lcd.print("H:");
    lcd.print((int)h);

    lcd.print(" D:");
    lcd.print((int)distance);
    lcd.print("cm");

    lcdTimer = millis();
  }

  // ===== WEB SERVER =====

  WiFiClient client = server.available();

  if (client)
  {
    String etat;

    if (porteOuverte)
      etat = "Ouverte";
    else
      etat = "Fermee";

    String currentLine = "";

    while (client.connected())
    {
      if (client.available())
      {
        char c = client.read();
        if (c == '\n')
        {
          if (currentLine.length() == 0)
          {
            String response = "HTTP/1.1 200 OK\r\n";
            response += "Content-Type:text/html\r\n";
            response += "Connection:close\r\n\r\n";

            response += "&lt;!DOCTYPE HTML&gt;&lt;html&gt;";
            // ... [Server Response HTML] ...
            client.println(response);
            break;
          }
          else
            currentLine = "";
        }
        else if (c != '\r')
          currentLine += c;
      }
    }
    client.stop();
  }
  delay(200);
}</code></pre>
                </div>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-custom-surface-low p-6 border-l-4 border-custom-secondary">
                <span class="font-mono text-[10px] text-custom-secondary uppercase block mb-2">Build Environment</span>
                <p class="font-headline text-lg font-bold uppercase">VS - code // ESP32_V2</p>
            </div>
            <div class="bg-custom-surface-low p-6 border-l-4 border-custom-secondary">
                <span class="font-mono text-[10px] text-custom-secondary uppercase block mb-2">Core Dependencies</span>
                <p class="font-headline text-lg font-bold uppercase">WIFI.H + Platform.io + SERVO.H</p>
            </div>
            <div class="bg-custom-surface-low p-6 border-l-4 border-custom-secondary">
                <span class="font-mono text-[10px] text-custom-secondary uppercase block mb-2">Memory Usage</span>
                <p class="font-headline text-lg font-bold uppercase">42.4% FLASH // 18.2% RAM</p>
            </div>
        </div>
    </main>

    <footer class="bg-custom-surface text-custom-neon font-mono text-[10px] uppercase tracking-[0.2em] w-full border-t border-custom-surface-container-low flex flex-col md:flex-row justify-between items-center px-8 py-6 mt-auto">
        <div>SYSTEM.SMART_BIN // KINETIC_LOGIC_v1.0.4</div>
        <div class="flex gap-6 mt-4 md:mt-0">
            <a class="font-headline text-xs uppercase text-[#c8c6c5] hover:text-white transition-all underline-offset-4 hover:underline" href="https://www.linkedin.com/in/abdoulaye-sow-58b98b35a">LinkedIn</a>
            <a class="font-headline text-xs uppercase text-[#c8c6c5] hover:text-white transition-all underline-offset-4 hover:underline" href="https://t.me/Abdallahso">Télégramme</a>
            <a class="font-headline text-xs uppercase text-[#c8c6c5] hover:text-white transition-all underline-offset-4 hover:underline" href="https://github.com/dashboard">Github</a>
        </div>
    </footer>
</body>
</html>