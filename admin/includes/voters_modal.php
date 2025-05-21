<!-- Add New Voter Modal -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
      <div class="modal-header">
        <button type="button" class=" btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Add New Voter</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="voters_add.php">
          <div class="form-group">
            <label for="nim" class="col-sm-3 control-label">NIM</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
          </div>
          <div class="form-group">
            <label for="fullname" class="col-sm-3 control-label">Full Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-curve pull-left" style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-primary btn-curve" style='background-color:  #9CD095  ;color:black ; font-size: 12px; font-family:Times' name="add"><i class="fa fa-save"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Voter Modal -->
<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
      <div class="modal-header">
        <button type="button" class=" btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Edit Voter</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="voters_edit.php" enctype="multipart/form-data">
          <input type="hidden" class="id" name="id">
          <div class="form-group">
            <label for="edit_nim" class="col-sm-3 control-label">NIM</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_nim" name="nim" required>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_fullname" class="col-sm-3 control-label">Full Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="edit_fullname" name="fullname" required>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="edit_email" name="email" required>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_photo" class="col-sm-3 control-label">Photo</label>
            <div class="col-sm-9">
              <input type="file" class="form-control" id="edit_photo" name="photo">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_verified" class="col-sm-3 control-label">Verified</label>
            <div class="col-sm-9">
              <input type="checkbox" id="edit_verified" name="verified">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-curve pull-left" style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-curve" style='background-color:  #9CD095 ;color:black ; font-size: 12px; font-family:Times' name="edit"><i class="fa fa-check-square-o"></i> Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Password Modal -->
<div class="modal fade" id="editPassword">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
      <div class="modal-header">
        <button type="button" class=" btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Edit Password</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="voters_edit_password.php">
          <input type="hidden" class="id" name="id">
          <div class="form-group">
            <label for="edit_password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="edit_password" name="password" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-curve pull-left" style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-curve" style='background-color:  #9CD095 ;color:black ; font-size: 12px; font-family:Times' name="editPassword"><i class="fa fa-check-square-o"></i> Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Voter Modal -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #d8d1bd ;color:black ; font-size: 15px; font-family:Times ">
      <div class="modal-header">
        <button type="button" class=" btn btn-close btn-curve pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Deleting...</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="voters_delete.php">
          <input type="hidden" class="id" name="id">
          <div class="text-center">
            <p>DELETE VOTER</p>
            <h2 class="bold fullname"></h2>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-curve pull-left" style='background-color:  #FFDEAD  ;color:black ; font-size: 12px; font-family:Times' data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-danger btn-curve" style='background-color:  #ff8e88  ;color:black ; font-size: 12px; font-family:Times' name="delete"><i class="fa fa-trash"></i> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
