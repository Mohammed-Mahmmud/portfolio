<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Profile::query()->delete();
        Experience::query()->delete();
        Project::query()->delete();
        SkillGroup::query()->delete();
        Education::query()->delete();

        Profile::create([
            'name' => 'Mohamed Khater',
            'title' => 'Senior Laravel Backend Engineer',
            'tagline' => 'I architect and scale ERP, Fintech and high-traffic platforms with PHP & Laravel.',
            'summary' => 'Senior Laravel Backend Engineer with 6+ years of experience architecting and scaling ERP, Fintech, and high-traffic platforms. I build payment processing engines, recurring billing, RBAC systems, approval workflows and payroll engines — with a strong focus on clean architecture, transactional consistency and performance.',
            'about' => "I'm a backend engineer based in Cairo who loves turning complex business rules into clean, testable and scalable systems.\n\nMy work centers on Payment Processing Engines and Recurring Billing (Stripe & PayTabs, webhooks, subscriptions), RBAC and approval workflows, payroll/financial engines, and performance tuning for large relational and graph databases — MySQL, PostgreSQL and Neo4j with 25M+ records.\n\nI design with Clean Architecture, SOLID and the Repository / Service Layer patterns, rely on Redis for caching and queues, practice TDD with PHPUnit & Pest, and ship through CI/CD on Azure Pipelines. These days I'm leading backend development of a multi-tenant ERP platform at Gap Cloud, mentoring developers and reviewing code along the way.",
            'email' => 'mhmedkhaater@gmail.com',
            'phone' => '+20 102 127 7815',
            'location' => 'Cairo, Egypt',
            'linkedin_url' => 'https://linkedin.com/in/mohamed-mahmmud',
            'github_url' => null,
            'cv_file' => 'cv/Mohamed_Khater_Senior_Backend_Engineer_CV.pdf',
            'years_experience' => 6,
            'stats' => [
                ['label' => 'Projects delivered', 'value' => '15+'],
                ['label' => 'Neo4j records optimized', 'value' => '25M+'],
                ['label' => 'Payment gateways integrated', 'value' => '2'],
            ],
            'expertise' => [
                ['icon' => 'credit-card', 'title' => 'Payments & Billing', 'description' => 'Stripe and PayTabs integrations, idempotent webhooks, subscriptions, recurring invoicing and ETA e-invoicing.'],
                ['icon' => 'layers', 'title' => 'ERP Architecture', 'description' => 'Multi-tenant HR, payroll, finance and procurement modules with RBAC and reusable approval engines.'],
                ['icon' => 'gauge', 'title' => 'Performance at Scale', 'description' => 'Query optimization on MySQL, PostgreSQL and Neo4j (25M+ records), Redis caching and queue-driven workloads.'],
                ['icon' => 'shield-check', 'title' => 'Quality & Delivery', 'description' => 'Clean Architecture, SOLID, TDD with PHPUnit/Pest, code reviews and CI/CD on Azure Pipelines.'],
            ],
            'available_for_work' => true,
        ]);

        $experiences = [
            [
                'company' => 'Gap Cloud',
                'role' => 'Senior Backend Developer',
                'location' => 'Cairo, Egypt',
                'start_date' => '2025-08-01',
                'end_date' => null,
                'tech_stack' => ['Laravel', 'Filament', 'Redis', 'Pest', 'Azure Pipelines', 'MySQL'],
                'highlights' => [
                    'Led backend development of a scalable ERP platform serving multiple business domains.',
                    'Designed backend modules using Clean Architecture, SOLID, Repository Pattern and Service Layer architecture.',
                    'Provided architectural guidance, ran code reviews and mentored developers.',
                    'Promoted a test-first mindset with PHPUnit/Pest suites for critical business workflows.',
                    'Implemented Redis-based caching and Redis-driven job queues to handle high-volume async operations.',
                    'Managed CI/CD pipelines on Azure Pipelines for build, test, staging and production deployments.',
                ],
            ],
            [
                'company' => 'Etolv',
                'role' => 'Senior Backend Developer',
                'location' => 'Cairo, Egypt',
                'start_date' => '2024-11-01',
                'end_date' => '2025-08-01',
                'tech_stack' => ['Laravel', 'Lumen', 'Neo4j', 'MySQL'],
                'highlights' => [
                    'Developed and maintained a large-scale tourism ERP with complex business logic and high-traffic operations.',
                    'Optimized system performance and database efficiency across millions of daily user interactions.',
                    'Handled a Neo4j graph database with 25M+ records, designing advanced relationship-driven queries.',
                ],
            ],
            [
                'company' => 'STC Skills For Technology & Coring',
                'role' => 'Backend Developer',
                'location' => 'Cairo, Egypt',
                'start_date' => '2023-07-01',
                'end_date' => '2024-10-01',
                'tech_stack' => ['Laravel', 'MySQL', 'Pusher', 'Laravel Excel'],
                'highlights' => [
                    'Resolved complex issues in e-learning systems, improving performance and reliability.',
                    'Built a custom ERP reporting system that automates report generation.',
                    'Enhanced security with role-based permissions and secure authentication.',
                    'Delivered scalable solutions with Laravel, SQL and third-party integrations.',
                ],
            ],
            [
                'company' => 'BILLX',
                'role' => 'Backend Developer',
                'location' => 'Saudi Arabia',
                'is_remote' => true,
                'start_date' => '2022-06-01',
                'end_date' => '2023-05-01',
                'tech_stack' => ['Laravel', 'WebSockets', 'Multi-tenancy', 'MySQL'],
                'highlights' => [
                    'Developed and managed CRM systems for multi-tenant environments and real estate platforms.',
                    'Implemented real-time auction functionality using WebSockets and live data technologies.',
                    'Analysed systems to identify and fix design discrepancies.',
                ],
            ],
            [
                'company' => 'Flafina-Zakham',
                'role' => 'Full Stack Developer',
                'location' => 'Saudi Arabia',
                'is_remote' => true,
                'start_date' => '2020-01-01',
                'end_date' => '2022-06-01',
                'tech_stack' => ['PHP', 'Laravel', 'MySQL', 'jQuery', 'Bootstrap'],
                'highlights' => [
                    'Built backend services and RESTful APIs with PHP and Laravel, plus internal and customer-facing frontends.',
                    'Designed and optimized MySQL schemas and queries for growing data and reporting needs.',
                    'Implemented authentication, RBAC and secure API endpoints.',
                    'Built responsive UI components with JavaScript, jQuery and Bootstrap.',
                ],
            ],
        ];

        foreach ($experiences as $i => $experience) {
            Experience::create($experience + ['sort_order' => $i]);
        }

        $projects = [
            [
                'title' => 'Multi-Tenant ERP System',
                'category' => 'ERP · Fintech',
                'is_featured' => true,
                'summary' => 'Modular, multi-tenant ERP covering HR, Finance, Payroll, Approvals and Procurement — with Stripe/PayTabs billing and Egypt ETA e-invoicing.',
                'tech_stack' => ['Laravel 12', 'Filament v4', 'Redis', 'Stripe', 'PayTabs', 'ETA', 'Pest'],
                'highlights' => [
                    'Clean Architecture with Repository and Service Layer for long-term scalability.',
                    'Attendance engine with location-based check-in, custom shifts and real-time preview.',
                    'Dynamic RBAC with fine-grained, per-employee permissions.',
                    'Complete payroll: contracts, salary structures, automated payslips and adjustments.',
                    'Reusable approval engine with sequential and parallel multi-level flows.',
                    'Stripe (PaymentIntents, Webhooks, Subscriptions) and PayTabs with idempotent webhook handling.',
                    'Recurring billing integrated with financial records and ETA e-invoicing.',
                    'Migrated from Filament v3 → v4 and Laravel 11 → 12 with zero downtime.',
                ],
            ],
            [
                'title' => 'HR Recruitment & ATS Module',
                'category' => 'HR Tech',
                'is_featured' => true,
                'summary' => 'Recruitment module with CV parsing, experience calculation, configurable interview workflows and Zoom / Meet / Teams integration.',
                'tech_stack' => ['Laravel', 'Redis Queues', 'Zoom API', 'Google Meet', 'MS Teams'],
                'highlights' => [
                    'ATS service that parses PDF/DOC/DOCX CVs and auto-fills applications.',
                    'Experience-calculation engine matching job keywords against work history.',
                    'Interview workflow engine with delayed Redis jobs and status-driven triggers.',
                    'Automatic assessment scoring and automated onboarding/offboarding.',
                    'Multi-vendor, multi-tenant offer letter generation.',
                ],
            ],
            [
                'title' => 'TrioAPI — Tourism ERP',
                'category' => 'ERP · Tourism',
                'is_featured' => true,
                'summary' => 'Large-scale tourism ERP powering complex booking workflows on top of a 25M+ record Neo4j graph.',
                'tech_stack' => ['Laravel 11', 'Lumen', 'Neo4j', 'MySQL'],
                'highlights' => [
                    'Upgraded from Lumen → Laravel 9 → Laravel 11 across major version jumps.',
                    'Designed and optimized Neo4j queries over 25M+ records.',
                    'Led performance tuning to keep the system stable under heavy traffic.',
                ],
            ],
            [
                'title' => 'STC Inspection System',
                'category' => 'Oil & Gas',
                'summary' => 'Management system for inspectors: reports, job tickets, rigs and clients with multi-stage workflows and audit trails.',
                'tech_stack' => ['Laravel', 'Policies & Gates', 'Laravel Echo', 'Pusher', 'Laravel Excel'],
                'highlights' => [
                    'RBAC with Laravel Policies and Gates for inspectors, admins and clients.',
                    'Dynamic filtered reports exportable to CSV / Excel / PDF.',
                    'Real-time notifications with Echo and Pusher.',
                    'Full audit trail and client dashboards.',
                ],
            ],
            [
                'title' => 'STC Exam System (Nile Future)',
                'category' => 'E-Learning',
                'summary' => 'Online exams and training certificates for the oil & gas sector, with QR-verified certificates.',
                'tech_stack' => ['Laravel', 'Excel Import', 'QR Codes'],
                'highlights' => [
                    'Bulk user import via Excel.',
                    'Customizable dynamic exams.',
                    'QR-code certificates with bulk extraction and reports.',
                ],
            ],
            [
                'title' => 'MLS Real Estate & Auction Platform',
                'category' => 'Real Estate',
                'summary' => 'Multiple Listing Service with live real-estate auctions over WebSockets and a multi-tenant architecture.',
                'tech_stack' => ['Laravel', 'WebSockets', 'Multi-tenancy'],
                'highlights' => [
                    'Live bidding with real-time updates.',
                    'Advanced filtering, location-based search and comparison.',
                    'Multi-tenant for government and private-sector stakeholders.',
                ],
            ],
            [
                'title' => 'Inventory ERP System',
                'category' => 'ERP · Accounting',
                'summary' => 'Inventory, accounting and reporting unified in one ERP, with Stripe subscriptions reconciled against the ledger.',
                'tech_stack' => ['Laravel', 'Stripe', 'MySQL'],
                'highlights' => [
                    'Real-time stock tracking and management.',
                    'Automated accounting modules and dynamic financial reports.',
                    'Recurring invoicing via Stripe subscriptions with webhook reconciliation.',
                ],
            ],
            [
                'title' => 'E-SHEF',
                'category' => 'E-Commerce',
                'summary' => 'E-commerce platform for food, herbs, seeds and spices across Egypt and the Arab world.',
                'tech_stack' => ['Laravel', 'Stripe', 'PayTabs'],
                'highlights' => [
                    'Stripe and PayTabs checkout flows.',
                    'Webhook-based payment confirmation keeping orders and inventory in sync.',
                ],
            ],
            [
                'title' => 'SWYYP Platform',
                'category' => 'Sports · Mobile',
                'summary' => 'Multi-role platform and mobile app for football players to track performance, join events and redeem prizes.',
                'tech_stack' => ['Laravel', 'REST API', 'Push Notifications'],
                'highlights' => [
                    'Admin and vendor dashboards for users, events and rewards.',
                    'Real-time prize catalogs and push notifications.',
                ],
            ],
            [
                'title' => 'FALAFINA',
                'category' => 'Restaurant',
                'summary' => 'Restaurant management: orders, menus, inventory and staff scheduling.',
                'tech_stack' => ['Laravel', 'MySQL'],
                'highlights' => ['Online and in-house ordering.', 'Real-time stock with automated reordering.'],
            ],
            [
                'title' => 'BAWARQ',
                'category' => 'Oil & Gas',
                'url' => 'https://bawarq.org',
                'summary' => 'Oil & gas tools and inspection services platform — schedule inspections and track tool history.',
                'tech_stack' => ['Laravel', 'MySQL'],
                'highlights' => ['Inspection scheduling and tool condition tracking.', 'Maintenance schedules and certifications.'],
            ],
            [
                'title' => 'MAHARAT',
                'category' => 'E-Learning',
                'summary' => 'Professional development and skills-training platform with course management and progress tracking.',
                'tech_stack' => ['Laravel', 'MySQL'],
                'highlights' => ['Course management and registration.', 'Learning progress tracking.'],
            ],
            [
                'title' => 'SHELLY',
                'category' => 'IoT',
                'summary' => 'Smart-home automation platform for Wi-Fi and Bluetooth devices.',
                'tech_stack' => ['Laravel', 'IoT'],
                'highlights' => ['Device control for lighting, security and appliances.'],
            ],
            [
                'title' => 'SITEWORK',
                'category' => 'Corporate',
                'summary' => 'Website for a landscaping company specialising in irrigation networks, sports fields and pools.',
                'tech_stack' => ['Laravel'],
                'highlights' => ['Service catalogue and project showcase.'],
            ],
            [
                'title' => 'ORCHIDIAPHARMA',
                'category' => 'Pharma',
                'summary' => 'Pharmaceutical product catalogue with search and customer support features.',
                'tech_stack' => ['Laravel'],
                'highlights' => ['Product catalogue with search.', 'Contact and support forms.'],
            ],
        ];

        foreach ($projects as $i => $project) {
            Project::create($project + ['sort_order' => $i]);
        }

        $skills = [
            'Backend & Frameworks' => ['PHP', 'Laravel', 'Livewire', 'Inertia.js', 'Filament', 'Alpine.js', 'OOP', 'SOLID', 'Clean Architecture', 'Repository Pattern', 'Service Layer', 'REST API Design'],
            'Fintech & Payments' => ['Stripe API', 'PayTabs', 'Webhooks', 'Subscriptions', 'Recurring Payments', 'Dynamic Invoicing', 'ETA E-Invoicing', 'PCI-DSS Awareness'],
            'Databases' => ['MySQL', 'PostgreSQL', 'Neo4j', 'NoSQL', 'Query Optimization', 'Indexing'],
            'Caching & Queues' => ['Redis', 'Laravel Queues', 'Delayed Jobs', 'Background Jobs'],
            'Testing' => ['PHPUnit', 'Pest', 'TDD', 'Automated Testing'],
            'DevOps & Cloud' => ['Linux', 'Docker', 'Azure Pipelines', 'AWS', 'Azure', 'cPanel / WHM'],
            'Frontend' => ['JavaScript', 'jQuery', 'Ajax', 'Bootstrap', 'Tailwind CSS'],
            'Leadership' => ['Technical Leadership', 'Architecture Design', 'Code Reviews', 'Mentoring', 'Agile / SDLC'],
        ];

        $i = 0;
        foreach ($skills as $name => $items) {
            SkillGroup::create(['name' => $name, 'items' => $items, 'sort_order' => $i++]);
        }

        Education::create([
            'type' => 'degree',
            'title' => 'B.Sc. in Computer Science',
            'institution' => 'Fayoum University — Faculty of Science',
            'period' => '2015 — 2019',
            'sort_order' => 0,
        ]);

        Education::create([
            'type' => 'certification',
            'title' => 'Building Web Applications using PHP & MySQL',
            'institution' => 'Information Technology Institute (ITI)',
            'period' => '2022',
            'sort_order' => 1,
        ]);
    }
}
