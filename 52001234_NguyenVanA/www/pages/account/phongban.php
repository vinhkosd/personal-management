<?php
validateLogin(true, false);//check account login
checkPermission("admin", true);
?>
			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Phòng ban</a></li>
						<li class="breadcrumb-item active" aria-current="page">Danh sách phòng ban</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<h6 class="card-title">Danh sách phòng ban</h6>
							<p class="card-description">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPhongBan" data-phongban="">Tạo phòng ban</button>
								<button type="button" class="btn btn-primary" id="reloadPhongBan">Tải lại</button>
							</p>
							<div class="table-responsive">
							<table id="dataTablePhongBan" class="table">
								<thead>
								<tr>
									<th>ID</th>
									<th>Tên</th>
									<th>Mô tả</th>
									<th>Số phòng</th>
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
			<div class="modal fade" id="createPhongBan" tabindex="-1" role="dialog" aria-labelledby="createPhongBanLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="createPhongBanLabel">Tạo phòng ban</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="createPhongBanForm">
					<div class="form-group">
						<label for="ten" class="col-form-label">Tên phòng ban:</label>
						<input type="text" id="ten" name="ten" class="form-control" required/>
					</div>
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Mô tả:</label>
						<input type="text"  id="mo_ta" name="mo_ta" class="form-control" required/>
					</div>
					<div class="form-group">
						<label for="so_phong" class="col-form-label">Số phòng:</label>
						<input type="text" class="form-control" id="so_phong" name="so_phong" data-inputmask-regex="[0-9]{1,40}" required/>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="createPhongBanSaveButton">Tạo phòng ban</button>
				</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="editPhongBan" tabindex="-1" role="dialog" aria-labelledby="editPhongBanLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editPhongBanLabel">Sửa phòng ban</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="editPhongBanForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<div class="form-group">
						<label for="ten" class="col-form-label">Tên phòng ban:</label>
						<input type="text" id="ten" name="ten" class="form-control" required/>
					</div>
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Mô tả:</label>
						<input type="text"  id="mo_ta" name="mo_ta" class="form-control" required/>
					</div>
					<div class="form-group">
						<label for="so_phong" class="col-form-label">Số phòng:</label>
						<input type="text" class="form-control" id="so_phong" name="so_phong" data-inputmask-regex="[0-9]{1,40}" required/>
					</div>
					<div class="form-group">
						<label for="manager_id" class="col-form-label">Trưởng phòng:</label>
						<select class="form-control" name="manager_id" required>
							<option value="0">Không có</option>
						</select>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="editPhongBanSaveButton">Lưu</button>
				</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="viewPhongBan" tabindex="-1" role="dialog" aria-labelledby="viewPhongBanLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="viewPhongBanLabel">Sửa phòng ban</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="viewPhongBanForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<div class="form-group">
						<label for="ten" class="col-form-label">Tên phòng ban:</label>
						<input type="text" id="ten" name="ten" class="form-control" readonly/>
					</div>
					<div class="form-group">
						<label for="mo_ta" class="col-form-label">Mô tả:</label>
						<input type="text"  id="mo_ta" name="mo_ta" class="form-control" readonly/>
					</div>
					<div class="form-group">
						<label for="so_phong" class="col-form-label">Số phòng:</label>
						<input type="text" class="form-control" id="so_phong" name="so_phong" readonly/>
					</div>
					<div class="form-group">
						<label for="manager_id" class="col-form-label">Trưởng phòng:</label>
						<select class="form-control" name="manager_id" readonly disabled>
							<option value="0">Không có</option>
						</select>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
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