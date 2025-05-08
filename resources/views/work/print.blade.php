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
        [# {{ $work->id }} ] - {{ date("d.m.Y. - H:i") }}
    </div>
    <div style="border: 2px solid black; padding: 1mm; margin-bottom: 7mm;">
      {!! nl2br($work->description) !!}
    </div>
    @if($work->note && $type)
      <strong>Napomena:</strong>
      <div style="border: 2px solid black; padding: 1mm; margin-bottom: 7mm;">
        <i>{!! nl2br($work->note) !!}</i>
      </div>
    @endif
    @if($work->price)
    <div style="margin-bottom: 7mm;">
      <strong>Price:</strong> {{ $work->price }} € [{{ $work->payment_method }}]
    </div>
    @endif
    @if($work->partner && $type)
    <div style="text-align: center; border: 2px dotted black;">
      <strong>OUTSOURCE</strong> <br>
      <strong>{{ $work->partner->name }}</strong> for {{ $work->outsourced_price }} €
    </div>
    @endif
  </section>
  <script type="text/javascript">
    window.print();
    window.onfocus=function(){ window.close();}
  </script>
</body>
</html>