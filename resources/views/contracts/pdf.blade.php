<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $contract->name }}</title>
    <style>
        body {
            font-family: "Arial", sans-serif !important;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

    @stack('css')
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
<body>
<main>
    {!! $contract->render($answers ?? [], $order ?? null) !!}
</main>

@if(!isset($disablePageNumbers))
    <script type="text/php">
        if (isset($pdf)) {
            $text = "{PAGE_NUM}/{PAGE_COUNT}";

            $size = 10;

            $font = $fontMetrics->getFont("Verdana");

            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;

            $x = $pdf->get_width() - 50;
            $y = $pdf->get_height() - 35;

            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
@endif

</body>
</html>