-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 29 2018 г., 11:46
-- Версия сервера: 5.7.22-0ubuntu18.04.1
-- Версия PHP: 7.2.4-1+ubuntu18.04.1+deb.sury.org+1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kazppp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `super_user` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `active`, `super_user`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Aidos', 'aidosgd@gmail.com', '$2y$10$mpWvRGLaPF5GVvCkau7TPeqYh97LalmXeqQHe5.5a2TELNX1e2Cbi', 1, 1, NULL, NULL, '2018-10-29 05:02:33', '2018-10-29 05:02:33');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `handler` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` tinyint(1) NOT NULL DEFAULT '0',
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_lft` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `_rgt` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `owner`, `url`, `handler`, `target`, `name`, `slug`, `_lft`, `_rgt`, `parent_id`, `created_at`, `updated_at`) VALUES
(2, 'news', NULL, NULL, 0, '{\"ru\":\"\\u041d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0438\",\"en\":\"News\"}', 'novosti', 1, 2, NULL, '2018-10-29 11:16:04', '2018-10-29 11:16:04');

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `media`
--

CREATE TABLE `media` (
  `id` int(10) UNSIGNED NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageable_id` int(10) UNSIGNED NOT NULL,
  `main_image` tinyint(1) DEFAULT NULL,
  `client_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conversions` json DEFAULT NULL,
  `order` int(10) UNSIGNED DEFAULT NULL,
  `size` bigint(20) UNSIGNED DEFAULT NULL,
  `mime` varchar(127) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` json NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_display` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_11_20_165143_create_admins_table', 1),
