<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '{{ route("reloadCaptcha") }}',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
