<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<br><br><br>
<hr>
<div class="row m-auto">
    <div class="col-6 m-auto">
        <table class="table m-auto">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">subject</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="col-4 m-auto">
        <span id="addT">Add Teacher</span>
        <span id="updateT">update Teacher</span>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
                <div id="nameError" class="form-text text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" aria-describedby="emailHelp">
                <div id="subjectError" class="form-text text-danger"></div>
            </div>
            <input type="hidden" id="id">
            <button type="submit" class="btn btn-primary" onclick="addData()" id="add">Add</button>
            <button type="submit" class="btn btn-primary" onclick="updateData()" id="update">Update</button>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

<script>
    $('#addT').show();
    $('#add ').show();

    $('#updateT').hide();
    $('#update').hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    //get all data from teacher table
    function allData(){
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/teacher/all",
            success:function (respone){
                var data = '';
                $.each(respone ,function (key,value){
                    data = data + "<tr>"
                    data = data + "<td>"+value.id+"</td>"
                    data = data + "<td>"+value.name+"</td>"
                    data = data + "<td>"+value.subject+"</td>"
                    data = data + "<td>"
                    data = data + "<button class='btn btn-sm btn-primary m-2' onclick='editData("+value.id+")'>Edit</button>"
                    data = data + "<button class='btn btn-sm btn-danger m-2' onclick='deleteData("+value.id+")'>Delete</button>"
                    data = data + "</td>"
                    data = data + "</tr>"
                })
                $('tbody').html(data);
            }
        })
    }
    allData();

    //clear data after add in form
    function clearData(){
            $('#name').val('');
            $('#subject').val('');
            $('#nameError').text('');
            $('#subjectError').text('');

    }

    //add data to table teacher
    function addData(){

        var name = $('#name').val();
        var subject = $('#subject').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {name:name , subject:subject},
            url:"/teacher/store",
            success:function (data){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Teacher add successfully'
                })
                clearData();
                allData();
            },
            error:function (error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#subjectError').text(error.responseJSON.errors.subject);
            }
        })
    }

    //edit data in database by same form
    function editData(id){
        $.ajax({
            type:"GET",
            dataType:"json",
            url:'/teacher/edit/'+id,
            success:function (data){
                $('#addT').hide();
                $('#add ').hide();

                $('#updateT').show();
                $('#update').show();

                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#subject').val(data.subject);
            }
        })
    }


    // update data in database
    function updateData(){
        var id = $('#id').val();
        var name = $('#name').val();
        var subject = $('#subject').val();

        $.ajax({
            type: "POST",
            dataType: "json",
            data :{name : name , subject:subject},
            url: "/teacher/update/"+id,
            success:function (data){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'update successfully'
                })
                $('#addT').show();
                $('#add ').show();
                $('#updateT').hide();
                $('#update').hide();

                clearData();
                allData();
            },
            error:function (error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#subjectError').text(error.responseJSON.errors.subject);
            }
        })
    }

    function deleteData(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:"GET",
                    dataType:"json",
                    url:"/teacher/delete/"+id,
                    success: function (data){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'delete teacher successfully'
                        })
                        clearData();
                        allData();
                    }
                })
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })

    }
</script>
</body>
</html>