(2, '2017_11_22_142714_create_permission_groups_table', 1),
(3, '2017_11_22_145500_create_permissions_table', 1),
(4, '2017_11_22_152739_create_roles_table', 1),
(5, '2017_11_22_164941_create_role_permissions_table', 1),
(6, '2017_11_23_154003_create_role_admins_table', 1),
(7, '2018_03_20_085355_create_categories_table', 1),
(8, '2018_03_27_122134_create_news_table', 1),
(9, '2018_03_28_111334_add_slug_to_news_table', 1),
(10, '2018_06_04_211436_create_media_table', 1),
(11, '2018_06_05_061001_create_menus_table', 1),
(12, '2018_06_05_074343_create_settings_table', 1),
(13, '2018_06_05_081108_add_seo_fields_to_news_table', 1),
(14, '2018_06_05_092528_change_slug_to_news_table', 1),
(15, '2018_06_05_111010_create_pages_table', 1),
(16, '2018_08_04_105233_create_contacts_table', 1),
(17, '2018_08_19_044630_modify_media_table', 1),
(18, '2018_08_25_150714_create_uploads_table', 1),
(19, '2018_09_23_123924_add_indexes_to_uploads_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` json NOT NULL,
  `short_content` json NOT NULL,
  `long_content` json NOT NULL,
  `meta_description` json DEFAULT NULL,
  `meta_keywords` json DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `site_display` tinyint(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `category_id`, `title`, `short_content`, `long_content`, `meta_description`, `meta_keywords`, `is_pinned`, `is_main`, `site_display`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, '{\"en\": null, \"ru\": \"Проекты ГЧП\"}', '{\"en\": null, \"ru\": \"Как решить проблемы казахстанских автовокзалов Эксперт по ГЧП Гани Жилисбаев обозначил основные проблемы и способы решения инфраструктуры автобусных станций. Неудачная программа приватизации или недобросовестные предприниматели? Как всем нам известно, многие ...\"}', '{\"en\": null, \"ru\": \"<ul>\\r\\n\\t<li><b>Как решить проблемы казахстанских автовокзалов</b></li>\\r\\n</ul>\\r\\n\\r\\n<p>Эксперт по ГЧП Гани Жилисбаев обозначил основные проблемы и способы решения инфраструктуры автобусных станций.</p>\\r\\n\\r\\n<p>Неудачная программа приватизации или недобросовестные предприниматели? Как всем нам известно, многие городские автовокзалы были приватизированы во&nbsp;время первой и&nbsp;второй волны приватизации. На&nbsp;данный момент около 80% всей инфраструктуры автовокзалов находятся в&nbsp;частных руках. Однако было&nbsp;ли оно целесообразным и&nbsp;выгодным? Конечно, мы&nbsp;увидим &laquo;фиаско&raquo; или &laquo;фурор&raquo; программы приватизации уже в&nbsp;ближайшие годы. Но&nbsp;первые итоги мы&nbsp;увидели 18&nbsp;января текущего года, возгорание автобуса, унесший жизнь 52&nbsp;человек в&nbsp;Актобе.</p>\\r\\n\\r\\n<p><b>Источник</b><b>:</b>&nbsp;<a href=\\\"https://kapital.kz/business/69854/biznesmen-vlozhit-200-mln-tenge-v-shkolnye-stadiony.html\\\">kapital.kz</a></p>\\r\\n\\r\\n<p><a href=\\\"https://kapital.kz/gosudarstvo/70847/kak-reshit-problemy-kazahstanskih-avtovokzalov.html\\\">https</a><a href=\\\"https://kapital.kz/gosudarstvo/70847/kak-reshit-problemy-kazahstanskih-avtovokzalov.html\\\">://</a><a href=\\\"https://kapital.kz/gosudarstvo/70847/kak-reshit-problemy-kazahstanskih-avtovokzalov.html\\\">kapital.kz/gosudarstvo/70847/kak-reshit-problemy-kazahstanskih-avtovokzalov.html</a></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><b>Бизнесмен вложит 200&nbsp;</b><b>млн</b><b>&nbsp;тенге в&nbsp;школьные стадионы</b></li>\\r\\n</ul>\\r\\n\\r\\n<p>Алматинский бизнесмен Акылбек Аккайыр построит современные стадионы при двух школах&nbsp;&mdash;№&thinsp;95&nbsp;и&nbsp; №&thinsp;40&nbsp;в Алмалинском и&nbsp;Бостандыкском районах. Общая сумма инвестиций превышает 200&nbsp;млн тенге. Об&nbsp;этом&nbsp;<a href=\\\"https://kapital.kz/\\\">центру деловой информации&nbsp;</a><a href=\\\"https://kapital.kz/\\\">Kapital.kz</a>&nbsp;сообщили в&nbsp;пресс-службе Палаты<i>&nbsp;</i>предпринимателей Алматы</p>\\r\\n\\r\\n<p><b>Источник:</b>&nbsp;<a href=\\\"https://kapital.kz/business/69854/biznesmen-vlozhit-200-mln-tenge-v-shkolnye-stadiony.html\\\">kapital.kz</a></p>\\r\\n\\r\\n<p><a href=\\\"https://kapital.kz/business/69854/biznesmen-vlozhit-200-mln-tenge-v-shkolnye-stadiony.html\\\">https://kapital.kz/business/69854/biznesmen-vlozhit-200-mln-tenge-v-shkolnye-stadiony.html</a></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><b>Тарифы по&nbsp;договорам ГЧП должны быть постоянными</b><br />\\r\\n\\tПо мнению Бакытжана Сагинтаева, часто меняющиеся нормативы могут привести к банкротству предпринимателей</li>\\r\\n</ul>\\r\\n\\r\\n<p><b>Источник:&nbsp;</b><a href=\\\"https://kapital.kz/business/69854/biznesmen-vlozhit-200-mln-tenge-v-shkolnye-stadiony.html\\\">kapital.kz</a></p>\\r\\n\\r\\n<p><a href=\\\"https://kapital.kz/economic/68216/tarify-po-dogovoram-gchp-dolzhny-byt-postoyannymi.html\\\">https://kapital.kz/economic/68216/tarify-po-dogovoram-gchp-dolzhny-byt-postoyannymi.html</a></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><b>Как бизнесмены предлагают увеличить число общежитий</b></li>\\r\\n</ul>\\r\\n\\r\\n<p>Одно из предложений &ndash; перепрофилировать недостроенные объекты</p>\\r\\n\\r\\n<p><b>Источник:&nbsp;</b><a href=\\\"https://kapital.kz/business/69854/biznesmen-vlozhit-200-mln-tenge-v-shkolnye-stadiony.html\\\">kapital.kz</a></p>\\r\\n\\r\\n<p><a href=\\\"https://kapital.kz/business/68145/kak-biznesmeny-predlagayut-uvelichit-chislo-obcshezhitij.html\\\">https://kapital.kz/business/68145/kak-biznesmeny-predlagayut-uvelichit-chislo-obcshezhitij.html</a></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><b>В&nbsp;2018&nbsp;году можно ожидать роста активности в&nbsp;сфере ГЧП</b></li>\\r\\n</ul>\\r\\n\\r\\n<p>Ускорятся процессы рассмотрения, утверждения и реализации проектов</p>\\r\\n\\r\\n<p><b>Источник:&nbsp;</b><a href=\\\"https://kapital.kz/business/69854/biznesmen-vlozhit-200-mln-tenge-v-shkolnye-stadiony.html\\\">kapital.kz</a></p>\\r\\n\\r\\n<p><a href=\\\"https://kapital.kz/economic/65755/v-2018-godu-mozhno-ozhidat-rosta-aktivnosti-v-sfere-gchp.html\\\">https://kapital.kz/economic/65755/v-2018-godu-mozhno-ozhidat-rosta-aktivnosti-v-sfere-gchp.html</a></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><b>ГЧП добавят стабильности Правительство намерено сделать институт ГЧП более привлекательным и стабильным для бизнеса.</b></li>\\r\\n</ul>\\r\\n\\r\\n<p>Правительство намерено сделать институт ГЧП более привлекательным и стабильным для бизнеса.</p>\\r\\n\\r\\n<p><b>Источник:&nbsp;</b><a href=\\\"https://abctv.kz/ru/news/gchp-dobavyat-stabilnosti\\\">abctv.kz</a></p>\\r\\n\\r\\n<p>Автор:&nbsp; Ирина Севостьянова<br />\\r\\n<a href=\\\"https://abctv.kz/ru/news/gchp-dobavyat-stabilnosti\\\">https://abctv.kz/ru/news/gchp-dobavyat-stabilnosti</a></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li><b>Изменить комплексный план приватизации для реализации социально-значимых объектов через ГЧП предлагают в РК</b></li>\\r\\n</ul>\\r\\n\\r\\n<p><b>Источник:&nbsp;</b><b><a href=\\\"http://www.time.kz/news/economics/2018/04/10/izmenit-kompleksnij-plan-privatizacii-dlja-realizacii-socialno-znachimih-obektov-cherez-gchp-predlagajut-v-rk\\\">time.kz</a></b></p>\\r\\n\\r\\n<p><b><a href=\\\"http://www.time.kz/news/economics/2018/04/10/izmenit-kompleksnij-plan-privatizacii-dlja-realizacii-socialno-znachimih-obektov-cherez-gchp-predlagajut-v-rk\\\">http://www.time.kz/news/economics/2018/04/10/izmenit-kompleksnij-plan-privatizacii-dlja-realizacii-socialno-znachimih-obektov-cherez-gchp-predlagajut-v-rk</a></b></p>\"}', '{\"en\": null, \"ru\": null}', '{\"en\": null, \"ru\": null}', 0, 0, 1, 'proekty-gchp', NULL, '2018-10-29 11:17:02', '2018-10-29 11:39:47');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` json NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` json DEFAULT NULL,
  `meta_description` json DEFAULT NULL,
  `content` json NOT NULL,
  `site_display` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `meta_keywords`, `meta_description`, `content`, `site_display`, `created_at`, `updated_at`) VALUES
