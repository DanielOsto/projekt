# Projekt ogłoszeniowy (wariant A – czyste technologie)

## Opis projektu

Aplikacja ogłoszeniowa napisana w czystym PHP (bez frameworków) z użyciem MySQL, JavaScript i HTML/CSS. Umożliwia użytkownikom dodawanie, przeglądanie, filtrowanie oraz zakup ogłoszeń.
Zawiera również czat do komunikacji między użytkownikami.

## Funkcje

- Rejestracja i logowanie użytkownika
- Dodawanie ogłoszeń (zdjęcie, tytuł, cena, kategoria)
- Przeglądanie i filtrowanie ogłoszeń (kategorie, stan zakupu)
- Szczegóły ogłoszenia
- Atrapa płatności (blik, przelew, karta)
- Czat w czasie rzeczywistym (AJAX)
- Tryb jasny / ciemny (CSS/JS)
- Ukrywanie kupionych ogłoszeń
- Walidacja po stronie serwera i klienta

## Technologie

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 8.2 (bez frameworków)
- **Baza danych**: MySQL
- **Interaktywność**: AJAX (czat, dynamiczne operacje)
- **Środowisko**: XAMPP (Apache + MySQL)

## Struktura katalogów

projekt/
├── index.php # Strona główna / odwołanie do lista.php
├── register.php # Rejestracja użytkownika
├── login.php # Logowanie
├── logout.php # Wylogowanie
├── dodaj.php # Formularz dodawania ogłoszenia
├── ogloszenie.php # Szczegóły ogłoszenia
├── lista.php # Lista ogłoszeń / strona główna
├── czat.php # Interfejs czatu
├── czaty.php # Lista dostępnych czatów
├── wyslij_wiadomosc.php # Wysyłanie wiadomości
├── ajax_czat.php # Obsługa wiadomości czatu AJAX
├── ajax_pobierz.php # Pobieranie wiadomości AJAX
├── finalizuj.php # Finalizacja transakcji
├── platnosc.php # Atrapa płatności
├── db.php # Połączenie z bazą danych
├── header.php # Wspólny nagłówek
├── style.css # Stylowanie aplikacji
└── uploads/.keep # Miejsce na zdjęcia ogłoszeń


## Schemat bazy danych

### Tabela `users`

| Kolumna     | Typ           | Opis                     |
|-------------|----------------|--------------------------|
| id          | int (PK, AI)   | ID użytkownika           |
| username    | varchar(50)    | Nazwa użytkownika        |
| email       | varchar(100)   | E-mail                   |
| password    | varchar(255)   | Hasło (hash)             |
| role        | varchar(20)    | Domyślnie: `user`        |

---

### Tabela `ogloszenia`

| Kolumna     | Typ             | Opis                            |
|-------------|------------------|---------------------------------|
| id          | int (PK, AI)     | ID ogłoszenia                   |
| user_id     | int (FK)         | Autor ogłoszenia                |
| tytul       | varchar(255)     | Tytuł                           |
| tresc       | text             | Opis                            |
| cena        | decimal(10,2)    | Cena                            |
| zdjecie     | varchar(255)     | Ścieżka do zdjęcia              |
| kupione     | tinyint(1)       | Czy kupione (0/1)               |
| kategoria   | varchar(50)      | np. `elektronika`, `motoryzacja`|

---

### Tabela `wiadomosci` (czat)

| Kolumna        | Typ       | Opis                             |
|----------------|-----------|----------------------------------|
| id             | int (PK)  | ID wiadomości                    |
| nadawca_id     | int (FK)  | Użytkownik wysyłający            |
| odbiorca_id    | int (FK)  | Użytkownik odbierający           |
| ogloszenie_id  | int (FK)  | Dotyczące ogłoszenie             |
| tresc          | text      | Treść wiadomości                 |
| czas           | datetime  | Data i godzina wysłania          |

---

### Tabela `payments`

| Kolumna     | Typ         | Opis                       |
|-------------|--------------|----------------------------|
| id          | int (PK, AI) | ID płatności               |
| user_id     | int (FK)     | Kupujący                   |
| ad_id       | int (FK)     | Ogłoszenie                 |
| method      | varchar(50)  | `blik`, `przelew`, `karta` |
| created_at  | timestamp    | Data zakupu                |

---

## Uruchomienie projektu lokalnie

1. Zainstaluj XAMPP i uruchom Apache + MySQL
2. Wypakuj projekt do katalogu `htdocs/`
3. Zaimportuj plik `baza.sql` w phpMyAdmin
4. Otwórz przeglądarkę i przejdź do `http://localhost/pro/index.php`
5. Zarejestruj użytkownika i rozpocznij testowanie

---

## Wymagania projektu

Wariant A – **czyste technologie**  
Brak frameworków PHP, CSS, JS  
Uruchomienie lokalne (XAMPP)  
Dołączona baza danych  
Walidacja danych, logowanie, sesje  
Dokumentacja (`README.md`, `dokumentacja.pdf`)  
AJAX (komunikacja czatu)  
---

## Autor
Daniel Ostojski
