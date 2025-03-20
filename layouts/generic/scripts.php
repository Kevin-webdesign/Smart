<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#capture_fingerprint").click(function(){
            $.ajax({
                url: "{% url 'get_fingerprint' %}",  
                type: "GET",
                success: function(response){
                    if(response.fingerprint_id) {
                        $("#id_fingerprint").val(response.fingerprint_id);
                    } else {
                        alert("No fingerprint detected. Try again.");
                    }
                },
                error: function() {
                    alert("Error capturing fingerprint. Check your connection.");
                }
            });
        });
    });
</script>