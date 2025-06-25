@extends('layouts.landing')
@section('content')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script type="text/javascript">
        window.onload = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '/transaction/success';
                },
                onPending: function(result) {
                    window.location.href = '/transaction/pending';
                },
                onError: function(result) {
                    alert('Payment error');
                    console.log(result);
                }
            });
        }
    </script>
@endsection
