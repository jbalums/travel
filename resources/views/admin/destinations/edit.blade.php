<div class="modal-dialog modal-lg add-user-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Edit Destination</h4>
    </div>
 
 
    {!! Form::open(array('url' => url('admin/destinations/'.$destination->id), 'enctype' => 'multipart/form-data', 'method' => 'PATCH', 'id' => 'edit-destinations-form', 'files' => true)) !!}
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" autocomplete="false" value="{{ $destination->name }}">
          <span class="help-text text-danger"></span>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Description">{{ $destination->description }}</textarea> 
          <span class="help-text text-danger"></span>
        </div>   

        <div class="form-group">
            <label for="name">Image</label>
            <div class="col-md-12 text-center">
                @if($destination->image)
                <img src="{{ asset('storage/'.ltrim($destination->image,'public')) }}" align="img" style=" height: 150px; display: inline-block; float: none;box-shadow: 0px 0px 0px 2px #eee;background: #fff;" id="prev_img2">
                @else
                <img src="{{ url('images/img_holder.png') }}" align="img" style=" height: 150px; display: inline-block; float: none;box-shadow: 0px 0px 0px 2px #eee;background: #fff;" id="prev_img2">
                @endif
            </div>
            <div class="col-md-12 text-center  mb-1">
                <input type="file" name="image" id="image" class="image input_image" style="display: none;">
                <label class="mt-1" >
                    <div class="btn btn-success upload_btn">Upload Photo</div>
                </label>
          <span class="help-text text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="link">Destination Website Link</label>
            <input type="text" class="form-control" id="link" name="link" placeholder="Enter link" autocomplete="false" value="{{ $destination->link }}">
          <span class="help-text text-danger"></span>
        </div>
        <div class="form-group">
            <label for="long">Longitude</label>
            <input type="text" class="form-control" id="long" name="long" placeholder="Enter longitude" autocomplete="false" value="{{ $destination->long }}">
          <span class="help-text text-danger"></span>
        </div>
        <div class="form-group">
            <label for="lat">Lattude</label>
            <input type="text" class="form-control" id="lat" name="lat" placeholder="Enter latitude" autocomplete="false" value="{{ $destination->lat }}">
          <span class="help-text text-danger"></span>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        {!! Form::submit('Submit', ['class' => 'btn submit-btn btn-primary btn-gradient pull-right']) !!}
      {!! Form::close() !!}
    </div>

  </div>
</div>

 
<script type="text/javascript">
  $(function(){ 

    $(document).off('click', '.upload_btn').on('click', '.upload_btn', function(){
        $('.input_image').click(); 
    });

    $(document).off('change',  '#image').on('change',  '#image', function(evt){
        var tgt = evt.target || window.event.srcElement,
            files = tgt.files; 
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById('prev_img2').src = fr.result;
                $('.upload_btn').html('Change Photo');
            }
            fr.readAsDataURL(files[0]);
        } 
        else { 
        }
    });
      $("#edit-destinations-form").on('submit', function(e){
        e.preventDefault(); //keeps the form from behaving like a normal (non-ajax) html form
        var $form = $(this);
        var $url = $form.attr('action');
        var formData = new FormData($("form#edit-destinations-form")[0]); 
        //submits an array of key-value pairs to the form's action URL
     /*   $.post(url, formData, function(response)
        {
            //handle successful validation
            alert(1);
        }).fail(function(response)
        {
            //handle failed validation
            alert(1);
            associate_errors(response['errors'], $form);
        });*/

        $.ajax({
          type: 'POST',
          url: $url,
          data: formData,
          processData: false,
          contentType: false,
          success: function(result){
            if(result.success){
              swal({
                  title: result.msg,
                  icon: "success"
                });
            }else{
              swal({
                  title: result.msg,
                  icon: "error"
                });
            }
            $("#destinations-table").DataTable().ajax.url( '/admin/get-destinations' ).load();
            $('.modal').modal('hide');
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });
  });  
 </script> 