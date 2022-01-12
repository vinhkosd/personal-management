<?php
validateLogin(true, false);//check account login
checkPermission("user", true);
?>
			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Nghỉ phép</a></li>
						<li class="breadcrumb-item active" aria-current="page">Quản lý</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<h6 class="card-title"><?php checkPermission("admin") ? "Quản lý nghỉ phép" : "Danh sách ngày nghỉ phép";?> </h6>
							<p class="card-description">
								<?php if (!checkPermission("god"))
								{
								?>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAbsent" data-phongban="">Đăng ký nghỉ phép</button>
								<?php
								}
								?>
                                <button type="button" class="btn btn-primary" id="reloadAbsentData">Tải lại</button>
                               
							</p>
                            <?php if (!checkPermission("god"))
								{
                            ?>
                                <span style="display:flex"> Tổng số ngày nghỉ phép : <strong style="padding: 0px 2px 0px 2px;" id="absent-max">...</strong> ngày</span>
                                <span style="display:flex"> Số ngày nghỉ phép đã sử dụng : <strong style="padding: 0px 2px 0px 2px;" id="absent-total">...</strong> ngày</span>
                                <span style="display:flex"> Số ngày nghỉ phép còn lại : <strong style="padding: 0px 2px 0px 2px;" id="absent-remain">...</strong> ngày</span>
                            <?php
								}
                            ?>
							<div class="table-responsive">
							<table id="dataTableAbsent" class="table">
								<thead>
								<tr>
									<th>ID</th>
									<th>Người lao động</th>
									<th>Ngày đăng ký</th>
                                    <th>Số ngày nghỉ</th>
									<th>Trạng thái</th>
									<th>Chức năng</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							</div>
						</div>
						</div>
					</div>
				</div>

			</div>
			<div class="modal fade" id="createAbsent" tabindex="-1" role="dialog" aria-labelledby="createAbsentLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="createAbsentLabel">Đăng ký nghỉ phép</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="createAbsentForm">
					<div class="form-group">
						<label for="reason" class="col-form-label">Lý do xin nghỉ:</label>
						<textarea type="text" class="form-control" name="reason" rows="8" cols="50" required></textarea>
					</div>
					<div class="form-group">
						<label for="countdate" class="col-form-label">Số ngày muốn nghỉ:</label>
						<select class="form-control" name="countdate" required>
							<?php
                                for($i = 1; $i < 15; $i++){
                                    echo "<option value=\"$i\">$i ngày</option>";
                                }
                            ?>
						</select>
					</div>
					</form>
					<div>
                        <label for="downloadlinks" class="col-form-label">Tệp đính kèm:</label>
						<form id="createAbsentFileDropZone" action="<?php homePath();?>/ajax/uploadabsentattachment.php" class="dropzone" ></form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="createAbsentSaveButton">Đăng ký nghỉ phép</button>
				</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="editAbsent" tabindex="-1" role="dialog" aria-labelledby="editAbsentLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editAbsentLabel">Sửa task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="editAbsentForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<?php if (checkPermission("admin"))
					{
					?>
						<div class="form-group">
							<label for="ten" class="col-form-label">Tên:</label>
							<input type="text" id="ten" name="ten" class="form-control" required/>
						</div>
					<?php
					}
					?>
					
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Mô tả:</label>
						<textarea type="text" class="form-control" name="mo_ta" rows="8" cols="50" required></textarea>
					</div>

					<?php if (checkPermission("admin"))
					{
					?>
						<div class="form-group">
							<label for="deadlinedate" class="col-form-label">Deadline:</label>
							<!-- <input type="text" class="form-control" id="deadlinedate" name="deadlinedate" required/> -->
							<div class="input-group date timepicker" id="deadlinedateedit" data-target-input="nearest">
								<input type="text" name="time" class="form-control datetimepicker-input" data-target="#deadlinedateedit"/>
								<div class="input-group-append" data-target="#deadlinedateedit" data-toggle="datetimepicker">
									<div class="input-group-text"><i data-feather="clock"></i></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="assign_id" class="col-form-label">Người được giao:</label>
							<select class="form-control" name="assign_id" required>
								<option value="0">Không có</option>
							</select>
						</div>
					<?php
					}
					?>
					</form>
					<div >
						<form id="fileDropZone" action="<?php homePath();?>/ajax/uploadtaskattachment.php" class="dropzone" ></form>
					</div>
					<div class="downloadlinks">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="editAbsentSaveButton">Lưu</button>
				</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="viewAbsent" tabindex="-1" role="dialog" aria-labelledby="viewAbsentLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="viewAbsentLabel">Xem thông tin</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="viewAbsentForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Lý do:</label>
						<textarea type="text" class="form-control" name="reason" rows="8" cols="50" readonly></textarea>
					</div>

					<div class="form-group">
						<label for="deadlinedate" class="col-form-label">Ngày đăng ký:</label>
						<div class="input-group date timepicker" id="regdateview" data-target-input="nearest">
							<input type="text" name="time" class="form-control datetimepicker-input" data-target="#regdateview" readonly/>
							<div class="input-group-append" data-target="#regdateview" data-toggle="datetimepicker">
								<div class="input-group-text"><i data-feather="clock"></i></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="countdate" class="col-form-label">Số ngày đăng ký:</label>
                        <input type="text" class="form-control" id="countdate" name="countdate" readonly>
					</div>

					<div class="form-group">
						<label for="status" class="col-form-label">Trạng thái:</label>
						<select class="form-control" name="status" required disabled>
							<option value="0">Chưa nhận</option>
							<option value="1">Đồng ý</option>
							<option value="2">Từ chối</option>
						</select>
					</div>

					<div class="form-group">
						<label for="downloadlinks" class="col-form-label">Tệp đính kèm:</label>
						<div class="downloadlinks">
						</div>
					</div>
					</form>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
				</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="acceptAbsent" tabindex="-1" role="dialog" aria-labelledby="acceptAbsentLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="acceptAbsentLabel">Accept task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                <form id="acceptAbsentForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Lý do:</label>
						<textarea type="text" class="form-control" name="reason" rows="8" cols="50" readonly></textarea>
					</div>

					<div class="form-group">
						<label for="deadlinedate" class="col-form-label">Ngày đăng ký:</label>
						<div class="input-group date timepicker" id="regdateview" data-target-input="nearest">
							<input type="text" name="time" class="form-control datetimepicker-input" data-target="#regdateview" readonly/>
							<div class="input-group-append" data-target="#regdateview" data-toggle="datetimepicker">
								<div class="input-group-text"><i data-feather="clock"></i></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="countdate" class="col-form-label">Số ngày đăng ký:</label>
                        <input type="text" class="form-control" id="countdate" name="countdate" readonly>
					</div>

					<div class="form-group">
						<label for="status" class="col-form-label">Trạng thái:</label>
						<select class="form-control" name="status" required disabled>
							<option value="0">Chưa nhận</option>
							<option value="1">Đồng ý</option>
							<option value="2">Từ chối</option>
						</select>
					</div>

					<div class="form-group">
						<label for="downloadlinks" class="col-form-label">Tệp đính kèm:</label>
						<div class="downloadlinks">
						</div>
					</div>
					</form>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="acceptAbsentButton">Đồng ý</button>
				</div>
				</div>
			</div>
		</div>

		<div id="confirmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">modalTitle Demo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<span>modalTitle body content!</span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
						<button type="button" class="btn btn-primary">Xác nhận</button>
					</div>
				</div>
			</div>
		</div>