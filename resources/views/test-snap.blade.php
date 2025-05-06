<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Checkout Test Snap</title>

    {{-- 1) Load jQuery via HTTPS --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- 2) Load Snap.js, ambil client key dari config --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body>
    <h2>Midtrans Snap Sandbox Test</h2>

    <form id="payment-form" method="post" action="/snapfinish">
        @csrf
        <input type="hidden" name="result_type" id="result-type">
        <input type="hidden" name="result_data" id="result-data">
    </form>

    <button id="pay-button">Pay!</button>

    <script>
        $('#pay-button').on('click', function(e) {
            e.preventDefault();
            $(this).attr('disabled', true);

            $.ajax({
                url: '/snaptoken',
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(token) {
                    console.log('Snap token = ' + token);
                    snap.pay(token, {
                        onSuccess: function(result) {
                            $('#result-type').val('success');
                            $('#result-data').val(JSON.stringify(result));
                            $('#payment-form').submit();
                        },
                        onPending: function(result) {
                            $('#result-type').val('pending');
                            $('#result-data').val(JSON.stringify(result));
                            $('#payment-form').submit();
                        },
                        onError: function(result) {
                            $('#result-type').val('error');
                            $('#result-data').val(JSON.stringify(result));
                            $('#payment-form').submit();
                        }
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Gagal generate token:\n' + (xhr.responseJSON?.error || xhr.statusText));
                    $('#pay-button').removeAttr('disabled');
                }
            });
        });
    </script>
</body>

</html>
