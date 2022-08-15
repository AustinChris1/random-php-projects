<?php
include "header.php"
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<button id="but" class="btn btn-primary">Button</button>
<div id="test">
    <p class="p">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus harum autem commodi, debitis at quos architecto
        quidem. Iusto, omnis tempora? Minus, non? Exercitationem voluptatibus vitae, aliquid omnis impedit sapiente
        distinctio optio et dolor deserunt dicta quam maxime fugiat ab molestiae repellat culpa. Molestiae consequuntur
        velit autem, optio facilis sed fuga.
    </p>
</div>
<!-- <button id="but" class="btn btn-primary">Fake Button</button> -->

<script>
$(document).ready(function() {
    $("#but").click(function() {
        ("#but").hide();
    });
});
</script>
</body>

</html>