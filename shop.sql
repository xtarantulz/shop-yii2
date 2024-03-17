-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Бер 17 2024 р., 03:17
-- Версія сервера: 5.7.33
-- Версія PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблиці `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` text COLLATE utf8_unicode_ci,
  `seo_description` text COLLATE utf8_unicode_ci,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `category`
--

INSERT INTO `category` (`id`, `name`, `image`, `parent_id`, `sort_order`, `slug`, `alias`, `description`, `seo_title`, `seo_keywords`, `seo_description`, `updated_at`, `created_at`) VALUES
(11, 'Чохли для телефонів', '/upload/category/1/apple-iphone-15-pro-max-case-transparent-46988017106312.jpg', NULL, 0, 'chohli-dlya-telefon-v', 'catalog/chohli-dlya-telefon-v', '<p><span style=\"color:var(--tw-prose-bold)\">Чому обрати наші чохли:</span></p>\r\n\r\n<ol>\r\n	<li><span style=\"color:var(--tw-prose-bold)\">Максимальний захист:</span> Наші чохли виготовлені з високоякісних матеріалів, які надійно захищають ваш телефон від ударів, подряпин та інших пошкоджень.</li>\r\n	<li><span style=\"color:var(--tw-prose-bold)\">Стильний дизайн:</span> Ми пропонуємо широкий вибір чохлів з різноманітними дизайнами, які доповнять зовнішній вигляд вашого телефону.</li>\r\n	<li><span style=\"color:var(--tw-prose-bold)\">Підходять для всіх моделей:</span> Ми маємо чохли для різних моделей телефонів, щоб кожен міг знайти відповідний варіант.</li>\r\n</ol>\r\n', '', '', '', 1710633528, 1710631183),
(12, 'Футболки', '/upload/category/1/t-shirts-for-men-white-cotton-shirt-tryzub-dlack-27392717106313.jpg', NULL, 0, 'futbolki', 'catalog/futbolki', '', '', '', '', 1710631412, 1710631332),
(13, 'Чашки', '/upload/category/1/6284f18b410c917106315.jpg', NULL, 0, 'chashki', 'catalog/chashki', '', '', '', '', 1710631512, 1710631512),
(14, 'Іграшки', '/upload/category/1/product-5ecf7ddb5414f17106315.jpg', NULL, 0, 'grashki', 'catalog/grashki', '', '', '', '', 1710631576, 1710631576),
(15, 'Блокноти, Скетчбук, щоденники', NULL, NULL, 0, 'bloknoti-sketchbuk-schodenniki', 'catalog/bloknoti-sketchbuk-schodenniki', '', '', '', '', 1710631605, 1710631605),
(16, 'Дзеркальця з принтами', NULL, NULL, 0, 'dzerkalcya-z-printami', 'catalog/dzerkalcya-z-printami', '', '', '', '', 1710631620, 1710631620),
(17, 'Чоловічі', NULL, 12, 0, 'cholov-ch', 'catalog/futbolki/cholov-ch', '', '', '', '', 1710631665, 1710631665),
(18, 'Жіночі', NULL, 12, 0, 'zh-noch', 'catalog/futbolki/zh-noch', '', '', '', '', 1710631691, 1710631691);

-- --------------------------------------------------------

--
-- Структура таблиці `category_field`
--

CREATE TABLE `category_field` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `depth` int(11) DEFAULT '0',
  `filter` int(11) NOT NULL,
  `list` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `category_field`
--

