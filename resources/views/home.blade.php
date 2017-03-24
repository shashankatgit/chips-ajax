<!DOCTYPE html>
<html>
<head>
    <title>ChipSkills</title>

    <link href="webassets/bootstrap.css" rel="stylesheet" type="text/css">

    <style>
        .chip {
            display: inline-block;
            padding: 0 5px;
            height: 20px;
            font-size: 14px;
            line-height: 20px;
            border-radius: 10px;
            background-color: #f1f1f1;
        }

        .closebtn {
            padding-left: 10px;
            color: #888;
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

        <div style="margin:auto;border:2px solid #646280; height:100px">
            <h5 align="center"><b>Skills</b></h5>
            <div id="chips-container">
                {{--sample chip code--}}
                {{--<div class="chip">--}}
                    {{--Shopping--}}
                    {{--<span class="closebtn" onclick="this.parentElement.style.display='none'">&times</span>--}}
                {{--</div>--}}
            </div>

        </div>

        <div style="margin-top: 20px">
            <div style="width:400px;margin:auto">
                <p align="center"> Enter Skill </p>
                <div style="margin:20px">
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

    </div>


</div>


<script src="webassets/jquery-3.2.0.min.js"></script>
<script type="text/javascript">

    var selectedSkills=[];

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
                        var html = '<li onclick="addToChips(this)">' + matches[i].skill + '</li>';
                        $('#display').append(html);
                    }

                    $('#display').show();
                });
            }
        });
    });
</script>

<script type="text/javascript">
    function addToChips(elem) {
        var skill = elem.innerHTML;
        console.log('Trying to add "' + skill + '" to chips');
        html = '<div class="chip"> <span id="skill">' + skill + '</span>' +
                '<span class="closebtn" onclick="removeChip(this)">&times</span>' +
                '</div>';

        $('#chips-container').append(html);

        selectedSkills.push(skill);
        console.log('New skill bag status is '+JSON.stringify(selectedSkills));

        $('#display').html("").hide();
        $('#string').val('');

        addUpdatedJSONToForm();
    }

    function removeChip(elem) {

        var chipNode = elem.parentNode;
        var skill = chipNode.firstElementChild.innerHTML;
        console.log('Removing skill '+skill+' from Skill Bag')
        for(var i=0; i<selectedSkills.length; i++)
        {
            if(selectedSkills[i]==skill)
            {
                console.log('match mila');
                selectedSkills.splice(i,1);
                break;
            }
        }
        chipNode.parentNode.removeChild(chipNode);
        addUpdatedJSONToForm();
        console.log('New skill bag status is '+JSON.stringify(selectedSkills));
    }

    function addUpdatedJSONToForm() {
        json = JSON.stringify(selectedSkills);
        $('input[name="json"]').val(json);
    }
</script>

</body>
</html>
