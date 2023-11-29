<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
  <style>
    @page { size: 80mm 210mm } /* output size */
    body.receipt .sheet { width: 80mm; height: 210mm; font-size: 12pt;} /* sheet size */
    @media print { body.receipt { width: 80mm } } /* fix for Chrome */
  </style>
</head>

<body class="receipt">
  <section class="sheet">
    <div style="margin-bottom: 7mm;">
        <strong style="font-size: 18pt;"> {{ $work->client }} </strong>
        <br>
        [# {{ $work->id }} ] - {{ date("d/m/Y - H:i") }}
    </div>
    <div style="border: 2px solid black; padding: 1mm; margin-bottom: 7mm;">
        {{ $work->description }}
    </div>
    @if($work->note)
        <strong>Napomena:</strong>
        <div style="border: 2px solid black; padding: 1mm; margin-bottom: 7mm;">
        <i>{{ $work->note }}</i>
        </div>
    @endif
    @if($work->partner)
        <p><strong>Outsourced to:</strong> {{ $work->partner->name }}</p>
    @endif
    @if($work->outsourced_price)
      <p><strong>Outsource price:</strong> {{ $work->outsourced_price }} €</p>
    @endif
    @if($work->price)
        <p><strong>Cijena:</strong> {{ $work->price }} €</p>
    @endif
  </section>
  <script type="text/javascript">
    window.print();
    window.onfocus=function(){ window.close();}
  </script>
</body>
</html>