INSERT INTO `category_field` (`id`, `category_id`, `field_id`, `depth`, `filter`, `list`, `updated_at`, `created_at`) VALUES
(1, 11, 1, 1, 1, 1, 1710633528, 1710631183),
(2, 11, 2, 2, 1, 0, 1710633528, 1710631183),
(3, 12, 1, 0, 0, 0, 1710631412, 1710631332),
(4, 12, 3, 0, 0, 1, 1710631412, 1710631412),
(5, 13, 1, 0, 0, 0, 1710631512, 1710631512),
(6, 14, 1, 0, 0, 0, 1710631576, 1710631576),
(7, 15, 1, 0, 0, 0, 1710631605, 1710631605),
(8, 16, 1, 0, 0, 0, 1710631620, 1710631620),
(9, 17, 1, 0, 0, 0, 1710631665, 1710631665),
(10, 18, 1, 0, 0, 0, 1710631691, 1710631691),
(11, 11, 4, 0, 0, 0, 1710633528, 1710633528),
(12, 11, 6, 0, 0, 0, 1710633528, 1710633528),
(13, 11, 5, 0, 0, 0, 1710633528, 1710633528),
(14, 11, 7, 0, 0, 0, 1710633528, 1710633528),
(15, 11, 9, 0, 0, 0, 1710633528, 1710633528),
(16, 11, 11, 0, 0, 0, 1710633528, 1710633528);

-- --------------------------------------------------------

--
-- Структура таблиці `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `h1_main_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slider_main_page` text COLLATE utf8_unicode_ci NOT NULL,
  `footer_description` text COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `config`
--

INSERT INTO `config` (`id`, `email`, `phone`, `address`, `city`, `region`, `country`, `h1_main_page`, `slider_main_page`, `footer_description`, `updated_at`, `created_at`) VALUES
(1, 'xpaukz@gmail.com', '+38 (063) 27-00-652', 'вул. Ботанічна 9', 'Житомир', 'Житомирська', 'Україна', 'Тестова галерея', '/img/slider/1.jpg, /img/slider/3.jpg', 'Завтра магна ненависть Ліл розминки відповідати його носі Tierra. Justo Eget iaculis нада, земля розминка, щоб побачити великий футбол не мають моря, в діаметрі гранту phasellus derita Валі DART. Теплий шоколад рецепти фінансування мікрохвильового холодильника. Mauris в даний час основні вихідних по всій країні.', 1710628439, 1710628439);

-- --------------------------------------------------------

--
-- Структура таблиці `field`
--

CREATE TABLE `field` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `options` text COLLATE utf8_unicode_ci,
  `prefix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suffix` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `number_after_point` int(11) DEFAULT NULL,
  `expansions` text COLLATE utf8_unicode_ci,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `field`
--

INSERT INTO `field` (`id`, `name`, `type`, `options`, `prefix`, `suffix`, `description`, `number_after_point`, `expansions`, `created_at`, `updated_at`) VALUES
(1, 'Матеріал', 'text', '[]', '', '', 'Матеріал телефона', NULL, NULL, 1710631095, 1710631095),
(2, 'Форм-фактор', 'text', '[]', '', '', 'Форм-фактор чохла', NULL, NULL, 1710631117, 1710631117),
(3, 'Розмір футболки', 'selection', '[\"XS\",\"XL\",\"XXL\",\"XXXL\"]', '', '', 'Розмір футболки', NULL, NULL, 1710631381, 1710631381),
(4, 'Характеристика 1', 'big_text', '[]', '', '', '', NULL, NULL, 1710633398, 1710633398),
(5, 'Характеристика 2', 'selection', '[\"21\",\"323\",\"432532\",\"543\"]', '', '', '', NULL, NULL, 1710633414, 1710633414),
(6, 'Характеристика 3', 'integer', '[]', '$', '', '', NULL, NULL, 1710633432, 1710633432),
(7, 'Характеристика 5', 'float', '[]', '', '', '', 4, NULL, 1710633445, 1710633445),
(8, 'Характеристика 5', 'boolean', '[]', '', '', '', NULL, NULL, 1710633457, 1710633457),
(9, 'Характеристика 6', 'file', '[]', '', '', '', NULL, '[\"txt\",\"pdf\",\"doc\"]', 1710633469, 1710633469),
(10, 'Характеристика 6', 'image', '[]', '', '', '', NULL, '[\"jpg\",\"jpeg\"]', 1710633481, 1710633481),
(11, 'Характеристика 7', 'date', '[]', '', '', '', NULL, NULL, 1710633488, 1710633488);

-- --------------------------------------------------------

--
-- Структура таблиці `map`
--

CREATE TABLE `map` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  `page_id` int(11) DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `map`
--

INSERT INTO `map` (`id`, `name`, `parent_id`, `sort_order`, `page_id`, `controller`, `action`, `slug`, `updated_at`, `created_at`) VALUES
(1, 'Про нас', NULL, 0, 1, NULL, NULL, 'page/pro-nas', 1710630195, 1710630195),
(2, 'Доставка', 4, 1, 2, NULL, NULL, 'page/dostavka', 1710630660, 1710630298),
(3, 'Блог', NULL, 0, NULL, '', '', '/', 1710630413, 1710630413),
(4, 'Новина 1', 3, 0, 1, NULL, NULL, 'page/pro-nas', 1710630712, 1710630564),
(5, 'Новина 2', 3, 0, 4, NULL, NULL, 'page/novina-2', 1710630579, 1710630579),
(6, 'Новина 3', 3, 0, 3, NULL, NULL, 'page/novina-1', 1710630605, 1710630605),
(7, 'Новина 4', 4, 2, NULL, '', '', '/', 1710630705, 1710630617),
(8, 'Новина 5', 2, 0, NULL, '', '', '/', 1710630699, 1710630673);

-- --------------------------------------------------------

--
-- Структура таблиці `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1710628434),
('m130524_201442_init', 1710628437),
('m191124_113911_field_table', 1710628438),
('m191124_113920_category_table', 1710628438),
('m191124_113922_category_field_table', 1710628438),
('m191124_113922_product_table', 1710632877),
('m191124_113930_product_field_table', 1710632877),
('m191124_113932_page_table', 1710628438),
('m191124_113940_map_table', 1710628439),
('m191124_113942_config_table', 1710628439),
('m191124_113944_order_table', 1710628439),
('m191124_113945_order_item_table', 1710628439);

