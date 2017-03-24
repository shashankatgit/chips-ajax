<!DOCTYPE html>
<html>
    <head>
        <title>ChipSkills</title>

        <link href="/webassets/bootstrap.css" rel="stylesheet" type="text/css">

        <style>

        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
            </div>
        </div>

    <script type="text/javascript">
        <script type="text/javascript">
                function fill(Value)
                {
                    $('#name').val(Value);
                    $('#display').hide();
                }

        $(document).ready(function(){
            $("#name").keyup(function() {
                var name = $('#name').val();
                if(name=="")
                {
                    $("#display").html("");
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: "name="+ name ,
                        success: function(html){
                            $("#display").html(html).show();
                        }
                    });
                }
            });
        });
    </script>
    </script>
    </body>
</html>
