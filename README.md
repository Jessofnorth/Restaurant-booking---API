# Webbtjänst för Johans Kök
av Jessica Ejelöv, jeej2100@student.miun.se
Projekt för kursen Webbutveckling III på Mittuniversitetet. 

## Om webbtjänsten
Denna webbtjänst är slutprojektet i kursen Webbutveckling III på Mittuniversitetet. 
Projektet handlar om att skapa en webbplats för en restaurang där man kan boka bord, se menyn samt kontakta restaurangen. En admin sida där man ska kunna lägga till maträtter på menyn samt hantera menyn och bokningar med ändringar och radera. Dessa två sidor ska konsumera en webbtjänst som är kopplad till en databas där menyer och bokningar sparas.
Det är en del av tre : Klient webbplats, Admin webbplats och webbtjänst som webbplatserna skickar och hämtar data från. 

Demo på klient webbplatsen hittas [här](https://studenter.miun.se/~jeej2100/writeable/johanskok/).

Denna webbtjänst är uppbyggd med PHP och en MYSQL databas. 

## Databasen : installation och uppbyggnad
Ladda hem repot via:
`git clone https://github.com/Webbutvecklings-programmet/projekt_webservice_vt22-Jessofnorth.git`

Ladda sedan upp filerna på din webbserver med stöd för PHP samt tillgång till en databas. Du kommer behöva ändra uppgifterna i databasuppkopplingen i `config.php` för att koppla mot din egen databas. 
Kör sedan installations filen `install.php` för att installera tabellerna nedan samt skapa en användare. Uppgifterna för användaren finns i slutet av `install.php` och du kan byta dessa till det du själv vill ha. 

|Tabell|Kolumn  |
|--|--|
|johans_menu  | **menu_id** (int(11) PRIMARY KEY AUTO_INCREMENT, **name** (varchar(128) NOT NULL, **price** (int(11) NOT NULL, **category** (carchar(32) NOT NULL, **info** (text) NOT NULL |
|johans_bookings  | **booking_id** (int(11) PRIMARY KEY AUTO_INCREMENT, **name** (varchar(128) NOT NULL, **phone** (varchar(32) NOT NULL, **email** (varchar(128) NOT NULL, **date** (date), **count** (int(11)) NOT NULL, **date** (text) NOT NULL |
|johans_users  | **user_id** (int(11) PRIMARY KEY AUTO_INCREMENT, **username** (varchar(128) NOT NULL, **password** (varchar(256) NOT NULL |

## Klasser och metoder
### Login
##### Properties
* $db - MySQLi-anslutning
* $username - Användarnamn
* $password - Lösenord


##### Metoder
* Constructor - Innehåller databaskoppling.
* private createUser (username : string, password: string) : bool - Skapare en ny användare i databasen med hashat lösenord. 
True - Om lagringen i databasen går bra.
* private loginUser (username : string, password: string) : bool - Hashar lösenordet och jämför användarnamnet och lösenordet mot de sparade i databasen. 
True - om uppgifterna stämmer.
* private setUsername (username : string) : bool - Kontrollerar användarnamet så det är en ofarlig sträng och inte är tom.  
* private setPassword (Password : string) : bool - Kontrollerar lösenordet så det är en ofarlig sträng och inte är tom.  
True - om uppgifterna stämmer.
* Destructor - Stänger databaskopplingen.

***

### Menu
##### Properties
* $db - MySQLi-anslutning
* $name - Maträttens namn
* $price - Pris
* $category - Maträttens kategori så som "Förrätt" tex. 
* $info - Maträttens beskrivning
* $id - Maträttens ID i databasen.


##### Metoder
* Constructor - Innehåller databaskoppling.
* private getMenu () : array - Hämtar alla poster från tabellen `johans_menu`. 
* private getMenuById () : array - Hämtar post med specifikt ID från tabellen `johans_menu`. 
* private getMenuById () : array - Hämtar poster med specifikt category från tabellen `johans_menu`. 
* private setDishWithID (id : int, name : string, price : string, info : string) : bool - Kontrollerar att ID är ett nummer. Anropar även överiga setmetoder.
* private setName (name : string) : bool - Kontrollerar namet så det är en ofarlig sträng och inte är tom.  
* private setCategory (category : string) : bool - Kontrollerar kategorin så det är en ofarlig sträng och inte är tom.  
* private setInfo (info : string) : bool - Kontrollerar beskrivningen så det är en ofarlig sträng och inte är tom. 
* private setPrice (price : int) : bool - Kontrollerar priset så det är en ofarlig int och inte är tom. 
* private createDish () : bool - Skickar en SQL fråga mot databasen med maträttens information för lagring. 
* private updateDish () : bool - Skickar en SQL fråga mot databasen med maträttens information för updatering. 
* private deleteDish (id : int) : bool - Skickar en SQL fråga mot databasen med maträttens ID för att radera. 
* Destructor - Stänger databaskopplingen.

***

### Mail
##### Properties
* $db - MySQLi-anslutning
* $name - Avsändarens namn
* $message - Meddelandet
* $email - Epost


##### Metoder
* Constructor - Innehåller databaskoppling.
* private sendMail (name : string, email : string, message : string) : bool - Skickar ett mail till företagets epost. (min epost i dagsläget) 
* private setName (name : string) : bool - Kontrollerar namet så det är en ofarlig sträng och inte är tom.  
* private setEmail (email : string) : bool - Kontrollerar email så det är en ofarlig sträng och inte är tom samt att det är en formaterat som en epostadress.  
* private setMessage (message : string) : bool - Kontrollerar meddelandet så det är en ofarlig sträng och inte är tom. 
* Destructor - Stänger databaskopplingen.

***

### Confirmation
##### Properties
* $db - MySQLi-anslutning
* $name - Bokarens namn
* $date - Datum som önskas bokas
* $email - Epost
* $count - Antalet gäster


##### Metoder
* Constructor - Innehåller databaskoppling.
* private sendMail (name : string, email : string, date : string, count : int) : bool - Skickar ett mail till kundens epost med bekräftelse och datum och antal gäster det bokat för.
* private setName (name : string) : bool - Kontrollerar namet så det är en ofarlig sträng och inte är tom.  
* private setEmail (email : string) : bool - Kontrollerar email så det är en ofarlig sträng och inte är tom samt att det är en formaterat som en epostadress.  
* private setDate (date : string) : bool - Kontrollerar datumet så det är en ofarlig sträng och inte är tom. 
* private setCount (count : int) : bool - Kontrollerar antalet gäster så det är en ofarlig int och inte är tom.
* Destructor - Stänger databaskopplingen.

***

### Guests
##### Properties
* $db - MySQLi-anslutning
* $date - Datum som önskas bokas


##### Metoder
* Constructor - Innehåller databaskoppling.
* private availableSeats (seats : array) : int - Tar antalet bokade platser som metoden countGuests fått fram och sparar antalet i en int och returnerar.   
* private setDate (date : string) : bool - Kontrollerar datumet så det är en ofarlig sträng och inte är tom. 
* Destructor - Stänger databaskopplingen.

***

### Booking
##### Properties
* $db - MySQLi-anslutning
* $name - Bokarens namn
* $phone - Bokarens telefonnummer
* $date - Datum som önskas bokas
* $email - Epost
* $count - Antalet gäster
* $message - Meddelande från bokaren
* $id - Bokningens ID i databasen

##### Metoder
* Constructor - Innehåller databaskoppling.
* private getBooking () : array - hämtar alla bokningar från databasen.
* private getBookingById (id : int) : array - hämtar bokning med specifikt ID från databasen .
* private getBookingFromDate (date : string) : array - hämtar alla bokningar från ett specifikt datum och frammåt från databasen.
* private setBookingWithID (id : int, name : string, phone : string, email : string, date : string, message : string, count : int) : bool - Setmetod för ID som även kallat resterande setmetoder.   
* private setName (name : string) : bool - Kontrollerar namet så det är en ofarlig sträng och inte är tom.  
* private setEmail (email : string) : bool - Kontrollerar email så det är en ofarlig sträng och inte är tom samt att det är en formaterat som en epostadress.  
* private setPhone (phone : string) : bool - Kontrollerar telefonnummret så det är en ofarlig sträng och inte är tom.
* private setMessage (message : string) : bool - Kontrollerar meddelandet så det är en ofarlig sträng och inte är tom. 
* private setDate (date : string) : bool - Kontrollerar datumet så det är en ofarlig sträng och inte är tom. 
* private setCount (count : int) : bool - Kontrollerar antalet så det är en ofarlig int och inte är tom. 
* private createBooking () : bool - Skickar en SQL fråga mot databasen med bokningens information för lagring. 
* private updateBooking () : bool - Skickar en SQL fråga mot databasen med bokningens information för updatering. 
* private deleteBooking (id : int) : bool - Skickar en SQL fråga mot databasen med bokningens ID för att radera. 
* Destructor - Stänger databaskopplingen.

## Användning
Nedan finns beskrivet hur man nå APIet på olika vis.

###  menu.php
|Metod  |Endpoint     |Beskrivning                                                                           |
|-------|-------------|--------------------------------------------------------------------------------------|
|GET    |/menu.php     |Hämtar alla tillgängliga maträtter.                                                      |
|GET    |/menu.php?id= |Hämtar en specifik maträtt med angivet ID.                                               |
|GET    |/menu.php?category= |Hämtar alla maträtter med specifik kategori.                                               |
|POST   |/menu.php     |Lagrar en ny maträtt. Kräver att ett maträtt-objekt skickas med.                            |
|PUT    |/menu.php?id= |Uppdaterar en existerande maträtt med angivet ID. Kräver att ett maträtt-objekt skickas med.|
|DELETE |/menu.php?id= |Raderar en maträtt med angivet ID.                                                       |

Ett maträtt-objekt returneras/skickas som JSON med följande struktur:
```
{
   name: 'Pasta',
   price: 129,
   category: 'main',
   info: 'Penne pasta med tomatsås och ost.'
}
```

***

###  mail.php
|Metod  |Endpoint     |Beskrivning                                                                           |
|-------|-------------|--------------------------------------------------------------------------------------|
|POST   |/mail.php     |Skickar epost till företagets epost. Kräver att ett mail-object skickas med. ENDAST POST TILLÅTET!             |

Ett mail-objekt returneras/skickas som JSON med följande struktur:
```
{
   name: 'Jessica',
   email: 'jeej2100@student.miun.se',
   message: 'Här skriver man ett meddelande'
}
```

***

###  confirmation.php
|Metod  |Endpoint     |Beskrivning                                                                           |
|-------|-------------|--------------------------------------------------------------------------------------|
|POST   |/confirmation.php     |Skickar epost till kundens epost med bokningsbekräftelse. Kräver att ett confirmation-object skickas med. ENDAST POST TILLÅTET!             |

Ett confirmation-objekt returneras/skickas som JSON med följande struktur:
```
{
   name: 'Jessica',
   email: 'jeej2100@student.miun.se',
   date: '2022-06-04',
   count: 4
}
```

***

###  login.php
|Metod  |Endpoint     |Beskrivning                                                                           |
|-------|-------------|--------------------------------------------------------------------------------------|
|POST   |/login.php     |Kontrollerar login uppgifter mot databasen. Kräver att ett login-object skickas med. ENDAST POST TILLÅTET!             |

Ett login-objekt returneras/skickas som JSON med följande struktur:
```
{
   username: 'admin',
   password: 'password123'
}
```

***

###  guests.php
|Metod  |Endpoint     |Beskrivning                                                                           |
|-------|-------------|--------------------------------------------------------------------------------------|
|GET   |/guests.php?date=    |Kontrollerar antalet redan bokade gäster på ett angivet datum. ENDAST GET TILLÅTET!             |

Ett guests-objekt returneras/skickas som JSON med följande struktur:
```
{
   date: '2022-06-04',
}
```

***

###  booking.php
|Metod  |Endpoint     |Beskrivning                                                                           |
|-------|-------------|--------------------------------------------------------------------------------------|
|GET    |/booking.php     |Hämtar alla tillgängliga bokningar.                                                      |
|GET    |/booking.php?id= |Hämtar en specifik bokning med angivet ID.                                               |
|GET    |/booking.php?date= |Hämtar alla bokningar från ett specifikt datum.                                              |
|POST   |/booking.php     |Lagrar en ny bokning. Kräver att ett bokning-objekt skickas med.                            |
|PUT    |/booking.php?id=|Uppdaterar en existerande bokning med angivet ID. Kräver att ett bokning-objekt skickas med.|
|DELETE |/booking.php?id= |Raderar en bokning med angivet ID.                                                       |

Ett boknings-objekt returneras/skickas som JSON med följande struktur:
```
{
   name: 'Person Persson',
   phone: '0701234567',
   email: 'hej@email.com',
   date: '2022-06-04',
   count: 6,
   message: 'Här skriver vi allergier.'
}
```
