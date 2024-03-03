<?php

namespace App\Http\Controllers;

use App\Actions\Orders\CreateOrderFromSubmission;
use App\Models\Contract;
use App\Models\Order;
use App\Models\User;
use App\Services\SurveyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JsonException;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class SurveyController extends Controller
{
    public function __construct(
        protected SurveyService $surveyService,
    )
    {
    }

    public function start(Contract $contract)
    {
        return view('backoffice.startContractForm', compact('contract'));
    }

    /**
     * @throws ApiErrorException
     * @throws JsonException
     */
    public function process(Request $request, Contract $contract): RedirectResponse
    {
        $submission = recursiveCollect(json_decode($request->get('submission'), true, 512, JSON_THROW_ON_ERROR));

        Validator::validate($submission->get('data')->toArray(), $this->surveyService->generateRules($contract->final_schema));

        $order = app(CreateOrderFromSubmission::class)->execute($submission, $contract);

        return to_route('order.payment-view', $order);
    }
}
