<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\PageSection;
use App\Services\PortalContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function __construct(
        protected PortalContentService $portalService
    ) {}

    public function index(): View
    {
        return view('portal.index', $this->portalService->getPortalPayload());
    }

    public function sitemap(): Response
    {
        $lastMod = PageSection::max('updated_at') ?: now();
        $lastModIso = \Illuminate\Support\Carbon::parse($lastMod)->toAtomString();
        $baseUrl = rtrim(url('/'), '/');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= '    <url>' . "\n";
        $xml .= '        <loc>' . e($baseUrl . '/') . '</loc>' . "\n";
        $xml .= '        <lastmod>' . $lastModIso . '</lastmod>' . "\n";
        $xml .= '        <changefreq>weekly</changefreq>' . "\n";
        $xml .= '        <priority>1.0</priority>' . "\n";
        $xml .= '    </url>' . "\n";
        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function robots(): Response
    {
        $sitemapUrl = rtrim(url('/'), '/') . '/sitemap.xml';

        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /admin/',
            'Disallow: /login',
            '',
            'Sitemap: ' . $sitemapUrl,
        ];

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    public function storeLead(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        $lead = $this->portalService->createLead($request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Sua solicitação foi registrada com sucesso! Nossa equipe executiva entrará em contato.',
                'lead' => [
                    'id' => $lead->id,
                    'name' => $lead->name,
                ],
            ]);
        }

        return redirect()->to(url()->previous() . '#contato')
            ->with('lead_success', 'Sua solicitação foi registrada com sucesso! Nossa equipe executiva entrará em contato em breve.');
    }
}
