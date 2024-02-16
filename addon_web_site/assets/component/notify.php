<div id='note_box' class="alert alert-success alert-dismissible fade show" role="alert" style='background-color: aqua; z-index: 100000; display: none; position: fixed; width: 350px; min-height: 55px; left: 22px; bottom: 10px; text-align: left; border: 1px solid black;'>
    <p id='note_message' style='color: rgb(0, 0, 0); margin: 3px; font-weight: bold;  text-shadow: 1px 1px 1px #FFFFFF; filter: dropshadow(color=#FFFFFF, offx=1, offy=1);'></p>
</div>
<script>
    function throw_message(str) {
        $('#note_message').html(str);
        $("#note_box").fadeIn(500).delay(3000).fadeOut(500);
    }
</script>