<!DOCTYPE html>
<html>
<head>
    <title>ChipSkills</title>

    <link href="webassets/bootstrap.css" rel="stylesheet" type="text/css">

    <style>
        .chip {
            display: inline-block;
            padding: 3px 6px;
            height: 27px;
            font-size: 14px;
            line-height: 25px;
            border-radius: 10px;
            background-color: #c7c7c1;
            margin:3px;
        }

        .closebtn {
            padding-left: 10px;
            color: #880809;
            font-weight: bold;
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .closebtn:hover {
            color: #000;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="container" style="width:50%;margin:auto;margin-top:20px;">
        <p align="center">Duplicate skills will automatically be filtered out at the server</p>
        <h5 align="center"><b>Skills</b></h5>
        <div style="margin:auto;border:2px solid #646280; height:120px">

            <div id="chips-container" style="padding:8px">
                {{--sample chip code--}}
                {{--<div class="chip">--}}
                {{--Shopping--}}
                {{--<span class="closebtn" onclick="this.parentElement.style.display='none'">&times</span>--}}
                {{--</div>--}}
            </div>

        </div>
    </div>

    <div style=" width:60%;max-width:400px;margin: auto;margin-top: 40px;">
        <div style="margin:auto">
            <p align="center"><b>Enter Skill <br>
                    (Pressing tab will add a new non-suggested skill to the skills bag)
                    <br> Click on suggested skills to add them
                    </b></p>
            <div id="search-container" style="margin:20px">
                <input class="form-control" type="text" name="string" id="string" autocomplete="off"
                       style="width: 100%">
                <div id="displayContainer" style="width: 100%;background-color: #74002a;color:white;;">
                    <ul id="display" style="list-style: none">

                    </ul>

                </div>
            </div>
        </div>

    </div>

    <div style="width:40px;margin: auto">
        <form id="skillsForm" method="post" action="{{route('chips.save')}}">
            {{--<input type="text" name="user_id" id="userIdFormField" value="1">--}}
            <input type="hidden" name="json" id="jsonToServerFormField">
            <button type="submit" class="btn btn-danger">Save</button>
        </form>

    </div>
    <br><br>
    <p align="center">
        Also check the debugger console to exactly know how it is working behind.
    </p>

</div>





<script src="webassets/jquery-3.2.0.min.js"></script>
<script type="text/javascript">

    var selectedSkills = [];

    function fill(Value) {
        $('#name').val(Value);
        $('#display').hide();
    }

    $(document).ready(function () {

        $("#string").keyup(function () {
            var string = $('#string').val();

            if (string == "") {
                $("#display").html("");
            }
            else {
                console.log('Searching for ' + string);
                $.getJSON('{{route('chips.fetch')}}', {'str': string}, function (result) {
                    console.log('json :: ' + JSON.stringify(result));
                    var matches = result.matches;
                    $("#display").html("");

                    for (i = 0; i < matches.length; i++) {
                        var html = '<li onclick="addToChips(\'elem\',this)">' + matches[i].skill + '</li>';
                        $('#display').append(html);
                    }

                    $('#display').show();
                });
            }
        });

        $("#search-container").on('keydown', '#string', function(e) {
            var keyCode = e.keyCode || e.which;

            if (keyCode == 9) {
                e.preventDefault();
                var skill = $('#string').val();
                addToChips('string', skill);

                $('#string').val('');
            }
        });
    });
</script>

<script type="text/javascript">
    function addToChips(type, param) {
        var skill;
        if(type=='elem')
            skill = param.innerHTML;
        else if (type=='string')
            skill = param;

        console.log('Trying to add "' + skill + '" to chips');
        html = '<div class="chip"> <span id="skill">' + skill + '</span>' +
                '<span class="closebtn" onclick="removeChip(this)">&times</span>' +
                '</div>';

        $('#chips-container').append(html);

        selectedSkills.push(skill);
        console.log('New skill bag status is ' + JSON.stringify(selectedSkills));

        $('#display').html("").hide();
        $('#string').val('');

        addUpdatedJSONToForm();
    }

    function removeChip(elem) {

        var chipNode = elem.parentNode;
        var skill = chipNode.firstElementChild.innerHTML;
        console.log('Removing skill ' + skill + ' from Skill Bag')
        for (var i = 0; i < selectedSkills.length; i++) {
            if (selectedSkills[i] == skill) {
                console.log('match mila');
                selectedSkills.splice(i, 1);
                break;
            }
        }
        chipNode.parentNode.removeChild(chipNode);
        addUpdatedJSONToForm();
        console.log('New skill bag status is ' + JSON.stringify(selectedSkills));
    }

    function addUpdatedJSONToForm() {
        json = JSON.stringify(selectedSkills);
        $('input[name="json"]').val(json);
    }


</script>

</body>
</html>
