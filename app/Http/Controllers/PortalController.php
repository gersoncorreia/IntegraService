<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Services\PortalContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
