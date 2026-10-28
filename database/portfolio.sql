
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `education` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'degree',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` VALUES (1,'degree','B.Sc. in Computer Science','Fayoum University — Faculty of Science','2015 — 2019',0,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(2,'certification','Building Web Applications using PHP & MySQL','Information Technology Institute (ITI)','2022',1,'2026-10-25 06:52:17','2026-10-25 06:52:17');
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `experiences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_remote` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `highlights` json DEFAULT NULL,
  `tech_stack` json DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `experiences` WRITE;
/*!40000 ALTER TABLE `experiences` DISABLE KEYS */;
INSERT INTO `experiences` VALUES (1,'Gap Cloud','Senior Backend Developer','Cairo, Egypt',0,'2025-08-01',NULL,'[\"Led backend development of a scalable ERP platform serving multiple business domains.\", \"Designed backend modules using Clean Architecture, SOLID, Repository Pattern and Service Layer architecture.\", \"Provided architectural guidance, ran code reviews and mentored developers.\", \"Promoted a test-first mindset with PHPUnit/Pest suites for critical business workflows.\", \"Implemented Redis-based caching and Redis-driven job queues to handle high-volume async operations.\", \"Managed CI/CD pipelines on Azure Pipelines for build, test, staging and production deployments.\"]','[\"Laravel\", \"Filament\", \"Redis\", \"Pest\", \"Azure Pipelines\", \"MySQL\"]',0,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(2,'Etolv','Senior Backend Developer','Cairo, Egypt',0,'2024-11-01','2025-08-01','[\"Developed and maintained a large-scale tourism ERP with complex business logic and high-traffic operations.\", \"Optimized system performance and database efficiency across millions of daily user interactions.\", \"Handled a Neo4j graph database with 25M+ records, designing advanced relationship-driven queries.\"]','[\"Laravel\", \"Lumen\", \"Neo4j\", \"MySQL\"]',1,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(3,'STC Skills For Technology & Coring','Backend Developer','Cairo, Egypt',0,'2023-07-01','2024-10-01','[\"Resolved complex issues in e-learning systems, improving performance and reliability.\", \"Built a custom ERP reporting system that automates report generation.\", \"Enhanced security with role-based permissions and secure authentication.\", \"Delivered scalable solutions with Laravel, SQL and third-party integrations.\"]','[\"Laravel\", \"MySQL\", \"Pusher\", \"Laravel Excel\"]',2,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(4,'BILLX','Backend Developer','Saudi Arabia',1,'2022-06-01','2023-05-01','[\"Developed and managed CRM systems for multi-tenant environments and real estate platforms.\", \"Implemented real-time auction functionality using WebSockets and live data technologies.\", \"Analysed systems to identify and fix design discrepancies.\"]','[\"Laravel\", \"WebSockets\", \"Multi-tenancy\", \"MySQL\"]',3,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(5,'Flafina-Zakham','Full Stack Developer','Saudi Arabia',1,'2020-01-01','2022-06-01','[\"Built backend services and RESTful APIs with PHP and Laravel, plus internal and customer-facing frontends.\", \"Designed and optimized MySQL schemas and queries for growing data and reporting needs.\", \"Implemented authentication, RBAC and secure API endpoints.\", \"Built responsive UI components with JavaScript, jQuery and Bootstrap.\"]','[\"PHP\", \"Laravel\", \"MySQL\", \"jQuery\", \"Bootstrap\"]',4,1,'2026-10-25 06:52:17','2026-10-25 06:52:17');
/*!40000 ALTER TABLE `experiences` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (5,'admin','technical.support@stc-eg.com','TTE','EW',NULL,'2026-10-25 07:31:12','2026-10-25 07:31:12');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_25_094427_create_profiles_table',1),(5,'2026_10_25_094428_create_experiences_table',1),(6,'2026_10_25_094430_create_projects_table',1),(7,'2026_10_25_094431_create_skill_groups_table',1),(8,'2026_10_25_094432_create_education_table',1),(9,'2026_10_25_094433_create_messages_table',1),(10,'2026_10_26_064011_add_expertise_to_profiles_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `about` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `years_experience` tinyint unsigned NOT NULL DEFAULT '0',
  `stats` json DEFAULT NULL,
  `expertise` json DEFAULT NULL,
  `available_for_work` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Mohamed Khater','Senior Laravel Backend Engineer','I architect and scale ERP, Fintech and high-traffic platforms with PHP & Laravel.','Senior Laravel Backend Engineer with 6+ years of experience architecting and scaling ERP, Fintech, and high-traffic platforms. I build payment processing engines, recurring billing, RBAC systems, approval workflows and payroll engines — with a strong focus on clean architecture, transactional consistency and performance.','I\'m a backend engineer based in Cairo who loves turning complex business rules into clean, testable and scalable systems.\n\nMy work centers on Payment Processing Engines and Recurring Billing (Stripe & PayTabs, webhooks, subscriptions), RBAC and approval workflows, payroll/financial engines, and performance tuning for large relational and graph databases — MySQL, PostgreSQL and Neo4j with 25M+ records.\n\nI design with Clean Architecture, SOLID and the Repository / Service Layer patterns, rely on Redis for caching and queues, practice TDD with PHPUnit & Pest, and ship through CI/CD on Azure Pipelines. These days I\'m leading backend development of a multi-tenant ERP platform at Gap Cloud, mentoring developers and reviewing code along the way.','mhmedkhaater@gmail.com','+20 102 127 7815','Cairo, Egypt','https://linkedin.com/in/mohamed-mahmmud','https://github.com/Mohammed-Mahmmud','profile/3PfFwKyxi4053w4pfq0nxTPocvPbcfQDXVoL2gGf.jpg','cv/Mohamed_Khater_Senior_Backend_Engineer_CV.pdf',6,'[{\"label\": \"Years of experience\", \"value\": \"6+\"}, {\"label\": \"Projects delivered\", \"value\": \"15+\"}, {\"label\": \"Neo4j records optimized\", \"value\": \"25M+\"}, {\"label\": \"Payment gateways integrated\", \"value\": \"2\"}]','[{\"icon\": \"credit-card\", \"title\": \"Payments & Billing\", \"description\": \"Stripe and PayTabs integrations, idempotent webhooks, subscriptions, recurring invoicing and ETA e-invoicing.\"}, {\"icon\": \"layers\", \"title\": \"ERP Architecture\", \"description\": \"Multi-tenant HR, payroll, finance and procurement modules with RBAC and reusable approval engines.\"}, {\"icon\": \"gauge\", \"title\": \"Performance at Scale\", \"description\": \"Query optimization on MySQL, PostgreSQL and Neo4j (25M+ records), Redis caching and queue-driven workloads.\"}, {\"icon\": \"shield-check\", \"title\": \"Quality & Delivery\", \"description\": \"Clean Architecture, SOLID, TDD with PHPUnit/Pest, code reviews and CI/CD on Azure Pipelines.\"}]',1,'2026-10-25 06:52:17','2026-10-25 07:19:46');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlights` json DEFAULT NULL,
  `tech_stack` json DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Multi-Tenant ERP System','multi-tenant-erp-system','ERP · Fintech','Modular, multi-tenant ERP covering HR, Finance, Payroll, Approvals and Procurement — with Stripe/PayTabs billing and Egypt ETA e-invoicing.','[\"Clean Architecture with Repository and Service Layer for long-term scalability.\", \"Attendance engine with location-based check-in, custom shifts and real-time preview.\", \"Dynamic RBAC with fine-grained, per-employee permissions.\", \"Complete payroll: contracts, salary structures, automated payslips and adjustments.\", \"Reusable approval engine with sequential and parallel multi-level flows.\", \"Stripe (PaymentIntents, Webhooks, Subscriptions) and PayTabs with idempotent webhook handling.\", \"Recurring billing integrated with financial records and ETA e-invoicing.\", \"Migrated from Filament v3 → v4 and Laravel 11 → 12 with zero downtime.\"]','[\"Laravel 12\", \"Filament v4\", \"Redis\", \"Stripe\", \"PayTabs\", \"ETA\", \"Pest\"]',NULL,NULL,1,0,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(2,'HR Recruitment & ATS Module','hr-recruitment-ats-module','HR Tech','Recruitment module with CV parsing, experience calculation, configurable interview workflows and Zoom / Meet / Teams integration.','[\"ATS service that parses PDF/DOC/DOCX CVs and auto-fills applications.\", \"Experience-calculation engine matching job keywords against work history.\", \"Interview workflow engine with delayed Redis jobs and status-driven triggers.\", \"Automatic assessment scoring and automated onboarding/offboarding.\", \"Multi-vendor, multi-tenant offer letter generation.\"]','[\"Laravel\", \"Redis Queues\", \"Zoom API\", \"Google Meet\", \"MS Teams\"]',NULL,NULL,1,1,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(3,'TrioAPI — Tourism ERP','trioapi-tourism-erp','ERP · Tourism','Large-scale tourism ERP powering complex booking workflows on top of a 25M+ record Neo4j graph.','[\"Upgraded from Lumen → Laravel 9 → Laravel 11 across major version jumps.\", \"Designed and optimized Neo4j queries over 25M+ records.\", \"Led performance tuning to keep the system stable under heavy traffic.\"]','[\"Laravel 11\", \"Lumen\", \"Neo4j\", \"MySQL\"]',NULL,NULL,1,2,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(4,'STC Inspection System','stc-inspection-system','Oil & Gas','Management system for inspectors: reports, job tickets, rigs and clients with multi-stage workflows and audit trails.','[\"RBAC with Laravel Policies and Gates for inspectors, admins and clients.\", \"Dynamic filtered reports exportable to CSV / Excel / PDF.\", \"Real-time notifications with Echo and Pusher.\", \"Full audit trail and client dashboards.\"]','[\"Laravel\", \"Policies & Gates\", \"Laravel Echo\", \"Pusher\", \"Laravel Excel\"]',NULL,NULL,0,3,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(5,'STC Exam System (Nile Future)','stc-exam-system-nile-future','E-Learning','Online exams and training certificates for the oil & gas sector, with QR-verified certificates.','[\"Bulk user import via Excel.\", \"Customizable dynamic exams.\", \"QR-code certificates with bulk extraction and reports.\"]','[\"Laravel\", \"Excel Import\", \"QR Codes\"]',NULL,NULL,0,4,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(6,'MLS Real Estate & Auction Platform','mls-real-estate-auction-platform','Real Estate','Multiple Listing Service with live real-estate auctions over WebSockets and a multi-tenant architecture.','[\"Live bidding with real-time updates.\", \"Advanced filtering, location-based search and comparison.\", \"Multi-tenant for government and private-sector stakeholders.\"]','[\"Laravel\", \"WebSockets\", \"Multi-tenancy\"]',NULL,NULL,0,5,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(7,'Inventory ERP System','inventory-erp-system','ERP · Accounting','Inventory, accounting and reporting unified in one ERP, with Stripe subscriptions reconciled against the ledger.','[\"Real-time stock tracking and management.\", \"Automated accounting modules and dynamic financial reports.\", \"Recurring invoicing via Stripe subscriptions with webhook reconciliation.\"]','[\"Laravel\", \"Stripe\", \"MySQL\"]',NULL,NULL,0,6,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(8,'E-SHEF','e-shef','E-Commerce','E-commerce platform for food, herbs, seeds and spices across Egypt and the Arab world.','[\"Stripe and PayTabs checkout flows.\", \"Webhook-based payment confirmation keeping orders and inventory in sync.\"]','[\"Laravel\", \"Stripe\", \"PayTabs\"]',NULL,NULL,0,7,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(9,'SWYYP Platform','swyyp-platform','Sports · Mobile','Multi-role platform and mobile app for football players to track performance, join events and redeem prizes.','[\"Admin and vendor dashboards for users, events and rewards.\", \"Real-time prize catalogs and push notifications.\"]','[\"Laravel\", \"REST API\", \"Push Notifications\"]',NULL,NULL,0,8,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(10,'FALAFINA','falafina','Restaurant','Restaurant management: orders, menus, inventory and staff scheduling.','[\"Online and in-house ordering.\", \"Real-time stock with automated reordering.\"]','[\"Laravel\", \"MySQL\"]',NULL,NULL,0,9,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(11,'BAWARQ','bawarq','Oil & Gas','Oil & gas tools and inspection services platform — schedule inspections and track tool history.','[\"Inspection scheduling and tool condition tracking.\", \"Maintenance schedules and certifications.\"]','[\"Laravel\", \"MySQL\"]','https://bawarq.org',NULL,0,10,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(12,'MAHARAT','maharat','E-Learning','Professional development and skills-training platform with course management and progress tracking.','[\"Course management and registration.\", \"Learning progress tracking.\"]','[\"Laravel\", \"MySQL\"]',NULL,NULL,0,11,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(13,'SHELLY','shelly','IoT','Smart-home automation platform for Wi-Fi and Bluetooth devices.','[\"Device control for lighting, security and appliances.\"]','[\"Laravel\", \"IoT\"]',NULL,NULL,0,12,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(14,'SITEWORK','sitework','Corporate','Website for a landscaping company specialising in irrigation networks, sports fields and pools.','[\"Service catalogue and project showcase.\"]','[\"Laravel\"]',NULL,NULL,0,13,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(15,'ORCHIDIAPHARMA','orchidiapharma','Pharma','Pharmaceutical product catalogue with search and customer support features.','[\"Product catalogue with search.\", \"Contact and support forms.\"]','[\"Laravel\"]',NULL,NULL,0,14,1,'2026-10-25 06:52:17','2026-10-25 06:52:17');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `skill_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skill_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` json DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `skill_groups` WRITE;
/*!40000 ALTER TABLE `skill_groups` DISABLE KEYS */;
INSERT INTO `skill_groups` VALUES (1,'Backend & Frameworks','[\"PHP\", \"Laravel\", \"Livewire\", \"Inertia.js\", \"Filament\", \"Alpine.js\", \"OOP\", \"SOLID\", \"Clean Architecture\", \"Repository Pattern\", \"Service Layer\", \"REST API Design\"]',0,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(2,'Fintech & Payments','[\"Stripe API\", \"PayTabs\", \"Webhooks\", \"Subscriptions\", \"Recurring Payments\", \"Dynamic Invoicing\", \"ETA E-Invoicing\", \"PCI-DSS Awareness\"]',1,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(3,'Databases','[\"MySQL\", \"PostgreSQL\", \"Neo4j\", \"NoSQL\", \"Query Optimization\", \"Indexing\"]',2,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(4,'Caching & Queues','[\"Redis\", \"Laravel Queues\", \"Delayed Jobs\", \"Background Jobs\"]',3,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(5,'Testing','[\"PHPUnit\", \"Pest\", \"TDD\", \"Automated Testing\"]',4,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(6,'DevOps & Cloud','[\"Linux\", \"Docker\", \"Azure Pipelines\", \"AWS\", \"Azure\", \"cPanel / WHM\"]',5,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(7,'Frontend','[\"JavaScript\", \"jQuery\", \"Ajax\", \"Bootstrap\", \"Tailwind CSS\"]',6,1,'2026-10-25 06:52:17','2026-10-25 06:52:17'),(8,'Leadership','[\"Technical Leadership\", \"Architecture Design\", \"Code Reviews\", \"Mentoring\", \"Agile / SDLC\"]',7,1,'2026-10-25 06:52:17','2026-10-25 06:52:17');
/*!40000 ALTER TABLE `skill_groups` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mohamed Khater','admin@portfolio.test',NULL,'$2y$12$nYyqj8CaegM1CMjOqjx3oON4raFdnrCLyARL8NTYbegqVUXaFlgOq','5iXCaEKoUjb2ll6BcltYbvAGqKiIfSjfdXNoIrxn6vx0HzCnYPQXxzaJACny','2026-10-25 06:52:17','2026-10-25 06:52:17');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

