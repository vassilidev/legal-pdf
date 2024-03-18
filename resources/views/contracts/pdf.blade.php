{!! Blade::render(setting('pdf.contract'), [
    'contract' => $contract,
    'answers' => $answers ?? [],
    'order' => $order ?? null
]) !!}
