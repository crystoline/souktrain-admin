@if($message = session('message'))
    <script>
        $.toast({
            heading: 'Notification',
            text: '{{$message}}',
            position: 'top-right',
            loaderBg:'#fec107',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
        });
    </script>
@endif