<script type="text/javascript">
    $('textarea#inputCiri').keyup(function() {
        var characterCount = $(this).val().length,
            current_count = $('#current_count_ciri'),
            maximum_count = $('#maximum_count_ciri'),
            count = $('#countCiri');
            current_count.text(characterCount);
    });
</script>
<script type="text/javascript">
    $('textarea#inputKronologi').keyup(function() {
        var characterCount = $(this).val().length,
            current_count = $('#current_count_kronologi'),
            maximum_count = $('#maximum_count_kronologi'),
            count = $('#countKronologi');
            current_count.text(characterCount);
    });
</script>
<script type="text/javascript">
    $('textarea#inputAlamat').keyup(function() {
        var characterCount = $(this).val().length,
            current_count = $('#current_count_alamat'),
            maximum_count = $('#maximum_count_alamat'),
            count = $('#countAlamat');
            current_count.text(characterCount);
    });
</script>
