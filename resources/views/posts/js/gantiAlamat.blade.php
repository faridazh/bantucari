<script type="text/javascript">
    var isiAddressCheckbox = document.getElementById("checkIsiAddress");

    var namaPelaporInput = document.getElementById("inputNamaPelapor");
    var tlpPelapor = document.getElementById("inputTlpPelapor");
    var mailPelaporInput = document.getElementById("inputEmail");
    var alamatPelaporInput = document.getElementById("inputAlamat");

    isiAddressCheckbox.addEventListener("change", function(event) {
            if (event.target.checked) {
                namaPelaporInput.disabled = false;
                tlpPelapor.disabled = false;
                mailPelaporInput.disabled = false;
                alamatPelaporInput.disabled = false;
            } else {
                namaPelaporInput.disabled = true;
                tlpPelapor.disabled = true;
                mailPelaporInput.disabled = true;
                alamatPelaporInput.disabled = true;
            }
        }, false
    );
</script>
