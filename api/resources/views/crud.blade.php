<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>Laravel Crud</h1>
  <p>Simple crud</p> 
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-4">
        <form id="my_form">

          <div class="form-group">
            <label for="pwd">Firstname:</label>
            <input class="form-control" id="fname"  name="fname" require>
          </div>
            <div class="form-group">
            <label for="pwd">Lastname:</label>
            <input class="form-control" id="lname" name="lname" require>
          </div>
          <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" class="form-control" id="email" name="email" require/>
          </div>
      
          <button type="submit" class="btn btn-default">Submit</button>
        </form> 
    </div>
    <div class="col-sm-8">

      <table class="table" id="my_tbl">
        <thead>
          <tr>
            <th>Id</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

      <!-- modal -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
              <!-- ====================content================================================= -->
              <form id="editForm">
                <div class="form-group">
                  <label for="pwd">Firstname:</label>
                  <input type="hidden" class="form-control" id="_id"  name="id" require>
                  <input class="form-control" id="_fname"  name="fname" require>
                </div>
                <div class="form-group">
                  <label for="pwd">Lastname:</label>
                  <input class="form-control" id="_lname" name="lname" require>
                </div>
                <div class="form-group">
                  <label for="email">Email Address:</label>
                  <input type="email" class="form-control" id="_email" name="email" require/>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
              </form> 
              <!-- ===================================================================== -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <!-- ===== -->
      
    </div>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
      $.ajaxSetup({
          headers:
          { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      getData();


      $(document).on('submit','#my_form',function(e){
          e.preventDefault();
          // console.log($(this).serialize());
          $.ajax({
            url:"http://localhost/certgenerator/api/create",
            type:'post',
            dataType:'json',
            data:$(this).serialize(),
            success:function(res){
              console.log('add',res);
              $('#my_form')[0].reset();
              getData();
            }
          })
      })
    });


    function getData(){
      var td= '';
        $.ajax({
          url: "http://localhost/certgenerator/api/all",
          dataType:'json',
          type:'get',
          success:function(data){
            console.log('test',data);

            $.each(data.data,function(index,row){
              td +=`<tr>
                    <td>${row.id}</td>
                    <td>${row.fname}</td>
                    <td>${row.lname}</td>
                    <td>${row.email}</td>
                    <td>
                      <button 
                        data-id="${row.id}" 
                        data-fname="${row.fname}"
                        data-lname="${row.lname}"
                        data-email="${row.email}"
                        class="btn btn-info btn-edit">Edit</button>
                      <button data-id="${row.id}" class="btn btn-danger btn-delete">Delete</button>
                    </td>
                  </tr>`;
            });
            $('#my_tbl tbody').html(td);
          }
        })
    }

    $(document).on('click','.btn-edit',function(){
      var id,fname,lname,email;

      id = $(this).data('id');
      fname = $(this).data('fname');
      lname = $(this).data('lname');
      email = $(this).data('email');
      $('#_id').val(id)
      $('#_fname').val(fname)
      $('#_lname').val(lname)
      $('#_email').val(email)

      $('#myModal').modal();
    })

    $(document).on('submit','#editForm',function(e){
          e.preventDefault();
          var data = $(this).serialize();
          console.log(data);
          $.ajax({
            url:"http://localhost/certgenerator/api/modified",
            type:'post',
            dataType:'json',
            data:data,
            success:function(res){
              console.log('add',res);
              $('#editForm')[0].reset();
              $('#myModal').modal('hide');
              getData();
            }
          })
      })

      $(document).on('click','.btn-delete',function(){
        var id = $(this).data('id');
        var isOk = confirm("are you sure?")
        if(isOk){
          $.ajax({
            url:"http://localhost/certgenerator/api/remove/"+id,
            type:'post',
            success:function(res){
              console.log('add',res);
              getData();
            }
          })
        }
        console.log('test',id);
      })

    
</script>
