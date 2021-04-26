<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-compatible" content="ei=edge">
 	<title>ajax CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</head>
<body>
 <section style="padding-top:60px;">
 	<div class="container">
 		<div class="row">
 			<div class="col-md-12">
 				<div class="card">
 					<div class="card-header">
 						Students <a href="#" class="btn btn-success" data-toggle="modal" data-target="#studentModal">Add new Student</a>
 					</div>
 					<div class="card-body">
 						<table id="studentTable" class="table">
 							<thead>
 								<tr>
 									<th>First Name</th>
 									<th>Last Name</th>
 									<th>Email</th>
 									<th>Phone</th>
 									<th>Action</th>
 								</tr>
 							</thead>
 							<tbody>
 								@foreach ($students as $student)
 								<tr id="sid{{$student->id}}">
 									<td>{{$student->firstname}}</td>
 									<td>{{$student->lastname}}</td>
 									<td>{{$student->email}}</td>
 									<td>{{$student->phone}}</td>
 									<td>
 										<a href="javascript:void(0)" onclick="editStudent('{{$student->id}}')" class="btn btn-info">Edit</a>
 										<a href="javascript:void(0)" onclick="deleteStudent('{{$student->id}}')" class="btn btn-danger">Delete</a>
 									</td>
 								</tr>
 								@endforeach
 							</tbody>
 						</table>
 						<span>{{$students->links()}}</span>
 						    <style>
      .w-5{
        display: none;
      }
    </style>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </section>


<!--Add Student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="studentForm">
       	@csrf
       	<div class="form-group">
       		<label for="firstname">First Name</label>
       		<input type="text" class="form-control" id="firstname" required />
       	</div>
        <div class="form-group">
       		<label for="lastname">Last Name</label>
       		<input type="text" class="form-control" id="lastname" required />
       	</div>
       	<div class="form-group">
       		<label for="email">Email</label>
       		<input type="email" class="form-control" id="email" required />
       	</div>
       	<div class="form-group">
       		<label for="phone">Phone</label>
       		<input type="text" class="form-control" id="phone" required />
       	</div>
       	<button type="submit" class="btn btn-primary">Submit</button>
       </form>
      </div>
    </div>
  </div>
</div>

<!--Edit Student Modal -->
<div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="studentEditForm">
       	@csrf
       	<input type="hidden" id="id" name="id" />
       	<div class="form-group">
       		<label for="firstname">First Name</label>
       		<input type="text" class="form-control" id="firstname2" />
       	</div>
        <div class="form-group">
       		<label for="lastname">Last Name</label>
       		<input type="text" class="form-control" id="lastname2" />
       	</div>
       	<div class="form-group">
       		<label for="email">Email</label>
       		<input type="text" class="form-control" id="email2" />
       	</div>
       	<div class="form-group">
       		<label for="phone">Phone</label>
       		<input type="text" class="form-control" id="phone2" />
       	</div>
       	<button type="submit" class="btn btn-primary">Submit</button>
       </form>
      </div>
    </div>
  </div>
</div>

<!--ajax code for insert Student details -->
<script>
	$("#studentForm").submit(function(e){
		e.preventDefault();

		let firstname = $("#firstname").val();
		let lastname = $("#lastname").val();
		let email = $("#email").val();
		let phone = $("#phone").val();
		let _token = $("input[name=_token]").val();

		$.ajax({
             url: "{{route('student.add')}}",// this is the route name of addStudent method from controller
		     type:"POST",
		     data :{
                   firstname :firstname,
                   lastname: lastname,
                   email:email,
                   phone:phone,
                   _token:_token
		     },
		     success:function(response){
		     	if(response)
		     	{
		     		$("#studentTable tbody").prepend('<tr><td>'+response.firstname+'</td><td>'+response.lastname +'</td><td>'+response.email+'</td><td>'+response.phone+'</td></tr>');
		     		$("#studentForm")[0].reset();
		     		$("#studentModal").modal('hide');

		     	}
		     }
		});
	});
</script>


<!--ajax code for edit Student details -->
<script>
	function editStudent(id)
	{
		$.get('/students/'+id,function(student){ //students/id is getting from route for getStudentById method from controller
			$("#id").val(student.id); //#id is id from edit form of first input field 
			$("#firstname2").val(student.firstname);
			$("#lastname2").val(student.lastname);
			$("#email2").val(student.email);
			$("#phone2").val(student.phone);
			$("#studentEditModal").modal('toggle');//edit cheyanulla pop form show cheyan with form and values from database student table
		}); 
	}



	//ajax code for update the form with edit form id as StudentEditForm

	$("#studentEditForm").submit(function(e){
         e.preventDefault();
         let id = $("#id").val();// id from form tag with input type="hidden"
        let firstname = $("#firstname2").val();
		let lastname = $("#lastname2").val();
		let email = $("#email2").val();
		let phone = $("#phone2").val();
		let _token = $("input[name=_token]").val();


		$.ajax({
			url:"{{route('student.update')}}",
      method:"PUT",
			data:{
				         id:id,
				         firstname :firstname,
                 lastname: lastname,
                 email:email,
                 phone:phone,
                 _token:_token
			},
			success:function(response){
				$('#sid' + response.id +' td:nth-child(1)').text(response.firstname);//sid is the id from the table with second <tr> tag
			    $('#sid' + response.id +' td:nth-child(2)').text(response.lastname);
			    $('#sid' + response.id +' td:nth-child(3)').text(response.email);
			    $('#sid' + response.id +' td:nth-child(4)').text(response.phone);
			    $("#studentEditModal").modal('toggle');
			    $("#StudentEditForm")[0].reset();
			}

		});
	}) ;
</script>

<script>
	//ajax code for delete the record
	function deleteStudent(id)
	{
		if(confirm("do yo really want to delete this record?"))
		{
			$.ajax({
				url:'/students/'+id,//url from route delete
				type:'DELETE',
				data:{
					_token : $("input[name=_token]").val()
				},
				success:function(response)
				{
					$("#sid"+id).remove();//id from table <tr> tag
				}
			});
		}

	}
</script>
</body>
</html>