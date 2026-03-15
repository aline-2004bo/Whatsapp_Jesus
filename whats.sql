`groups``groups`-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2026 a las 21:59:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

whatswhats

USE whats;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `whats`
--

-- --------------------------------------------------------
-- 1. Creamos la tabla de Grupos
CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Creamos la tabla para agregar a las personas a los grupos
CREATE TABLE `group_user` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `joined_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Modificamos tu tabla de mensajes actual
ALTER TABLE `messages`
  -- Permitimos que receiver_id quede vacío (NULL)
  MODIFY `receiver_id` bigint(20) UNSIGNED NULL,
  -- Agregamos la columna para saber si es un mensaje de grupo
  ADD `group_id` bigint(20) UNSIGNED NULL AFTER `receiver_id`,
  -- Conectamos la columna con la tabla de grupos
  ADD CONSTRAINT `messages_group_ibfk` FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE;
--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` mediumtext DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `file`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Hola Maria ?c?mo est?s?', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(2, 2, 1, 'Hola Juan, muy bien ?y t??', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(3, 1, 2, 'Todo bien, trabajando en el proyecto de Laravel', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(4, 2, 1, 'Yo igual, est? interesante el chat tipo WhatsApp', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(5, 3, 1, 'Juan ?ya terminaste el sistema?', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(6, 1, 3, 'Casi, solo me falta mejorar el chat', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(7, 3, 1, 'Se ve bastante bien', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(8, 4, 5, 'Pedro ?vas a la reuni?n ma?ana?', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(9, 5, 4, 'S?, a las 10 AM', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(10, 4, 5, 'Perfecto ah? nos vemos', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(11, 2, 3, 'Carlos ?me pasas el documento?', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(12, 3, 2, 'Claro, te lo mando en un momento', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(13, 2, 3, 'Gracias', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(14, 5, 1, 'Juan ?ya probaste el chat?', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(15, 1, 5, 'S? funciona bastante bien', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(16, 5, 1, 'Genial, parece WhatsApp', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(17, 4, 2, 'Maria ?todo listo para el proyecto?', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(18, 2, 4, 'S? ya casi terminamos', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(19, 4, 2, 'Excelente', NULL, '2026-03-07 14:54:29', '2026-03-07 14:54:29'),
(20, 6, 3, 'como estas?', NULL, '2026-03-07 23:02:52', '2026-03-07 23:02:52'),
(21, 1, 5, 'como estas?', NULL, '2026-03-07 23:03:28', '2026-03-07 23:03:28'),
(65, 1, 3, 'hola', NULL, '2026-03-08 10:49:00', '2026-03-08 10:49:00'),
(74, 1, 4, 'ya terminaste la comida?', NULL, '2026-03-08 22:01:02', '2026-03-08 22:01:02'),
(75, 1000, 4, 'como estas?', NULL, '2026-03-09 01:17:25', '2026-03-09 01:17:25'),
(76, 1000, 4, 'te envio el pdf del reporte', '1772997460_Horarios Ene- Abr OFICIAL (1).pdf', '2026-03-09 01:17:40', '2026-03-09 01:17:40'),
(77, 1, 1000, 'ya terminaste lo que te mande hacer?', NULL, '2026-03-09 01:19:05', '2026-03-09 01:19:05'),
(78, 1, 1000, 'ya no me comentaste nada de lo que se te encargo', NULL, '2026-03-09 01:19:15', '2026-03-09 01:19:15'),
(79, 1000, 1, 'le envio la imagen de lo que llevo de avance', '1773000126_oma.jpg', '2026-03-09 02:02:06', '2026-03-09 02:02:06'),
(80, 1, 2, 'auqi esta la imagen de los datos que pediste', '1773000600_oma.jpg', '2026-03-09 02:10:00', '2026-03-09 02:10:00'),
(81, 1, 2, NULL, '1773000889_R.png', '2026-03-09 02:14:49', '2026-03-09 02:14:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_07_140613_create_messages_table', 2),
(5, '2026_03_07_145201_create_messages_table', 3),
(6, '2026_03_08_192913_add_avatar_to_users_table', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cDTbBz9r7M5CFkkTlnpBzF3NqIQxb4SqgRGXj920', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkF2UG5MSGRWUEZjYkNNVzZ2RWx4dmRxRFFFMW41S2E5WVlkOU5wQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZXNzYWdlcy8yIjtzOjU6InJvdXRlIjtOO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1773002216),
('iRV2DGlp4ZmVxilbOBVtDVoekOniytR9DReLZupb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGlWeHo5ZlF3SndhTWE4UW1mSkdTaHJTRWpWRGFJSlVnVFVVNlp4YSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1773000503);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Juan Perez', 'juan@gmail.com', 'avatars/9XG0MkSaSgYX0QZB8kRb3jjRZqgJKfDzxL47BeTd.jpg', NULL, '$2y$12$eP.4auN9gt.di3tK3Vz.H.Vino/J2u80uSlLR7LEKvUTFwUkMw2vG', NULL, '2026-03-07 14:52:58', '2026-03-09 02:33:44'),
(2, 'Maria Lopez', 'maria@gmail.com', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9Yb6rZ5qX6Ch12yvDqOiiW', NULL, '2026-03-07 14:52:58', '2026-03-07 14:52:58'),
(3, 'Carlos Ruiz', 'carlos@mail.com', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9Yb6rZ5qX6Ch12yvDqOiiW', NULL, '2026-03-07 14:52:58', '2026-03-07 14:52:58'),
(4, 'Ana Torres', 'ana@mail.com', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9Yb6rZ5qX6Ch12yvDqOiiW', NULL, '2026-03-07 14:52:58', '2026-03-07 14:52:58'),
(5, 'Pedro Garcia', 'pedro@mail.com', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9Yb6rZ5qX6Ch12yvDqOiiW', NULL, '2026-03-07 14:52:58', '2026-03-07 14:52:58'),
(6, 'Admin', 'admin@mail.com', NULL, NULL, '$2y$12$/jkBoC/6VZhDQNErNfT3xueJtAW7LfmwMMzpN8x2F08yvtj1AWi..', NULL, '2026-03-07 21:09:02', '2026-03-07 21:09:02'),
(999, 'AI Assistant', 'ia@tuplataforma.com', NULL, NULL, 'sin-acceso', NULL, NOW(), NOW()),
(1000, 'Gae', 'gaelceron45@gmail.com', NULL, NULL, '$2y$12$2UFaD7QHLx0fIK7DdnP6Pei4WurU.gIaBC0.PmXxV12Et0W3.M9um', NULL, '2026-03-09 00:47:28', '2026-03-09 01:58:08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
