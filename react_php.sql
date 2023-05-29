-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Maj 2023, 21:51
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `react_php`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_blog`
--

CREATE TABLE `react_php_blog` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_blog`
--

INSERT INTO `react_php_blog` (`id`, `userid`, `title`, `image`, `date`) VALUES
(1, 1, 'Najlepsze przepisy na zdrowe smoothie', 'post_image/1/smoothie.jpg', '2023-05-15'),
(2, 1, 'Jak zacząć biegać? Poradnik dla początkujących', 'post_image/1/bieganie.jpg', '2023-05-17'),
(3, 3, 'Porady dotyczące pielęgnacji skóry w okresie zimowym', 'post_image/3/pielegnacja.jpg', '2023-05-19'),
(4, 5, 'Prawda o stosowaniu sterydów', 'post_image/5/image.jpg', '2023-05-18'),
(5, 1, 'Sekrety przygotowania idealnego obiadu', 'post_image/1/obraz_2023-05-21_152309970.png', '2023-05-21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_blog_sections`
--

CREATE TABLE `react_php_blog_sections` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_blog_sections`
--

INSERT INTO `react_php_blog_sections` (`id`, `postid`, `name`, `description`) VALUES
(1, 1, 'Smoothie z bananem i jagodami', 'Przepis na orzeźwiające smoothie z dodatkiem bananów i jagód. Wystarczy zmiksować 2 dojrzałe banany, garść świeżych lub mrożonych jagód, 1 szklankę mleka roślinnego i kilka kostek lodu. Blenduj wszystkie składniki do uzyskania jednolitej konsystencji. Smoothie z bananem i jagodami to pyszne i zdrowe źródło witamin oraz błonnika. Doskonale sprawdzi się jako przekąska lub szybkie śniadanie.'),
(2, 1, 'Smoothie z awokado i szpinakiem', 'Zielone smoothie pełne składników odżywczych z awokado i szpinakiem. Do przygotowania smoothie potrzebujemy 1 dojrzałego awokado, 2 garście świeżego szpinaku, 1 kiwi, 1 banan, 1 szklankę soku pomarańczowego i kilka kostek lodu. Wszystkie składniki blendujemy razem, aż do uzyskania gładkiej konsystencji. Smoothie z awokado i szpinakiem jest bogate w zdrowe tłuszcze, witaminy, minerały oraz błonnik. To doskonała opcja na śniadanie lub po treningu, dająca energię i odżywienie.'),
(3, 2, 'Podstawowe wyposażenie do biegania', 'Przed rozpoczęciem biegania warto zaopatrzyć się w podstawowe wyposażenie. Do niezbędnych elementów należą: dobrze dobrany i wygodny but do biegania, sportowe ubrania, w tym odpowiednią bieliznę i skarpetki, zegarek sportowy z funkcją pomiaru czasu i tętna, a także butelkę na wodę lub pas biegowy z kieszonkami na bidony. Dobrze dobrane wyposażenie gwarantuje komfort i bezpieczeństwo podczas treningów biegowych, a także wpływa na poprawę osiąganych rezultatów.'),
(4, 2, 'Jak ustawić plan treningowy?', 'Plan treningowy jest kluczowy dla efektywnego rozpoczęcia biegania. Przy jego tworzeniu należy uwzględnić indywidualne cele, obecny stan kondycji oraz dostępny czas na treningi. Ważne jest, aby plan był realistyczny i uwzględniał stopniowe zwiększanie intensywności treningów. Plan treningowy powinien obejmować zarówno biegi o różnej intensywności, jak i dni odpoczynku. Warto także uwzględnić różnorodne rodzaje treningów, takie jak biegi długodystansowe, interwałowe czy fartlek. Istotne jest regularne monitorowanie postępów i dostosowywanie planu treningowego w miarę potrzeb.'),
(5, 3, 'Nawilżanie skóry w zimie', 'Pielęgnacja skóry w okresie zimowym jest niezwykle ważna, ponieważ niska temperatura i suche powietrze mogą prowadzić do nadmiernego przesuszenia skóry. Aby zapewnić odpowiednie nawilżenie, należy stosować nawilżające kremy i balsamy, które tworzą ochronną barierę na powierzchni skóry. Ważne jest także unikanie gorących kąpieli oraz stosowanie łagodnych środków myjących. Dodatkowo, dobrze jest pić odpowiednią ilość wody i unikać nadmiernego przebywania w suchych i ogrzewanych pomieszczeniach. Regularne nawilżanie skóry pomaga utrzymać jej zdrowy wygląd i zapobiega przedwczesnemu starzeniu się.'),
(6, 3, 'Ochrona przed mrozem', 'Podczas zimowych dni, szczególnie w mroźne i wietrzne warunki, skóra wymaga dodatkowej ochrony. Należy zadbać o odpowiednie ubranie, które chroni skórę przed zimnem i wiatrem, zwłaszcza na twarzy, rękach i nogach. Warto nosić ciepłe czapki, rękawiczki, szaliki oraz wygodne i ocieplane buty. Dodatkową ochronę można zapewnić stosując kremy z wysokim filtrem UV, które chronią skórę przed szkodliwym promieniowaniem słonecznym nawet w okresie zimowym. Odpowiednia ochrona przed mrozem zapobiega podrażnieniom, wysuszeniu i odmrożeniom skóry.'),
(7, 4, 'Wprowadzenie', 'Cześć wszystkim! Dziś chciałbym poruszyć ważny temat, który od dawna jest dyskutowany w świecie sportu i kulturystyki - sterydy anaboliczne.'),
(8, 4, 'Droga do doskonałości', 'Przez lata dążyłem do osiągnięcia doskonałości sportowej. Poświęcałem mnóstwo czasu na treningi, zdrową dietę i regenerację. Chciałem być najlepszy w tym, co robię.'),
(9, 4, 'Starcie z rzeczywistością', 'Niestety, w pewnym momencie mojej kariery, dałem się ponieść presji i pokusie. Przyznaję, że zdarzyło mi się brać sterydy anaboliczne. To był błąd i żałuję tego do dzisiaj.'),
(10, 4, 'Przestroga dla innych', 'Chciałbym podzielić się z Wami moim doświadczeniem, abyście mogli uczyć się na moich błędach. Steroidy anaboliczne są niebezpieczne i nielegalne. Nie warto narażać swojego zdrowia i reputacji.'),
(11, 4, 'Zmiana drogi', 'Po moim doświadczeniu zdecydowałem się porzucić stosowanie sterydów i skoncentrować się na zdrowym, naturalnym rozwoju. Chcę być przykładem dla innych i promować sport w sposób czysty i etyczny.'),
(12, 4, 'Podsumowanie', 'Drodzy przyjaciele, przyjmowanie sterydów to nie jest właściwa droga do osiągnięcia celów sportowych. Chcę Was zachęcić do podejścia do sportu z pasją, zdrowym stylem życia i szacunkiem dla swojego organizmu. Niech sport będzie inspiracją i przyjemnością, a nie sposobem na skróty. Dziękuję za uwagę.'),
(13, 5, 'Mięsne dania obiadowe ', 'Mięsne dania obiadowe to propozycje dla miłośników smaku i aromatu mięsa. W tej sekcji znajdziesz przepisy na obiady, w których mięso jest głównym składnikiem. Niezależnie od preferencji - czy to drobiowe, wieprzowe czy wołowe - tutaj znajdziesz pomysły na różnorodne dania mięsne, zarówno klasyczne jak i nowoczesne. Od soczystych pieczeni i smakowitych kotletów, przez aromatyczne gulasze i grillowane steki, aż po tradycyjne potrawy mięsne - ta sekcja zaspokoi Twoje apetyty.'),
(14, 5, 'Wegetariańskie obiady', 'Wegetariańskie obiady to doskonałe rozwiązanie dla osób, które nie spożywają mięsa. W tej sekcji znajdziesz przepisy na pyszne dania obiadowe, w których warzywa i roślinne produkty są głównym składnikiem. Od lekkich sałatek i kolorowych curry, przez pożywne kasze i makarony, aż po zapiekanki i potrawy z wykorzystaniem tofu - ta sekcja oferuje bogactwo wegetariańskich inspiracji dla Twojego codziennego jadłospisu.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_comments`
--

CREATE TABLE `react_php_comments` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_comments`
--

INSERT INTO `react_php_comments` (`id`, `userid`, `postid`, `comment`, `date`) VALUES
(1, 3, 1, 'To smoothie z bananem i jagodami brzmi pysznie! Muszę spróbować tego przepisu!', '2023-05-18 11:08:36'),
(2, 2, 1, 'Świetny sposób na zdrowe i smaczne śniadanie. Lubię smoothie z awokado!', '2023-05-21 17:20:24'),
(3, 3, 2, 'Dobrze zorganizowany plan treningowy jest kluczowy dla osiągnięcia postępów w bieganiu.', '2023-05-22 09:10:51'),
(4, 4, 2, 'Ciekawe artykuły na temat biegania. Plan treningowy to podstawa!', '2023-05-20 22:37:04'),
(5, 1, 3, 'Bardzo przydatne porady dotyczące nawilżania skóry w zimie. Muszę zastosować!', '2023-05-19 20:33:35'),
(6, 5, 3, 'Ochrona przed mrozem jest niezwykle ważna dla zdrowej skóry w okresie zimowym.', '2023-05-21 16:45:44'),
(7, 2, 4, 'Bardzo ważny temat, dziękuję Mariuszowi za szczerość i dzielenie się doświadczeniem!', '2023-05-19 17:33:19'),
(8, 3, 4, 'Mariusz, to naprawdę odważne, że dzielisz się swoimi błędami. To pokazuje, że każdy może się poprawić i wybrać właściwą drogę.', '2023-05-21 12:11:19'),
(9, 4, 4, 'Wielki szacunek dla Ciebie, Mariusz! Twoja historia jest inspirująca. Dzięki za przestrogi', '2023-05-20 10:14:10'),
(10, 6, 4, 'Super forma Mariusz!', '2023-05-21 02:40:33'),
(11, 6, 1, 'super', '2023-05-21 03:08:54'),
(12, 5, 5, 'Muszę zastosować! Bo jakbym jadł KFC TO BY NIC NIE DAŁO!!!!', '2023-05-21 03:26:51');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_ingredient`
--

CREATE TABLE `react_php_ingredient` (
  `id` int(11) NOT NULL,
  `mealid` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `weight` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_ingredient`
--

INSERT INTO `react_php_ingredient` (`id`, `mealid`, `name`, `weight`) VALUES
(1, 1, 'Pierś z kurczaka', '300 g'),
(2, 1, 'Marchewki', '200 g'),
(3, 1, 'Brokuły', '150 g'),
(4, 1, 'Cebula', '100 g'),
(5, 1, 'Papryka', '100 g'),
(6, 1, 'Oliwa z oliwek', '2 łyżki'),
(7, 1, 'Przyprawy (sól, pieprz, oregano)', 'do smaku'),
(8, 2, 'Dynia', '1 kg'),
(9, 2, 'Cebula', '1 sztuka'),
(10, 2, 'Czosnek', '2 ząbki'),
(11, 2, 'Olej', '2 łyżki'),
(12, 2, 'Bulion warzywny', '1 litr'),
(13, 2, 'Pestki dyni', '50 g'),
(14, 3, 'Pierś z kurczaka', '450 g'),
(15, 3, 'Sos sojowy', '2 łyżki'),
(16, 3, 'Sok z limonki', '3 łyżeczki'),
(17, 3, 'Imbir', '1 łyżeczka'),
(18, 3, 'Czosnek', '2 ząbki'),
(19, 3, 'Olej sezamowy', '1 łyżka'),
(20, 3, 'Cebula', '1 sztuka'),
(21, 3, 'Papryka', '1 sztuka'),
(22, 3, 'Ryż', '250 g');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_ingredient_premium`
--

CREATE TABLE `react_php_ingredient_premium` (
  `id` int(11) NOT NULL,
  `mealid` int(11) NOT NULL,
  `name` text NOT NULL,
  `weight` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_ingredient_premium`
--

INSERT INTO `react_php_ingredient_premium` (`id`, `mealid`, `name`, `weight`) VALUES
(1, 1, 'Kurczak', '200 g'),
(2, 1, 'Sałata', '50 g'),
(3, 1, 'Pomidory', '100 g'),
(4, 1, 'Ogórki', '50 g'),
(5, 1, 'Awokado', '100 g'),
(6, 1, 'Sos winegret', '10 g'),
(7, 2, 'Tuńczyk', '150 g'),
(8, 2, 'Sałata', '50 g'),
(9, 2, 'Pomidory', '100 g'),
(10, 2, 'Ogórki', '50 g'),
(11, 2, 'Papryka', '50 g'),
(12, 2, 'Sos winegret', '10 g'),
(13, 3, 'Jajka', '3 szt'),
(14, 3, 'Cebula', '50 g'),
(15, 3, 'Papryka', '50 g'),
(16, 3, 'Pomidory', '50 g'),
(17, 3, 'Sól', '5 g'),
(18, 3, 'Pieprz', '2 g');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_liked_recipe`
--

CREATE TABLE `react_php_liked_recipe` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `mealID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_liked_recipe`
--

INSERT INTO `react_php_liked_recipe` (`id`, `userID`, `mealID`) VALUES
(1, 2, 1),
(2, 2, 3),
(6, 1, 3),
(7, 3, 1),
(8, 6, 1),
(9, 6, 2),
(10, 6, 3),
(11, 5, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_recipe`
--

CREATE TABLE `react_php_recipe` (
  `id` int(11) NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `date` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `time` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `people` int(11) NOT NULL,
  `kcal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `mealoption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_recipe`
--

INSERT INTO `react_php_recipe` (`id`, `image`, `title`, `date`, `description`, `time`, `people`, `kcal`, `mealoption`, `userID`) VALUES
(1, 'meal_images/4/kurczakwarzywa.jpg', 'Pierś z kurczaka z pieczonymi warzywami', '2023-05-17', '1. Delikatnie przypraw pierś z kurczaka.\r\n2. Pokrój marchewki, brokuły, cebulę i paprykę na kawałki.\r\n3. Wymieszaj warzywa z oliwą z oliwek oraz przyprawami.\r\n4. Na blasze wyłożonej papierem do pieczenia ułóż pierś z kurczaka i przygotowane warzywa.\r\n5. Piecz w nagrzanym piekarniku przez około 30-35 minut w temperaturze 180°C.\r\n6. Podawaj ciepłe.', '40 min', 2, '370 kcal', 'Redukcja', 4),
(2, 'meal_images/2/zupakrem.png', 'Krem z dyni z prażonymi pestkami', '2023-05-19', '1. Obierz dynię, usuń nasiona i pokrój na kawałki.\r\n2. Pokrój cebulę i czosnek.\r\n3. W garnku rozgrzej olej i podsmaż cebulę oraz czosnek.\r\n4. Dodaj pokrojoną dynię do garnka i smaż przez kilka minut.\r\n5. Zalej warzywa bulionem warzywnym i gotuj na małym ogniu około 20-25 minut, aż dynia zmięknie.\r\n6. Zmiksuj zupę blenderem na gładki krem.\r\n7. W osobnej patelni praż pestki dyni, aż staną się chrupiące.\r\n8. Podawaj kremową zupę z dyni z posypanymi prażonymi pestkami.', '35 min', 4, '220 kcal', 'Redukcja', 2),
(3, 'meal_images/4/kurczak.jpeg', 'Kurczak po wietnamsku z ryżem', '2023-05-20', '1. Pokrój piersi z kurczaka na kawałki.\r\n2. W misce przygotuj marynatę z sosu sojowego, soku z limonki, startego imbiru, czosnku i oleju sezamowego.\r\n3. Włóż kawałki kurczaka do miski z marynatą i odstaw na 30 minut.\r\n4. W rondlu ugotuj ryż wg instrukcji na opakowaniu.\r\n5. Na rozgrzaną patelnię dodaj odcedzone kawałki kurczaka i smaż na złoty kolor.\r\n6. Dodaj posiekaną cebulę i paprykę.\r\n7. Smażaj mieszając przez kilka minut, aż warzywa zmiękną.\r\n8. Podawaj kurczaka po wietnamsku z ugotowanym ryżem.', '40 min', 2, '630 kcal', 'Masa', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_recipe_premium`
--

CREATE TABLE `react_php_recipe_premium` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `title` text NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `time` text NOT NULL,
  `people` int(11) NOT NULL,
  `kcal` text NOT NULL,
  `mealoption` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_recipe_premium`
--

INSERT INTO `react_php_recipe_premium` (`id`, `image`, `title`, `date`, `description`, `time`, `people`, `kcal`, `mealoption`) VALUES
(1, 'images/1.jpg', 'Sałatka z grillowanym kurczakiem i awokado', '2020-12-12', '1. W dużym misce ułóż liście sałaty.\r\n2.Dodaj pokrojone pomidory, ogórki i awokado.\r\n3. Dodaj pokrojony grillowany kurczak.\r\n4. Skrop sałatkę sosem winegret.\r\n5. Delikatnie wymieszaj składniki i podawaj.', '20 min', 1, '432 kcal', 'Redukcja'),
(2, 'images/2.jpg', 'Sałatka z tuńczykiem i warzywami', '2021-06-25', '1. W dużym misce ułóż liście sałaty.\r\n2. Dodaj pokrojone pomidory, ogórki i paprykę.\r\n3. Dodaj kawałki tuńczyka.\r\n4. Skrop sałatkę sosem vinegret.\r\n5. Delikatnie wymieszaj składniki i podawaj.', '15 min', 1, '320 kcal', 'Redukcja'),
(3, 'images/3.jpg', 'Omlet z warzywami', '2023-05-04', '1. Roztrzep jajka w misce. \r\n2. Dodaj pokrojoną cebulę, paprykę i pomidory. \r\n3. Dopraw solą i pieprzem. \r\n4. Na rozgrzaną patelnię wlej masę jajeczną. \r\n5. Smaż na małym ogniu, aż omlet się zetnie. \r\n6. Podawaj na talerzu i udekoruj świeżymi ziołami.', '10 min', 1, '250 kcal', 'Redukcja');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_users`
--

CREATE TABLE `react_php_users` (
  `id` int(11) NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `login` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `premium` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_users`
--

INSERT INTO `react_php_users` (`id`, `email`, `login`, `password`, `premium`) VALUES
(1, 'jan.kowalski@example.com', 'janek123', 'haslo123', 1),
(2, 'anna.nowak@example.com', 'ania89', 'qwerty123', 0),
(3, 'adam.wisniewski@example.com', 'adik96', 'mojehaslo', 0),
(4, 'marta.kowalczyk@example.com', 'martusia_123', 'abcd1234', 1),
(5, 'pudzian@wp.pl', 'MariuszPudzianowski', 'tanioskoryniesprzedam', 1),
(6, 'qwe', 'qwe', 'qwe', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `react_php_user_weight`
--

CREATE TABLE `react_php_user_weight` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `weight` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `react_php_user_weight`
--

INSERT INTO `react_php_user_weight` (`id`, `userid`, `weight`, `date`) VALUES
(1, 1, 75.2, '2023-05-01'),
(2, 1, 74.8, '2023-05-08'),
(3, 1, 70.1, '2023-05-14'),
(4, 2, 62.5, '2023-04-28'),
(5, 2, 61.9, '2023-05-08'),
(6, 2, 65.9, '2023-05-21'),
(7, 3, 82.1, '2023-05-14'),
(8, 3, 81.7, '2023-05-21'),
(9, 4, 68.3, '2023-05-03'),
(10, 4, 67.9, '2023-05-08'),
(11, 1, 90, '2023-05-21'),
(12, 5, 32, '2023-05-21'),
(13, 6, 199, '2023-05-21');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `react_php_blog`
--
ALTER TABLE `react_php_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_blog_sections`
--
ALTER TABLE `react_php_blog_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_comments`
--
ALTER TABLE `react_php_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_ingredient`
--
ALTER TABLE `react_php_ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_ingredient_premium`
--
ALTER TABLE `react_php_ingredient_premium`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_liked_recipe`
--
ALTER TABLE `react_php_liked_recipe`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_recipe`
--
ALTER TABLE `react_php_recipe`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_recipe_premium`
--
ALTER TABLE `react_php_recipe_premium`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_users`
--
ALTER TABLE `react_php_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `react_php_user_weight`
--
ALTER TABLE `react_php_user_weight`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `react_php_blog`
--
ALTER TABLE `react_php_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `react_php_blog_sections`
--
ALTER TABLE `react_php_blog_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `react_php_comments`
--
ALTER TABLE `react_php_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `react_php_ingredient`
--
ALTER TABLE `react_php_ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `react_php_ingredient_premium`
--
ALTER TABLE `react_php_ingredient_premium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `react_php_liked_recipe`
--
ALTER TABLE `react_php_liked_recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `react_php_recipe`
--
ALTER TABLE `react_php_recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `react_php_recipe_premium`
--
ALTER TABLE `react_php_recipe_premium`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `react_php_users`
--
ALTER TABLE `react_php_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `react_php_user_weight`
--
ALTER TABLE `react_php_user_weight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
