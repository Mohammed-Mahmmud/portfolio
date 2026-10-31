<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\SkillGroup;
use Database\Seeders\Concerns\UpsertsProjects;
use Illuminate\Database\Seeder;

/**
 * Adds Egypt ETA and Saudi ZATCA e-invoicing to the skills, the "What I Do" cards
 * and the projects list (one ETA e-invoicing & billing project, one ZATCA Phase 2 project).
 *
 * Safe to run on live data and safe to re-run: it only adds or updates these
 * specific entries and never deletes anything else.
 *
 * php artisan db:seed --class=EInvoicingSeeder --force
 */
class EInvoicingSeeder extends Seeder
{
    use UpsertsProjects;

    private const GROUP = 'E-Invoicing & Tax Compliance';

    private const CARD = 'E-Invoicing Compliance';

    private const ETA_SLUG = 'egypt-eta-e-invoicing';

    private const PROJECT_SLUG = 'zatca-e-invoicing-integration';

    public function run(): void
    {
        $this->seedSkillGroup();
        $this->seedExpertiseCard();
        $this->seedEtaProject();
        $this->seedZatcaProject();
    }

    private function seedSkillGroup(): void
    {
        $items = [
            'Egypt ETA E-Invoicing',
            'ETA e-Receipt',
            'CAdES-BES Signing (USB Token)',
            'GS1 / EGS Item Coding',
            'Saudi ZATCA Phase 2 (FATOORA)',
            'B2B Clearance',
            'B2C Reporting',
            'CSID Onboarding (CSR / OTP)',
            'ECDSA Invoice Signing',
            'UBL 2.1 XML',
            'Invoice Hash Chain (PIH / ICV)',
            'QR Codes (TLV)',
            'Simulation & Production',
        ];

        $fintech = SkillGroup::query()->where('name', 'Fintech & Payments')->first();

        // ETA now lives in its own group; drop the duplicate from Fintech.
        if ($fintech) {
            $fintech->update([
                'items' => array_values(array_filter($fintech->items ?? [], fn (string $item) => ! str_contains($item, 'ETA'))),
            ]);
        }

        $group = SkillGroup::query()->firstWhere('name', self::GROUP);

        if ($group) {
            $group->update(['items' => $items]);

            return;
        }

        // Place it right after Fintech & Payments, shifting the groups below it down.
        $position = $fintech ? $fintech->sort_order + 1 : (int) SkillGroup::query()->max('sort_order') + 1;
        SkillGroup::query()->where('sort_order', '>=', $position)->increment('sort_order');

        SkillGroup::create([
            'name' => self::GROUP,
            'items' => $items,
            'sort_order' => $position,
            'is_visible' => true,
        ]);
    }

    private function seedExpertiseCard(): void
    {
        $profile = Profile::query()->first();

        if (! $profile) {
            return;
        }

        $card = [
            'icon' => 'receipt',
            'title' => self::CARD,
            'description' => 'Egypt ETA e-invoices and e-receipts with signed documents and GS1/EGS coding, plus Saudi ZATCA Phase 2 — B2B clearance and B2C reporting, live in simulation and production.',
        ];

        $expertise = collect($profile->expertise ?? [])
            ->reject(fn (array $item) => ($item['title'] ?? null) === self::CARD)
            ->values();

        // Keep it right after the payments card it relates to, or at the end.
        $paymentsIndex = $expertise->search(fn (array $item) => str_contains($item['title'] ?? '', 'Payments'));
        $insertAt = $paymentsIndex === false ? $expertise->count() : $paymentsIndex + 1;

        $profile->update([
            'expertise' => $expertise->take($insertAt)->push($card)->concat($expertise->slice($insertAt))->values()->all(),
        ]);
    }

    private function seedEtaProject(): void
    {
        $this->upsertProject(self::ETA_SLUG, after: 'multi-tenant-erp-system', content: [
            'title' => 'Egypt ETA E-Invoicing & Billing',
            'category' => 'Fintech · E-Invoicing',
            'summary' => 'Egyptian Tax Authority (ETA) e-invoice and e-receipt integration inside the ERP\'s billing module — signed documents, GS1/EGS item coding, recurring invoicing and online invoice settlement.',
            'tech_stack' => ['Laravel', 'ETA E-Invoicing API', 'ETA e-Receipt', 'CAdES-BES Signing', 'GS1 / EGS', 'Stripe', 'PayTabs'],
            'highlights' => [
                'Integrated the ERP with Egypt\'s Tax Authority (ETA) e-invoicing system for compliant electronic invoices.',
                'Digitally signed e-invoice documents (CAdES-BES) through the ETA signing tool using a USB token / e-seal.',
                'Integrated ETA e-Receipts for B2C sales alongside B2B e-invoices.',
                'Mapped ERP items to GS1 / EGS item codes and the matching ETA tax types and activity codes.',
                'Built company self-registration with tax-based discount logic for companies holding a valid tax registration number, backed by the ETA integration.',
                'Automated recurring billing and dynamic invoicing schedules for subscription-based company plans.',
                'Linked payment status with the ERP\'s financial and ETA e-invoicing records for compliance and auditability.',
                'Enabled online invoice settlement through Stripe and PayTabs from the billing module.',
                'Built idempotent webhook handlers so every payment event updates its invoice exactly once.',
            ],
        ]);
    }

    private function seedZatcaProject(): void
    {
        $this->upsertProject(self::PROJECT_SLUG, after: self::ETA_SLUG, content: [
            'title' => 'ZATCA E-Invoicing Integration',
            'category' => 'Fintech · E-Invoicing',
            'summary' => 'Saudi ZATCA (FATOORA) Phase 2 integration covering B2B clearance and B2C reporting, taken from onboarding in the simulation environment through to production.',
            'tech_stack' => ['Laravel', 'ZATCA FATOORA API', 'UBL 2.1 XML', 'ECDSA (secp256k1)', 'QR Codes (TLV)'],
            'highlights' => [
                'Onboarded EGS units end to end: generated CSRs, used FATOORA OTPs to obtain compliance CSIDs, passed the compliance checks and issued production CSIDs.',
                'B2B standard tax invoices sent through the Clearance API, so buyers only receive invoices that ZATCA has approved.',
                'B2C simplified invoices signed locally and submitted through the Reporting API within the 24-hour window.',
                'Generated UBL 2.1 XML for invoices, credit notes and debit notes, signed with ECDSA (secp256k1) cryptographic stamps.',
                'Chained every document with the previous invoice hash (PIH), an invoice counter (ICV) and a UUID for full traceability.',
                'Built Phase 2 QR codes (TLV, Base64) carrying the invoice hash, signature and public key.',
                'Ran the full flow in ZATCA\'s simulation environment before switching the same integration to production.',
                'Parsed ZATCA validation results — errors and warnings — and surfaced them for correction.',
            ],
        ]);
    }
}
