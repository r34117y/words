# Words

Skrypty do zabawy ze słowami:
* narzędzia do parsowania leksykonów SJP i OSPS
* generator drzewa TRIE
* generator magicznych kwadratów słownych

## Wymagania
* PHP 7.4

## Polskie znaki

Domyślnie plik OSPS posiada kodowanie `MS-Windows code page 1250`. Linux nie potrafi go rozpoznać, w związku z czym wyświetla tylko informację `Non-ISO extended-ASCII text, with CRLF line terminators`.
Należy zmienić kodowanie pliku poleceniem `iconv -f CP1250 -t UTF-8 <data/wordlists/osps42.txt >data/wordlists/osps42.utf8.txt`.
Możliwe, że trzeba też zmienić znaki końca linii (`dos2unix data/wordlists/osps42.txt`).

## DictParsers

Klasy do parsowania leksykonów dziedziczą po abstrakcyjnej klasie `AbstractDictParser`.
Ścieżki do plików należy zdefiniować w pliku `src/config.php`

### Metody:

* `getFlatWordsArray() : array` - tworzy i zwraca tablicę zawierającą jednowymiarową tablicę
zawierającą słowa z leksykonu (nie gwarantuje unikalności słów)
* `getGroupedWordsArray() : array` - tworzy i zwraca tablicę, której kluczami są formy podstawowe wyrazów, a wartością
 tablica zawierająca wszystkie odmiany
* `getWordsOfLength(int $n): array` - tworzy i zwraca płaską tablicę zawierającą wyrazy o długości `$n`
* `function getWordsEndingWith(string $ending, ?int $maxLength = null) : array` - zwraca
wyrazy kończące się na `$ending` o długości nie większej niż `$maxLength`
* `function getWordsStartingWith(string $ending, ?int $maxLength = null) : array` - zwraca
wyrazy kończące się na `$ending` o długości nie większej niż `$maxLength`

## StringHelper

Klasa z metodami pomocniczymi do operacji na wyrazach.

### Stałe
* `VOWELS` - tablica z  samogłoskami języka polskiego
* `CONSONANTS` - tablica ze spółgłoskami języka polskiego

### Metody

* `public static function startsWith(string $haystack, string $needle) : bool` - sprawdza czy `$haystack`
zaczyna się od `$needle`
* `public static function endsWith(string $haystack, string $needle) : bool` - sprawdza czy `$haystack`
kończy się na `$needle`
* `public static function stringToArray(string $string, bool $trim = true) : array` - zwraca
tablicę, której elementami są litery tworzące `$string`

