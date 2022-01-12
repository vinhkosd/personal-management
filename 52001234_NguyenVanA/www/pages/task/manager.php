<?php
validateLogin(true, false);//check account login
checkPermission("user", true);
?>
			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Task</a></li>
						<li class="breadcrumb-item active" aria-current="page">Quản lý task</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<h6 class="card-title">Danh sách task</h6>
							<p class="card-description">
								<?php if (checkPermission("admin"))
								{
								?>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTask" data-phongban="">Tạo nhiệm vụ</button>
								<?php
								}
								?>
								<button type="button" class="btn btn-primary" id="reloadTaskData">Tải lại</button>
							</p>
							<div class="table-responsive">
							<table id="dataTableTask" class="table">
								<thead>
								<tr>
									<th>ID</th>
									<th>Tên</th>
									<th>Người giao</th>
                  					<th>Người được giao</th>
									<th>Thời hạn</th>
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
			<div class="modal fade" id="createTask" tabindex="-1" role="dialog" aria-labelledby="createTaskLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="createTaskLabel">Tạo task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="createTaskForm">
					<div class="form-group">
						<label for="ten" class="col-form-label">Tên:</label>
						<input type="text" id="ten" name="ten" class="form-control" required/>
					</div>
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Mô tả:</label>
						<textarea type="text" class="form-control" name="mo_ta" rows="8" cols="50" required></textarea>
					</div>
					<div class="form-group">
						<label for="deadlinedate" class="col-form-label">Deadline:</label>
						<!-- <input type="text" class="form-control" id="deadlinedate" name="deadlinedate" required/> -->
						<div class="input-group date timepicker" id="deadlinedate" data-target-input="nearest">
							<input type="text" name="time" class="form-control datetimepicker-input" data-target="#deadlinedate"/>
							<div class="input-group-append" data-target="#deadlinedate" data-toggle="datetimepicker">
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
					</form>
					<div >
						<form id="createTaskFileDropZone" action="<?php homePath();?>/ajax/uploadtaskattachment.php" class="dropzone" ></form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="createTaskSaveButton">Tạo nhiệm vụ</button>
				</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="editTaskLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editTaskLabel">Sửa task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="editTaskForm">
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
					<button type="button" class="btn btn-primary" id="editTaskSaveButton">Lưu</button>
				</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="viewTask" tabindex="-1" role="dialog" aria-labelledby="viewTaskLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="viewTaskLabel">Xem task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="viewTaskForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<?php if (checkPermission("admin"))
					{
					?>
						<div class="form-group">
							<label for="ten" class="col-form-label">Tên:</label>
							<input type="text" id="ten" name="ten" class="form-control" readonly/>
						</div>
					<?php
					}
					?>
					
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Mô tả:</label>
						<textarea type="text" class="form-control" name="mo_ta" rows="8" cols="50" readonly></textarea>
					</div>

					<div class="form-group">
						<label for="deadlinedate" class="col-form-label">Deadline:</label>
						<div class="input-group date timepicker" id="deadlinedateview" data-target-input="nearest">
							<input type="text" name="time" class="form-control datetimepicker-input" data-target="#deadlinedateview" readonly/>
							<div class="input-group-append" data-target="#deadlinedateview" data-toggle="datetimepicker">
								<div class="input-group-text"><i data-feather="clock"></i></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="assign_id" class="col-form-label">Người được giao:</label>
						<select class="form-control" name="assign_id" readonly disabled>
							<option value="0">Không có</option>
						</select>
					</div>

					<div class="form-group">
						<label for="status" class="col-form-label">Trạng thái:</label>
						<select class="form-control" name="status" required disabled>
							<option value="0">Mới</option>
							<option value="1">Đang làm</option>
							<option value="2">Đã huỷ bỏ</option>
							<option value="3">Đang chờ</option>
							<option value="4">Từ chối</option>
							<option value="5">Hoàn thành</option>
						</select>
					</div>

					<div class="form-group">
						<label for="complete_level" class="col-form-label">Mức độ hoàn thành:</label>
						<select class="form-control" name="complete_level" readonly disabled>
							<option value="0">Bad</option>
							<option value="1">OK</option>
							<option value="2">Good</option>
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

		<div class="modal fade" id="acceptTask" tabindex="-1" role="dialog" aria-labelledby="acceptTaskLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="acceptTaskLabel">Accept task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="acceptTaskForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					
					<div class="form-group">
							<label for="ten" class="col-form-label">Tên:</label>
							<input type="text" id="ten" name="ten" class="form-control" readonly/>
						</div>

					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Mô tả:</label>
						<textarea type="text" class="form-control" name="mo_ta" rows="8" cols="50" readonly></textarea>
					</div>

					<div class="form-group">
						<label for="complete_level" class="col-form-label">Mức độ hoàn thành:</label>
						<select class="form-control" name="complete_level" required>
							<option value="0">Bad</option>
							<option value="1">OK</option>
							<option value="2">Good</option>
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
					<button type="button" class="btn btn-primary" id="acceptTaskButton">Accept Task</button>
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