-- --------------------------------------------------------

--
-- Структура таблиці `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` int(11) DEFAULT '0',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `order`
--

INSERT INTO `order` (`id`, `user_id`, `first_name`, `last_name`, `middle_name`, `phone`, `email`, `total`, `status`, `updated_at`, `created_at`) VALUES
(1, 20, 'Lesly', 'Witting', 'Isabel', '632700658', 'testuser8@example.com', '52.00', 0, 1710633602, 1710633602);

-- --------------------------------------------------------

--
-- Структура таблиці `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `count`, `price`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, '52.00', 1710633602, 1710633602);

-- --------------------------------------------------------

--
-- Структура таблиці `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` text COLLATE utf8_unicode_ci,
  `seo_description` text COLLATE utf8_unicode_ci,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `page`
--

INSERT INTO `page` (`id`, `name`, `content`, `seo_title`, `seo_keywords`, `seo_description`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Про нас', '<p><span style=\"color:rgb(122, 145, 150)\">Мы считаем &mdash; результат нашей работы должен зарождать позитивные эмоции в душе каждого клиента! Мы работаем не ради масс, а ради каждой отдельной улыбки) Мы создаем авторский продукт, специализируясь на индивидуальном сувенирном дизайне</span></p>\r\n\r\n<p>це міцна команда творчих людей, які зібралися разом для того, щоб по-новому відкрити світ аксесуарів для мобільних пристроїв.</p>\r\n\r\n<p>З першого дня ми керувалися одним, фундаментальним правилом &ndash; результат нашої роботи повинен зароджувати позитивні емоції в душі кожного клієнта! Ми працюємо не заради мас, а заради кожної окремої посмішки.</p>\r\n\r\n<p>Наші художники створюють справді авторський продукт, і результат їхньої роботи &ndash; це дизайнерські чохли, що дозволяють тонко підкреслити індивідуальний стиль кожного нашого клієнта.</p>\r\n\r\n<p>Команда не приймає шаблони та стереотипи в роботі. Створюючи кожен новий дизайнерський чохол для мобільних пристроїв, ми багато експериментуємо з кольорами та відтінками, формами та фактурами, створюємо прототипи та піддаємо їх всебічній критиці, так ми працюємо доти, доки результат сам не перевершить наші очікування.</p>\r\n', '', '', '', 'page/pro-nas', 1710630180, 1710630180),
(2, 'Доставка', '<p>Ми завжди зацікавлені в тому, щоб кожен наш клієнт отримав своє замовлення якнайшвидше.</p>\r\n\r\n<p>Доставка здійснюється транспортною компанією&nbsp;Укрпошта&nbsp;та&nbsp;Нова пошта. Можливий варіант адресної доставки до дверей у будь-який куточок країни та до складу транспортної компанії у Вашому місті.</p>\r\n\r\n<p>Доставку оплачує отримувач. Вартість доставки можна розрахувати за посиланням&nbsp;<a href=\"https://calc.ukrposhta.ua/domestic-calculator\" style=\"box-sizing: inherit; background-color: transparent; cursor: pointer; transition: color 0.4s ease 0s, background-color 0.4s ease 0s, border-color 0.4s ease 0s, box-shadow 0.4s ease 0s, -webkit-box-shadow 0.4s ease 0s; display: inline-block; text-decoration-line: none;\">https://calc.ukrposhta.ua/domestic-calculator</a>&nbsp;для Укрпошти та&nbsp;<a href=\"https://novaposhta.ua/delivery\" style=\"box-sizing: inherit; background-color: transparent; cursor: pointer; transition: color 0.4s ease 0s, background-color 0.4s ease 0s, border-color 0.4s ease 0s, box-shadow 0.4s ease 0s, -webkit-box-shadow 0.4s ease 0s; display: inline-block; text-decoration-line: none;\">https://novaposhta.ua/delivery</a>&nbsp;для Нової пошти.</p>\r\n\r\n<p>Нашим клієнтам ми пропонуємо кілька найбільш зручних способів оплати замовленого товару:</p>\r\n\r\n<ul>\r\n	<li>Післяплатою при отриманні товару у відділенні Нової Пошти;</li>\r\n	<li>Банківськими картами (MasterCard, VISA) в онлайн режимі.&nbsp;Оперативність обробки платежів досягається завдяки платіжній системі LiqPay;</li>\r\n	<li>Безготівковим розрахунком на наш рахунок;</li>\r\n	<li>Банківською картою або готівкою в нашому офісі при самовивозі.</li>\r\n</ul>\r\n\r\n<p><em>Якщо замовлення відправлене&nbsp;післяплатою, то транспортна компанія стягує додаткову комісію:<br />\r\nУкрпошта - 1% від суми, але не менше ніж 10 грн<br />\r\nНова пошта -&nbsp;близько 2%&nbsp;від загальної вартості вантажу + 25 гривень оформлення</em></p>\r\n\r\n<p>Перевірте чохол при отриманні. Якщо Ви раптом помітили будь-які дефекти на новому чохлі при його отриманні, зверніться до нашого адміністратора, і ми в найкоротші терміни замінимо дефектний чохол.</p>\r\n\r\n<p>Кожен наш чохол&nbsp;ми перевіряємо за кількома параметрами:</p>\r\n\r\n<ul>\r\n	<li>якість і рівномірність нанесеного малюнка,</li>\r\n	<li>точність передачі кольорів;</li>\r\n	<li>відсутність фізичних дефектів на чохлі, різних відколів, подряпин, тріщин.</li>\r\n</ul>\r\n\r\n<p>Ми гарантуємо високу якість&nbsp;створюваних нами дизайнерських чохлів. Завдяки нашій системі візуальної оцінки якості чохлів, ми практично виключаємо брак.</p>\r\n\r\n<p>Порядок повернення товару належної якості</p>\r\n\r\n<p>Повернути товар в магазин (або обміняти його на інший аналогічний) можна протягом 14 днів з дня покупки. Це стосується товарів належної якості, тобто невикористаних і неушкоджених.</p>\r\n\r\n<ol>\r\n	<li>Повернення товару проводиться згідно чинного законодавства України.</li>\r\n	<li>Повернення товару проводиться за рахунок Покупця.</li>\r\n	<li>При поверненні Покупцем товару належної якості, Інтернет-магазин повертає йому сплачену за товар грошову суму за фактом повернення товару за вирахуванням компенсації витрат Інтернет-магазину пов&#39;язаних з доставкою товару Покупцеві.</li>\r\n</ol>\r\n', '', '', '', 'page/dostavka', 1710630284, 1710630284),
(3, 'Новина 1', '<p><strong>&nbsp;Шановні користувачі,</strong></p>\r\n\r\n<p>З радістю повідомляємо вас про важливе оновлення нашої платформи! З постійним прагненням поліпшити ваш користувацький досвід, ми представляємо ряд нових функцій, які роблять нашу платформу ще зручнішою та функціональною.</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><span style=\"color:var(--tw-prose-bold)\">Персоналізовані рекомендації:</span> Тепер наша платформа пропонує вам персоналізовані рекомендації, засновані на ваших уподобаннях та діях. Завдяки цій функції ви зможете швидше знаходити цікавий вам контент.</p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"color:var(--tw-prose-bold)\">Покращений пошук:</span> Ми значно покращили механізм пошуку, щоб ви могли швидше та легше знаходити потрібну інформацію. Тепер пошук став точнішим та ефективнішим.</p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"color:var(--tw-prose-bold)\">Інтуїтивно зрозумілий інтерфейс:</span> Ми оновили дизайн нашої платформи, зробивши його більш інтуїтивно зрозумілим та зручним у використанні. Тепер ви зможете легко орієнтуватися на сайті та швидко знаходити потрібні функції.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Ми сподіваємося, що ці нові функції зроблять ваше спілкування з нашою платформою ще приємнішим та продуктивнішим. Дякуємо за вашу увагу та залишайтеся з нами для подальших оновлень!</p>\r\n\r\n<p>З повагою, Команда [Назва вашої компанії]</p>\r\n', '', '', '', 'page/novina-1', 1710630502, 1710630502),
(4, 'Новина 2', '<p><strong>Шановні клієнти,</strong></p>\r\n\r\n<p>Ми з радістю оголошуємо про відкриття нового відділення нашої компанії з метою поліпшення обслуговування наших клієнтів! Цей крок відкриває нові можливості для зручного доступу до наших послуг та продуктів.</p>\r\n\r\n<p><span style=\"color:var(--tw-prose-bold)\">Де:</span> Нове відділення розташоване за адресою [вкажіть адресу].</p>\r\n\r\n<p><span style=\"color:var(--tw-prose-bold)\">Що вас очікує:</span></p>\r\n\r\n<ul>\r\n	<li>Розширений асортимент продукції та послуг.</li>\r\n	<li>Професійні консультації наших експертів.</li>\r\n	<li>Зручний графік роботи для вашої зручності.</li>\r\n</ul>\r\n\r\n<p><span style=\"color:var(--tw-prose-bold)\">Відкриття:</span> [Вказати дату та час відкриття].</p>\r\n\r\n<p>Ми відчуваємо величезну подяку за вашу підтримку, яка надихає нас на розвиток та поліпшення наших послуг. Запрошуємо вас відвідати наше нове відділення та насолодитися першокласним обслуговуванням.</p>\r\n\r\n<p>З повагою, Команда [Назва вашої компанії]</p>\r\n', '', '', '', 'page/novina-2', 1710630542, 1710630542);

-- --------------------------------------------------------

--
-- Структура таблиці `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8_unicode_ci,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `seo_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seo_keywords` text COLLATE utf8_unicode_ci,
  `seo_description` text COLLATE utf8_unicode_ci,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `images`, `category_id`, `price`, `description`, `seo_title`, `seo_keywords`, `seo_description`, `slug`, `updated_at`, `created_at`) VALUES
