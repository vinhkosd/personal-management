<?php
validateLogin(true, false);//check account login
checkPermission("admin", true);
?>
			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Tài khoản</a></li>
						<li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản</li>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
						<div class="card-body">
							<h6 class="card-title">Danh sách tài khoản</h6>
							<p class="card-description">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAccount" data-account="">Tạo tài khoản</button>
								<a id="reloadDataButton" href="javascript:void(0)"> Tải lại </a>
							</p>
							<div class="table-responsive">
							<table id="dataTableAccount" class="table">
								<thead>
								<tr>
									<th>ID</th>
									<th>Tài khoản</th>
									<th>Tên</th>
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
			<div class="modal fade" id="createAccount" tabindex="-1" role="dialog" aria-labelledby="createAccountLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="createAccountLabel">Tạo tài khoản</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="createAccountForm">
					<div class="form-group">
						<label for="name" class="col-form-label">Họ tên:</label>
						<input type="text" id="name" name="name" class="form-control" data-inputmask-regex="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s|_]+$"/>
					</div>
					<div class="form-group">
						<label for="username" class="col-form-label">Tài khoản:</label>
						<input type="text"  id="username" name="username" class="form-control" data-inputmask-regex="[a-zA-Z0-9]{4,40}"/>
					</div>
					<div class="form-group">
						<label for="imageurl" class="col-form-label">Ảnh đại diện:</label>
						<input type="text" class="form-control" id="imageurl" name="imageurl"/>
					</div>
					<div class="form-group">
						<label for="active" class="col-form-label">Khoá tài khoản:</label>
						<select class="form-control" name="active" required>
	                        	<option value="0">Không khoá</option>
	                        	<option value="1">Khoá tài khoản</option>
						</select>
					</div>
					<div class="form-group">
						<label for="phongban_id" class="col-form-label">Phòng ban:</label>
						<select class="form-control" name="phongban_id" required>
						</select>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="createAccountSaveButton">Tạo tài khoản</button>
				</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="editAccount" tabindex="-1" role="dialog" aria-labelledby="editAccountLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editAccountLabel">Sửa tài khoản</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="editAccountForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<div class="form-group">
						<label for="username" class="col-form-label">Tài khoản:</label>
						<input type="text" id="username" name="username" class="form-control" data-inputmask-regex="[a-zA-Z0-9]{4,40}" readonly/>
					</div>
					<div class="form-group">
						<label for="name" class="col-form-label">Họ tên:</label>
						<input type="text" id="name" name="name" class="form-control" data-inputmask-regex="[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s|_]+"/>
					</div>
					<div class="form-group">
						<label for="imageurl" class="col-form-label">Ảnh đại diện:</label>
						<input type="text" class="form-control" id="imageurl" name="imageurl"/>
					</div>
					<div class="form-group">
						<label for="active" class="col-form-label">Khoá tài khoản:</label>
						<select class="form-control" name="active" required>
	                        	<option value="0">Không khoá</option>
	                        	<option value="1">Khoá tài khoản</option>
						</select>
					</div>
					<div class="form-group">
						<label for="phongban_id" class="col-form-label">Phòng ban:</label>
						<select class="form-control" name="phongban_id" required>
						</select>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ bỏ</button>
					<button type="button" class="btn btn-primary" id="editAccountSaveButton">Lưu</button>
				</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="viewAccount" tabindex="-1" role="dialog" aria-labelledby="viewAccountLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="viewAccountLabel">Sửa tài khoản</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="viewAccountForm">
					<div class="form-group">
						<label for="id" class="col-form-label">ID:</label>
						<input type="text" class="form-control" id="id" name="id" readonly>
					</div>
					<div class="form-group">
						<label for="username" class="col-form-label">Tài khoản:</label>
						<input type="text" id="username" name="username" class="form-control" data-inputmask-regex="[a-zA-Z0-9]{4,40}" readonly/>
					</div>
					<div class="form-group">
						<label for="name" class="col-form-label">Họ tên:</label>
						<input type="text" id="name" name="name" class="form-control" readonly/>
					</div>
					<div class="form-group">
						<label for="imageurl" class="col-form-label">Ảnh đại diện:</label>
						<input type="text" class="form-control" id="imageurl" name="imageurl" readonly/>
					</div>
					<div class="form-group">
						<label for="role" class="col-form-label">Quyền hạn:</label>
						<select class="form-control" name="role" readonly disabled>
							<option value="god">Giám đốc</option>
							<option value="user">Nhân viên</option>
							<option value="admin">Trưởng phòng</option>
						</select>
					</div>
					<div class="form-group">
						<label for="phongban_id" class="col-form-label">Phòng ban:</label>
						<select class="form-control" name="phongban_id" readonly disabled>
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
		<!-- Extra large modal -->
<script type="text/javascript">
	$(document).ready(function() {
		
	});

</script>