(1, '{\"en\": null, \"ru\": \"О компании\"}', 'o-kompanii', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<h4>Мы являемся организацией по развитию бизнеса путем реализаций проектов ГЧП</h4>\\r\\n\\r\\n<p><strong>Миссия:&nbsp;</strong>Помочь каждому заказчику в достижении своего видения</p>\\r\\n\\r\\n<p><strong>Ценности:</strong>&nbsp;Полная отдача. Честность и транспарентность. Качество. Воля к победе. Ориентированность на результат</p>\\r\\n\\r\\n<p>Основное внимание мы сосредотачиваем на разработке проектов и развитии бизнеса. В качестве консультантов мы работаем над концептуализацией, планированием и реализацией наших собственных проектов и проектов наших заказчиков.<br />\\r\\nМы предоставляем решения как по отдельным компонентам проекта, так и &laquo;под ключ&raquo;.</p>\\r\\n\\r\\n<p>В качестве консультантов мы работаем над концептуализацией, планированием и реализацией наших собственных проектов и проектов наших заказчиков, предоставляем решения как по отдельным компонентам проекта, так и &laquo;под ключ&raquo;.<br />\\r\\nИмеем опыт в практической реализаций проектов в различных отраслях, с применением максимально возможных мер государственной поддержки и готовы и найти эффективные решения для реализации вашего проекта.<br />\\r\\nНаши проекты:<br />\\r\\n-в сфере управления ТБО (Сопровождение проекта от разработки документаций до заключения договора ГЧП. Внедрение комплексной системы управления отходами, включая раздельный сбор, диспетчеризацию, сортировку, переработку);<br />\\r\\n&mdash; в сфере энергетики (Сопровождение проекта от разработки документаций до заключения договора ГЧП, с учетом внедрения комплексной системы уличного освещения, включая диспетчеризацию и установку энергосберегающих ламп);<br />\\r\\n&mdash; социальные проекты (Сопровождение проектов от разработки документаций до заключения договора ГЧП, таких проектов как строительство детских садов, спортивных площадок, стадиона, медицинских учреждений).</p>\"}', 1, '2018-10-29 08:50:03', '2018-10-29 11:40:11'),
(2, '{\"en\": null, \"ru\": \"Сопровождение проектов\"}', 'soprovozhdenie-proektov', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<p><strong>Сопровождение проектов</strong></p>\\r\\n\\r\\n<p>Ассоциация оказывает содействие в подготовке, сопровождении и запуске проектов ГЧП:</p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Комплексное сопровождение проектов ГЧП</li>\\r\\n\\t<li>Структурирование проектов ГЧП, поддержка в определении наиболее эффективных схем реализации ГЧП проектов, участие в переговорах с соответствующими государственными органами</li>\\r\\n\\t<li>Составление и согласование договоров ГЧП, составление вспомогательной документации в связи с соответствующими отраслевыми постановлениям</li>\\r\\n\\t<li>Получение разрешений и согласований государственных органов, необходимых для реализации проекта ГЧП</li>\\r\\n\\t<li>Содействие в привлечении инвестиций</li>\\r\\n</ul>\"}', 1, '2018-10-29 10:53:49', '2018-10-29 10:53:49'),
(3, '{\"en\": null, \"ru\": \"Консультации\"}', 'konsultacii', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<p><b>Консультации</b></p>\\r\\n\\r\\n<p>Проведение консультаций является постоянной и неотъемлемой частью работы Ассоциации.</p>\\r\\n\\r\\n<p>Консультации проводятся как&nbsp; в очном режиме, так и в режиме дистанционного консалтинга, с использованием современных телекоммуникационных систем</p>\"}', 1, '2018-10-29 11:03:07', '2018-10-29 11:03:07'),
(4, '{\"en\": null, \"ru\": \"Привлечение инвестиций\"}', 'privlechenie-investiciy', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<p><b>Привлечение инвестиций</b></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Поиск иностранных и казахстанских инвесторов</li>\\r\\n\\t<li>Консультации и&nbsp;информационное обеспечение по инвестиционным возможностям, государственным услугам и&nbsp;мерам государственной поддержки</li>\\r\\n\\t<li>Консультации инвесторов по интересующим вопросам, организация мероприятий и встреч между инвесторами и государственными органами, субъектами бизнеса</li>\\r\\n\\t<li>Поиск партнеров для совместной реализации проектов ГЧП</li>\\r\\n\\t<li>Содействие в привлечении долгового финансирования от БВУ и содействия в получении мер государственных поддержек в рамках действующих государственных программ</li>\\r\\n</ul>\"}', 1, '2018-10-29 11:03:59', '2018-10-29 11:03:59'),
(5, '{\"en\": null, \"ru\": \"Что такое ГЧП\"}', 'chto-takoe-gchp', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<ul>\\r\\n\\t<li>Государственно-частное партнерство (ГЧП) &mdash; форма сотрудничества между государственным партнером и частным партнером</li>\\r\\n\\t<li>ГЧП является взаимовыгодным сотрудничеством государства и частного сектора в отраслях, традиционно относящихся к сфере ответственности государства на условиях сбалансированного распределения рисков, выгод и затрат, прав и обязанностей, определяемых в соответствующих договорах</li>\\r\\n\\t<li>Основной целью государственно-частного партнерства является развитие инфраструктуры в интересах общества путем объединения ресурсов и опыта государства и бизнеса, реализация общественно значимых проектов с наименьшими затратами и рисками при условии предоставления экономическим субъектам высококачественных услуг</li>\\r\\n\\t<li>Использование механизмов ГЧП в настоящее время получает широкое&nbsp;распространение в Республике Казахстан и осуществляется во всех отраслях экономики, за исключением объектов, перечень которых определяется Правительством РК</li>\\r\\n</ul>\\r\\n\\r\\n<p><b>Основные признаки ГЧП:</b></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Долгосрочный контракт (до 30 лет) для оказания общественных услуг в сфере здравоохранения, образования, транспорта, ЖКХ и др.</li>\\r\\n\\t<li>Равные партнерские отношения государства и бизнеса на условиях баланса интересов и рисков</li>\\r\\n\\t<li>Возможность предоставления услуг частным сектором от имени государства (сервисное обслуживание авто и&nbsp; ж/д дорог, образование, стационарное лечение и&nbsp; др.)</li>\\r\\n\\t<li>Стороны партнерства должны быть представлены как государственным, так и частным сектором экономики</li>\\r\\n</ul>\\r\\n\\r\\n<p><strong>Финансирование проекта ГЧП может осуществляться за счет:</strong></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>собственных средств частного партнера</li>\\r\\n\\t<li>средств, заимствованных в порядке, установленном законодательством Республики Казахстан<br />\\r\\n\\tсредств государственного бюджета</li>\\r\\n\\t<li>средств субъектов квазигосударственного сектора</li>\\r\\n\\t<li>иных средств, не запрещенных законодательством Республики Казахстан</li>\\r\\n</ul>\\r\\n\\r\\n<p><strong>Источниками возмещения затрат субъектов ГЧП и получения доходов субъектами ГЧП являются:</strong></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>реализация товаров, работ и услуг в процессе эксплуатации объекта государственно-частного партнерства</li>\\r\\n\\t<li>субсидии от государства в случаях, установленных законодательством Республики Казахстан</li>\\r\\n\\t<li>компенсация инвестиционных затрат по проекту государственно-частного партнерства</li>\\r\\n\\t<li>компенсация операционных затрат по проекту государственно-частного партнерства</li>\\r\\n\\t<li>вознаграждение за осуществление управления объектом государственно-частного партнерства, находящимся в государственной собственности, а также арендная плата за пользование объектом государственно-частного партнерства</li>\\r\\n\\t<li>плата за доступность</li>\\r\\n</ul>\"}', 1, '2018-10-29 11:11:02', '2018-10-29 11:11:02'),
(6, '{\"en\": null, \"ru\": \"Законодательство\"}', 'zakonodatelstvo', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<article id=\\\"post-137\\\">\\r\\n<table id=\\\"tablepress-4\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>1. О государственно-частном партнерстве</td>\\r\\n\\t\\t\\t<td>Закон РК от 31 октября 2015&nbsp;года № 379-V ЗРК</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>2. О концессиях<br />\\r\\n\\t\\t\\t&nbsp;</td>\\r\\n\\t\\t\\t<td>Закон РК от 7 июля 2006 года № 167</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>3. О перечне объектов, не подлежащих передаче в концессию</td>\\r\\n\\t\\t\\t<td>Указ Президента РК от 5 марта 2007 года № 294</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>4. О некоторых вопросах Центра развития ГЧП</td>\\r\\n\\t\\t\\t<td>Постановление Правительства РК от 25 декабря 2015 года № 1056</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>5. Об утверждении перечня проектов государственно-частного партнерства особой значимости</td>\\r\\n\\t\\t\\t<td>Постановление Правительства Республики Казахстан от 26 декабря 2017 года № 875</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>6. Об утверждении перечня объектов, не подлежащих передаче для реализации государственно-частного партнерства, в том числе в концессию</td>\\r\\n\\t\\t\\t<td>Постановление Правительства Республики Казахстан от 6 ноября 2017 года № 710.</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>7. О создании специализированной организации по вопросам концессии&nbsp;</td>\\r\\n\\t\\t\\t<td>Постановление Правительства РК от 17 июля 2008 года № 693</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>8. Об определении юридического лица по сопровождению республиканских проектов государственно-частного партнерства</td>\\r\\n\\t\\t\\t<td>Постановление Правительства РК от 25 декабря 2015 года № 1057&nbsp;</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>9. О подписании Соглашения между Правительством Республики Казахстан и Организацией экономического сотрудничества и развития по реализации проекта &laquo;Обзор по реализации государственно-частного партнерства&raquo;</td>\\r\\n\\t\\t\\t<td>Постановление Правительства Республики Казахстан от 31 августа 2017 года № 525</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>10. О некоторых вопросах планирования и реализации проектов ГЧП</td>\\r\\n\\t\\t\\t<td>Приказ МНЭ от 25 ноября 2015 года № 725</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>11. О некоторых вопросах планирования и реализации концессионных проектов</td>\\r\\n\\t\\t\\t<td>Приказ МНЭ от 22 декабря 2014 года № 157</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>12. Об утверждении Правил приема объектов государственно- частного партнерства в государственную собственность</td>\\r\\n\\t\\t\\t<td>Приказ МНЭ от 25 ноября 2015 года № 713</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>13. Об утверждении Правил приема объектов концессии в государственную собственность</td>\\r\\n\\t\\t\\t<td>Приказ МФ от 30 декабря 2008 года № 642.</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>14. Об утверждении Правил передачи во владение и пользование концессионеру объектов концессии, находящихся в государственной собственности&nbsp;<br />\\r\\n\\t\\t\\t<br />\\r\\n\\t\\t\\t&nbsp;</td>\\r\\n\\t\\t\\t<td>Приказ Заместителя Премьер-Министра РК - Министра финансов от 26 февраля 2014 года № 78</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>15. Об утверждении типовой конкурсной документации проекта государственно-частного партнерства и типового договора ГЧП по способам осуществления ГЧП в отдельных отраслях (сферах) экономики</td>\\r\\n\\t\\t\\t<td>Приказ МНЭ от 25 ноября 2015 года № 724</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>16. Об утверждении Типового договора концессии в различных отраслях (сферах) экономики</td>\\r\\n\\t\\t\\t<td>Приказ МНЭ от 27 марта 2015 года № 277</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>17. Об утверждении Методики определения лимитов государственных обязательств по проектам ГЧП, в том числе государственных концессионных обязательств, Правительства Республики Казахстан и местных исполнительных органов</td>\\r\\n\\t\\t\\t<td>Приказ МНЭ от 26 ноября 2015 года № 731</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>18. Об утверждении Правил формирования и утверждения тарифов (цен, ставок сборов) на регулируемые услуги (товары, работы) субъектов естественных монополий, осуществляющих свою деятельность по договору государственно-частного партнерства, в том числе по договору концессии</td>\\r\\n\\t\\t\\t<td>Приказ МНЭ от 30 ноября 2015 года № 743</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>19. Об утверждении Методики определения стоимости объекта концессии, суммарной стоимости государственной поддержки деятельности концессионеров и источников возмещения затрат</td>\\r\\n\\t\\t\\t<td>Приказ МЭБП от 23 февраля 2009 года № 24</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>20. Об утверждении перечня республиканских проектов государственно-частного партнерства, планируемых к реализации</td>\\r\\n\\t\\t\\t<td>Приказ Министра национальной экономики Республики Казахстан от 29 декабря 2017 года № 441.&nbsp;</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>21. Об утверждении методики определения стоимости услуг по консультативному сопровождению проектов государственно-частного партнерства, в том числе концессионных проектов</td>\\r\\n\\t\\t\\t<td>Приказ и.о. Министра национальной экономики Республики Казахстан от 24 июля 2015 года № 564.</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>22. О внесении изменений и дополнений в некоторые приказы уполномоченного органа по государственному планированию&nbsp;</td>\\r\\n\\t\\t\\t<td>Приказ и.о. Министра национальной экономики Республики Казахстан от 27 февраля 2018 года № 80.&nbsp;</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>23. О внесении изменений и дополнений в некоторые законодательные акты Республики Казахстан по вопросам расширения академической и управленческой самостоятельности высших учебных заведений<br />\\r\\n\\t\\t\\t&nbsp;</td>\\r\\n\\t\\t\\t<td>Закон Республики Казахстан от 4 июля 2018 года № 171-VІ ЗРК.</td>\\r\\n\\t\\t</tr>\\r\\n\\t</tbody>\\r\\n</table>\\r\\n</article>\"}', 1, '2018-10-29 11:11:55', '2018-10-29 11:11:55'),
(7, '{\"en\": null, \"ru\": \"Публикации\"}', 'publikacii', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<p><b>Почему Исламское финансирование хорошо подходит как способ финансирования ГЧП проектов в Казахстане?</b><a href=\\\"http://www.gratanet.com/ru/publications/details/why_islamic_finance_fits_well_in_kz_ppp\\\">http://www.gratanet.com/ru/publications/details/why_islamic_finance_fits_well_in_kz_ppp</a></p>\\r\\n\\r\\n<p><b>Аналитический материал о государственно-частном партнерстве в мире&nbsp; &nbsp; &nbsp;</b><a href=\\\"http://astana.gov.kz/ru/modules/material/14084\\\">http://astana.gov.kz/ru/modules/material/14084</a></p>\\r\\n\\r\\n<p><b>Проблемы доменного регулирования в России и Казахстане: необходимо государственно-частное партнерство&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</b><a href=\\\"https://digital.report/problemyi-domennogo-regulirovaniya-v-rossii-i-kazahstane-neobhodimo-gosudarstvenno-chastnoe-partnerstvo/\\\">https://digital.report/problemyi-domennogo-regulirovaniya-v-rossii-i-kazahstane-neobhodimo-gosudarstvenno-chastnoe-partnerstvo/</a></p>\\r\\n\\r\\n<p><b>Возможности ГЧП для инвесторов&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</b><a href=\\\"https://forbes.kz/finances/investment/vozmojnosti_gosudarstvenno-chastnogo_partnerstva_dlya_investorov/\\\">https://forbes.kz/finances/investment/vozmojnosti_gosudarstvenno-chastnogo_partnerstva_dlya_investorov/</a></p>\\r\\n\\r\\n<p><b>Бизнес климат Казахстана: состояние, оценка, развитие&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</b><a href=\\\"https://www.altyn-orda.kz/biznes-klimat-kazahstana-sostoyanie-otsenka-razvitie/\\\">https://www.altyn-orda.kz/biznes-klimat-kazahstana-sostoyanie-otsenka-razvitie/</a></p>\\r\\n\\r\\n<p><b>Основные аспекты стратегического развития государственно-частного партнерства в Казахстане&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</b><a href=\\\"http://group-global.org/ru/publication/17342-osnovnye-aspekty-strategicheskogo-razvitiya-gosudarstvenno-chastnogo-partnerstva-v\\\">http</a><a href=\\\"http://group-global.org/ru/publication/17342-osnovnye-aspekty-strategicheskogo-razvitiya-gosudarstvenno-chastnogo-partnerstva-v\\\">://group-global.org/ru/publication/17342-osnovnye-aspekty-strategicheskogo-razvitiya-gosudarstvenno-chastnogo-partnerstva-v</a></p>\\r\\n\\r\\n<p><b>Мировой&nbsp;</b><b>опыт&nbsp;</b><b>государственно-частного партнерства&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</b><a href=\\\"http://group-global.org/ru/publication/91017-mirovoy-opyt-gosudarstvenno-chastnogo-partnerstva\\\">http</a><a href=\\\"http://group-global.org/ru/publication/91017-mirovoy-opyt-gosudarstvenno-chastnogo-partnerstva\\\">://group-global.org/ru/publication/91017-mirovoy-opyt-gosudarstvenno-chastnogo-partnerstva</a></p>\"}', 1, '2018-10-29 11:12:35', '2018-10-29 11:12:35'),
(8, '{\"en\": null, \"ru\": \"Международный опыт\"}', 'mezhdunarodnyy-opyt', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<table id=\\\"tablepress-2\\\">\\r\\n\\t<thead>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>СТРАНЫ</th>\\r\\n\\t\\t</tr>\\r\\n\\t</thead>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://ppi.worldbank.org/\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Всемирный Банк</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://www.boad.org/fr/projets-approuves-2015\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Африканский Банк развития</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://www.pppo.gov.bd/projects.php\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Бангладеш</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://www.gidb.org/ppp-ppp-project-database\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Индия</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://pkps.bappenas.go.id/index.php/publikasi/ppp-book\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Индонезия</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://pppspain.com/database\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Испания</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://projects.pppcouncil.ca/ccppp/src/public/search-project\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Канада</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://pppunit.go.ke/index.php/project/past-projects\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Кения</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://www.fomin.org/en-us/Home/Projects/ProjectDatabase.aspx\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Латинская Америка и Карибские острова</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://housing%20ppp%20projects/\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Нидерланды</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://www.pppi.ru/projects?etap=3\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Россия</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"https://ppp.gov.ph/?page_id=26068\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">Филиппины</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://www.ppp.gov.za/Lists/PPP%20Project%20List%20Master/Master%20Project%20List.aspx\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">ЮАР</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td><a href=\\\"http://%20public-private%20partnerships%20database/\\\" rel=\\\"noopener\\\" target=\\\"_blank\\\">USAID</a></td>\\r\\n\\t\\t</tr>\\r\\n\\t</tbody>\\r\\n</table>\"}', 1, '2018-10-29 11:13:20', '2018-10-29 11:13:20'),
(9, '{\"en\": null, \"ru\": \"База проектов\"}', 'baza-proektov', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<table id=\\\"tablepress-1\\\" role=\\\"grid\\\">\\r\\n\\t<thead>\\r\\n\\t\\t<tr role=\\\"row\\\">\\r\\n\\t\\t\\t<th colspan=\\\"1\\\" rowspan=\\\"1\\\">&nbsp;</th>\\r\\n\\t\\t\\t<th colspan=\\\"1\\\" rowspan=\\\"1\\\">&nbsp;</th>\\r\\n\\t\\t\\t<th colspan=\\\"1\\\" rowspan=\\\"1\\\">&nbsp;</th>\\r\\n\\t\\t\\t<th colspan=\\\"1\\\" rowspan=\\\"1\\\">&nbsp;</th>\\r\\n\\t\\t</tr>\\r\\n\\t</thead>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr role=\\\"row\\\">\\r\\n\\t\\t\\t<td>ГЧП</td>\\r\\n\\t\\t\\t<td>Заключено договоров/объектов</td>\\r\\n\\t\\t\\t<td>Введено в эксплуатацию объектов</td>\\r\\n\\t\\t\\t<td>На стадии строительства объектов</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr role=\\\"row\\\">\\r\\n\\t\\t\\t<td>Количество</td>\\r\\n\\t\\t\\t<td>223-229</td>\\r\\n\\t\\t\\t<td>164</td>\\r\\n\\t\\t\\t<td>61</td>\\r\\n\\t\\t</tr>\\r\\n\\t\\t<tr role=\\\"row\\\">\\r\\n\\t\\t\\t<td>Сумма&nbsp;(млрд. тенге)</td>\\r\\n\\t\\t\\t<td>786.7</td>\\r\\n\\t\\t\\t<td>100.1</td>\\r\\n\\t\\t\\t<td>686.5</td>\\r\\n\\t\\t</tr>\\r\\n\\t</tbody>\\r\\n</table>\"}', 1, '2018-10-29 11:14:10', '2018-10-29 11:14:10'),
(10, '{\"en\": null, \"ru\": \"Контакты\"}', 'kontakty', '{\"en\": null}', '{\"en\": null}', '{\"en\": null, \"ru\": \"<p>Республика Казахстан,<br />\\r\\nАлматы,<br />\\r\\nулица Макатаева 117.</p>\\r\\n\\r\\n<p>Почтовый индекс: 050000.</p>\\r\\n\\r\\n<p><b>Контактный номер:</b></p>\\r\\n\\r\\n<p>8-777-918-89-51</p>\"}', 1, '2018-10-29 11:14:35', '2018-10-29 11:14:35');

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner` enum('admin','client') COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner` enum('admin','client') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `owner` enum('admin','client') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `role_admins`
--

CREATE TABLE `role_admins` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `uploads`
--

CREATE TABLE `uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `client_file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `conversions` json DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories__lft__rgt_parent_id_index` (`_lft`,`_rgt`,`parent_id`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_alias_index` (`alias`);

--
-- Индексы таблицы `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_admins`
--
ALTER TABLE `role_admins`
  ADD PRIMARY KEY (`admin_id`,`role_id`);

--
-- Индексы таблицы `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploads_type_index` (`type`),
  ADD KEY `uploads_group_id_index` (`group_id`),
  ADD KEY `uploads_mime_index` (`mime`),
  ADD KEY `uploads_client_file_name_index` (`client_file_name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