(1, 'Тест 1', '/upload/product/1/6284f18b410c917106329.jpg', '/upload/product/images/apple_iphone_15_pro_max_case_transparent_469880.jpg, /upload/product/images/6284f18b410c9.jpg', 11, '52.00', '<p>Тесттавыттп тыпт ытвп тывт пвы тод прдывп дрыдп&nbsp;</p>\r\n', '', '', '', 'test-1', 1710633567, 1710632883),
(2, 'Тест 2', '/upload/product/1/t-shirts-for-men-white-cotton-shirt-tryzub-dlack-27392717106329.jpg', '', 11, '23.00', '<p>ыфапоывпдоывпждывждподывлпы</p>\r\n', '', '', '', 'test-2', 1710632937, 1710632937),
(3, 'Тест 33332 ', '/img/no_image.png', '', 11, '32.00', '<p>авыпывпыв ып орывпл ывфрпдвыд првдыр пдыв пдорывдопы</p>\r\n', '', '', '', 'test-33332', 1710633083, 1710632967),
(4, 'тест 4324423', NULL, '', 11, '323.00', '<p>43232523525</p>\r\n', '', '', '', 'test-4324423', 1710633014, 1710633014),
(5, 'тест 5', NULL, '', 11, '4321.00', '<p>432</p>\r\n', '', '', '', 'test-5', 1710633046, 1710633046),
(6, 'тест 6', '/upload/product/1/6284f18b410c917106330.jpg', '', 11, '3213.00', '<p>321312</p>\r\n', '', '', '', 'test-6', 1710633070, 1710633070),
(7, 'тест 7', NULL, '', 11, '32.00', '<p>3213</p>\r\n', '', '', '', 'test-7', 1710633119, 1710633119),
(8, 'тест 8', NULL, '', 11, '321.00', '<p>3213421</p>\r\n', '', '', '', 'test-8', 1710633136, 1710633136),
(9, 'тест 9', '/upload/product/1/depositphotos_4548401-stock-photo-symbol-of-yin-and-yang17106331.jpg', '', 11, '23.00', '<p>32134214</p>\r\n', '', '', '', 'test-9', 1710633157, 1710633157),
(12, 'тест 10', NULL, '', 11, '323.00', '<p>321321</p>\r\n', '', '', '', 'test-10', 1710633236, 1710633236),
(13, 'тетс 321', NULL, '', 11, '32.00', '<p>321414</p>\r\n', '', '', '', 'tets-321', 1710633265, 1710633265),
(14, 'тетс', '/upload/product/1/uood6qqz4qfhgvhdsrrqumkmamc17106332.jpeg', '', 11, '32.00', '<p>323</p>\r\n', '', '', '', 'tets', 1710633287, 1710633287),
(15, 'аыфваывфап', '/upload/product/1/uood6qqz4qfhgvhdsrrqumkmamc17106333.jpeg', '', 11, '32.00', '<p>32114</p>\r\n', '', '', '', 'ayfvayvfap', 1710633324, 1710633324);

