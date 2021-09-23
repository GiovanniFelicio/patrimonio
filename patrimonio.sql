-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 27-Dez-2019 às 14:32
-- Versão do servidor: 5.7.28-0ubuntu0.16.04.2
-- PHP Version: 7.0.33-13+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patrimonio`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_activities`
--

CREATE TABLE `log_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_10_25_002305_create_users_actions_table', 1),
(4, '2019_11_09_175850_create_secretarias_table', 1),
(5, '2019_12_11_142105_create_log_activities_table', 1),
(6, '2019_12_26_122244_create_patrimonios_table', 2),
(7, '2019_12_26_170347_create_setores_table', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patrimonios`
--

CREATE TABLE `patrimonios` (
  `id` int(10) UNSIGNED NOT NULL,
  `sec_id` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setor_id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `dtaquisicao` date NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `situacao` tinyint(4) NOT NULL,
  `localizacao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `patrimonios`
--

INSERT INTO `patrimonios` (`id`, `sec_id`, `nome`, `setor_id`, `codigo`, `numero`, `dtaquisicao`, `estado`, `situacao`, `localizacao`, `observacao`, `created_at`, `updated_at`) VALUES
(1, 1, 'Notebook Hp Pro Book', 1, 2, 517, '2018-10-02', 1, 1, 'Giovanni', '', NULL, '2019-12-27 15:37:14'),
(2, 1, 'Notebook Hp', 1, 5, 451, '2019-12-25', 3, 2, 'Leomar Felipe', 'Sem Bateria', '2019-12-26 23:51:17', '2019-12-27 03:16:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `secretarias`
--

CREATE TABLE `secretarias` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `secretarias`
--

INSERT INTO `secretarias` (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Fundetec', 'fundetec@fundetec.org.br', '2019-12-01 03:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores`
--

CREATE TABLE `setores` (
  `id` int(10) UNSIGNED NOT NULL,
  `sec_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `setores`
--

INSERT INTO `setores` (`id`, `sec_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Fábrica de Inovação', 1, NULL, NULL),
(2, 1, 'Gerência Administrativa', 1, '2019-12-27 19:06:42', '2019-12-27 19:06:42'),
(3, 1, 'Diretoria Técnica', 1, '2019-12-27 19:24:09', '2019-12-27 19:24:09'),
(4, 1, 'CIT', 1, '2019-12-27 19:26:24', '2019-12-27 19:26:24'),
(5, 1, 'Recursos Humanos', 1, '2019-12-27 20:20:14', '2019-12-27 20:20:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sec_id` int(11) NOT NULL,
  `setor_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` mediumint(9) NOT NULL,
  `token_access` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricula` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `sec_id`, `setor_id`, `name`, `email`, `password`, `level`, `token_access`, `matricula`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Giovanni', 'giovanni.carvalho@fundetec.org.br', '$2y$12$/Z9NnVPPUcNdHyKoBRzGYeWKR8xRictfjwAGRtIVjhYH2TFeZWehy', 4, '$2y$10$o2.zPhjHdSmWxtD8/6zxJeZeQ0WG6ODrfNI2pFOQL4DFNGMQhQN6O', '171717', 1, NULL, NULL, '2019-12-27 17:46:18'),
(2, 1, 5, 'Francieli Donato', 'francieli@fundetec.org.br', '$2y$10$W4BXiz4ZS0/dfhZMes2tEeTFiw2IdZThHdeKTFG2M4Q2E5jeLdSEK', 2, NULL, '111111', 1, NULL, '2019-12-27 20:08:50', '2019-12-27 20:20:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_actions`
--

CREATE TABLE `users_actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `func` int(11) NOT NULL,
  `sec_id` int(11) NOT NULL,
  `setor_id` int(11) NOT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users_actions`
--

INSERT INTO `users_actions` (`id`, `func`, `sec_id`, `setor_id`, `action`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 'Criou o Setor CIT da Sec/Aut Fundetec', '2019-12-27 19:26:24', '2019-12-27 19:26:24'),
(2, 1, 1, 0, 'Criou o funcionário Francieli Donato', '2019-12-27 20:08:50', '2019-12-27 20:08:50'),
(3, 1, 1, 0, 'Atualizou o Funcionário Francieli Donato', '2019-12-27 20:18:38', '2019-12-27 20:18:38'),
(4, 1, 1, 0, 'Criou o Setor Recursos Humanos da Sec/Aut Fundetec', '2019-12-27 20:20:14', '2019-12-27 20:20:14'),
(5, 1, 1, 0, 'Atualizou o Funcionário Francieli Donato', '2019-12-27 20:20:27', '2019-12-27 20:20:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_activities`
--
ALTER TABLE `log_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patrimonios`
--
ALTER TABLE `patrimonios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secretarias`
--
ALTER TABLE `secretarias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `secretarias_emailsec_unique` (`email`);

--
-- Indexes for table `setores`
--
ALTER TABLE `setores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_actions`
--
ALTER TABLE `users_actions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `patrimonios`
--
ALTER TABLE `patrimonios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `secretarias`
--
ALTER TABLE `secretarias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `setores`
--
ALTER TABLE `setores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users_actions`
--
ALTER TABLE `users_actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
