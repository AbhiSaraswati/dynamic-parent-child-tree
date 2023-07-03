<?php
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #projectIDSelectError1,
        #projectIDSelectError2 {
            color: red;
            font-size: 14px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
   <?php
        readfile('readFile.txt')

        ?>
    <div id="categoriesContainer"></div>

    <button type="button" onclick="clearForm();" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add Member
    </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="inputForm" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="">Parent</label>
                        <select class="form-select" id="parentCat" name="parentCat" aria-label="Default select example">
                            <option value="">Select Parent</option>
                            <?php
                            $sqlData = "Select * from members";
                            $result = mysqli_query($con, $sqlData);
                            while ($cat = mysqli_fetch_array($result)) {
                            ?> <option value="<?php echo $cat['id']; ?>"><?php echo $cat['Name']; ?></option> <?php } ?>
                        </select>
                        <p id="projectIDSelectError1"></p>
                        <br>
                        <label for="">Name</label>
                        <input type="text" onkeydown="return /[a-z ]/i.test(event.key)" id="childName" name="catName" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        <p id="projectIDSelectError2"></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="saveChild();" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        var data = {};
        $(document).ready(function() {
            // alert();
            showTree();
            $("#categoriesContainer").show();

            $('#inputForm').validate({
                rules: {
                    parentCat: "required",
                    catName: "required",
                },
                messages: {
                    parentCat: "Choose a valid Parent",
                    catName: "This field is required",
                },

                errorPlacement: function(error, element) {

                    if (element.attr("name") == "parentCat") {
                        error.appendTo('#projectIDSelectError1');

                    } else if (element.attr("name") == "catName") {
                        error.appendTo('#projectIDSelectError2');
                    } else {
                        error.insertAfter(element);
                    }
                },

            })
        });

        function clearForm() {
            $("#inputForm")[0].reset();
        }

        function saveChild() {
            if ($('#inputForm').valid()) {
                data['parentName'] = $("#parentCat").val();
                data['childName'] = $("#childName").val();
                $.ajax({
                    url: "addChild.php",
                    type: "POST",
                    data: data,
                    cache: false,
                    success: function(result) {
                        if (result == '1') {
                            $(".close").click();
                            showTree()
                        }
                    }
                });
            }
        }

        function showTree() {
            data['parentId'] = 0;
            $.ajax({
                url: 'getCategories.php',
                method: 'POST',
                data: data,
                success: function(response) {
                    var categories = $(response);
                    $('#categoriesContainer').empty();
                    $('#categoriesContainer').append(categories);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
</body>

</html>