-- --------------------------------------------------------

--
-- Структура таблиці `product_field`
--

CREATE TABLE `product_field` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `product_field`
--

INSERT INTO `product_field` (`id`, `product_id`, `field_id`, `value`, `updated_at`, `created_at`) VALUES
(1, 1, 1, '532452', 1710632883, 1710632883),
(2, 1, 2, '5325', 1710632883, 1710632883),
(3, 2, 1, '421', 1710632938, 1710632938),
(4, 2, 2, '423', 1710632938, 1710632938),
(5, 3, 1, 'к32', 1710632967, 1710632967),
(6, 3, 2, '4324', 1710632967, 1710632967),
(7, 4, 1, '32', 1710633014, 1710633014),
(8, 4, 2, '321', 1710633014, 1710633014),
(9, 5, 1, '432', 1710633046, 1710633046),
(10, 5, 2, '3424', 1710633046, 1710633046),
(11, 6, 1, '321', 1710633070, 1710633070),
(12, 6, 2, '3421', 1710633070, 1710633070),
(13, 7, 1, '32', 1710633119, 1710633119),
(14, 7, 2, '23', 1710633119, 1710633119),
(15, 8, 1, '32', 1710633136, 1710633136),
(16, 8, 2, '32', 1710633136, 1710633136),
(17, 9, 1, '32', 1710633157, 1710633157),
(18, 9, 2, '32', 1710633157, 1710633157),
(19, 12, 1, '32', 1710633236, 1710633236),
(20, 12, 2, '32', 1710633236, 1710633236),
(21, 13, 1, '32', 1710633265, 1710633265),
(22, 13, 2, '32', 1710633265, 1710633265),
(23, 14, 1, '32', 1710633287, 1710633287),
(24, 14, 2, '32', 1710633287, 1710633287),
(25, 15, 1, '32', 1710633324, 1710633324),
(26, 15, 2, '23', 1710633324, 1710633324),
(27, 1, 4, 'fdsgsdgsg s', 1710633567, 1710633567),
(28, 1, 6, '23', 1710633567, 1710633567),
(29, 1, 5, '323', 1710633567, 1710633567),
(30, 1, 7, '21441.0000', 1710633567, 1710633567),
(31, 1, 11, '2024-03-16', 1710633567, 1710633567);

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `middle_name`, `email`, `phone`, `photo`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Адмін', 'Адмінко', 'Адміновіч', 'admin@gmail.com', NULL, NULL, '4235ewvsd432rwsfwd432rw', '$2y$13$Uyc6y1S0H7vDZaWej3is/.aA36J6oWqvFVBScWamBUPRMMhTSpFUK', NULL, 1, 'admin', 1710628437, 1710628437),
(12, 'Aliza', 'Mills', 'Beaulah', 'testuser0@example.com', '632700650', NULL, '0T70wWrkmevv8XrKQVuC3y_0EDQ2dBCn', '$2y$13$WokXNoTRZ1Zo6QeaqQ6kxuR/wNI/F7J3BHP0rYWampTNKnpLRiJJ2', NULL, 1, 'client', 1710629674, 1710629674),
(13, 'Brennon', 'Legros', 'Matt', 'testuser1@example.com', '632700651', NULL, 'khD9V-UT0YOQ5IA6xNRwcteQUvwV03Yv', '$2y$13$6fw8UluOZ9IF7E4WY72zVu.JEgX7Lh46ZfhAgcOwzWp9UzA./DHRW', NULL, 1, 'client', 1710629674, 1710629674),
(14, 'Cristina', 'Kemmer', 'Candelario', 'testuser2@example.com', '632700652', NULL, 'VfxU-q7iui_pyAma3M0nwwCnrJDCBd3Q', '$2y$13$xqAoyhPJvKXFUntREncJcOnGbvFDOsnWvila6RJMbrXZR4/91cu0S', NULL, 1, 'client', 1710629675, 1710629675),
(15, 'Reese', 'Frami', 'Mozell', 'testuser3@example.com', '632700653', NULL, 'xj5WpqL6PFkAHthT4F6oY2gBW3iLXsNn', '$2y$13$byulj/0y/Eisx6KtqmqyYuRgulqaryJFvUu2/SsoWKUJtVFDhm8hC', NULL, 1, 'client', 1710629676, 1710629676),
(16, 'Alphonso', 'Crist', 'Madge', 'testuser4@example.com', '632700654', NULL, 'CrE_tpTn-WdCzTJ6Rwmk1uihRGgAwOnv', '$2y$13$VOgcP/4CUC/XIzLFqqxyRexbQ.ZAZzxbRCCwBGAbY6mxymtgnT8lO', NULL, 1, 'client', 1710629676, 1710629676),
(17, 'Germaine', 'Bayer', 'Boyd', 'testuser5@example.com', '632700655', NULL, 'S9sr50qWfUIc0aF_8HN3R6nrcu2uSVqJ', '$2y$13$k/YJFuj5kbUn3ftdviplLur4.51LV5TmbzUzuhLdIadJpmeFNDknC', NULL, 1, 'client', 1710629677, 1710629677),
(18, 'Micah', 'Wolff', 'Belle', 'testuser6@example.com', '632700656', NULL, 'vx3Ehv9dWBl9kfjRD_aPMvRH253JoqH8', '$2y$13$vOkawqTycXNrnWS1XQuaIudO2byj9h/fdAtrLFGjLQURwBDHc36l2', NULL, 1, 'client', 1710629677, 1710629677),
(19, 'Braden', 'Sawayn', 'Elian', 'testuser7@example.com', '632700657', NULL, 'jOZh6U0gWWDaM-adRfnjXJDgQ4Uo0yUX', '$2y$13$/D6BUj43gNqw.w0Z7TOJRu4emNvUYJDE9XwKza9iPHZlKV/3FNgeO', NULL, 1, 'client', 1710629678, 1710629678),
(20, 'Lesly', 'Witting', 'Isabel', 'testuser8@example.com', '632700658', '/img/no_avatar.png', 'O9M7rfxUHSXtUJC4l076kW8RnAy4GvsI', '$2y$13$q3pV/yHXu94LF4AiDGk37O18gQUrecb/IyfHGRB9VosHjCxKER55G', NULL, 1, 'client', 1710629679, 1710631779),
(21, 'Hudson', 'Johnston', 'Stanton', 'testuser9@example.com', '632700659', NULL, 'WFObxOU8GAvSsmtY5xZtMJ7R36MQJZW8', '$2y$13$KcksHTqCS.xVIAK5G2OtMeoE7tARfr/2gWPssvXhIkZUGdyfP1JAi', NULL, 1, 'client', 1710629679, 1710629679),
(22, 'Hallie', 'Steuber', 'Americo', 'testmanager0@example.com', '732700650', NULL, 'Yknu3pcb_WJF0eLxi7qtJYU2FbKaBn0a', '$2y$13$pNdFgjxyDkSbRIBh0BOM/.cIUntFX8L97PMiFYigcwC1OzmBCn.T.', NULL, 1, 'manager', 1710629777, 1710629777),
(23, 'Davin', 'Hane', 'Dayna', 'testmanager1@example.com', '732700651', NULL, 'eY0R3jl_ovACgg0ExEdlKu1XA5rdnIBf', '$2y$13$Ts5H/FJQ5I.mwmAfQiQ4vOvEXZETX1YuPkxRN7mezt8bQKIONdclG', NULL, 1, 'manager', 1710629777, 1710629777),
(24, 'Alvis', 'Harber', 'Ciara', 'testmanager2@example.com', '732700652', NULL, 'bnw_8DQjX_ROhF73sUjwnRpR1o9eGz_A', '$2y$13$uF4CzofA9AUfugjOH7kTIeOoA3w/scwL5ctaE6u7aQVCdtodyo3.u', NULL, 1, 'manager', 1710629778, 1710629778);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `alias` (`alias`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Індекси таблиці `category_field`
--
ALTER TABLE `category_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Індекси таблиці `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `map`
--
ALTER TABLE `map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Індекси таблиці `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Індекси таблиці `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Індекси таблиці `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Індекси таблиці `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Індекси таблиці `product_field`
--
ALTER TABLE `product_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблиці `category_field`
--
ALTER TABLE `category_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблиці `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `field`
--
ALTER TABLE `field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблиці `map`
--
ALTER TABLE `map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблиці `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблиці `product_field`
--
ALTER TABLE `product_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_category_fk` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `category_field`
--
ALTER TABLE `category_field`
  ADD CONSTRAINT `category_field_category_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_field_field_fk` FOREIGN KEY (`field_id`) REFERENCES `field` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `map`
--
ALTER TABLE `map`
  ADD CONSTRAINT `menu_menu_fk` FOREIGN KEY (`parent_id`) REFERENCES `map` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_page_fk` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_order_fk` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_product_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `product_field`
--
ALTER TABLE `product_field`
  ADD CONSTRAINT `product_field_field_fk` FOREIGN KEY (`field_id`) REFERENCES `field` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_field_product_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
