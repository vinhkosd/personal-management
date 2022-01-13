
(function ($) {
  'use strict';
  $(function () {
    var body = $('body');
    var sidebar = $('.sidebar');


    // Enable feather-icons with SVG markup
    feather.replace();

    // initializing bootstrap tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // initialize clipboard plugin
    if ($('.btn-clipboard').length) {
      var clipboard = new ClipboardJS('.btn-clipboard');

      // Enabling tooltip to all clipboard buttons
      $('.btn-clipboard').attr('data-toggle', 'tooltip').attr('title', 'Copy to clipboard');

      // initializing bootstrap tooltip
      $('[data-toggle="tooltip"]').tooltip();

      // initially hide btn-clipboard and show after copy
      clipboard.on('success', function (e) {
        e.trigger.classList.value = 'btn btn-clipboard btn-current'
        $('.btn-current').tooltip('hide');
        e.trigger.dataset.originalTitle = 'Copied';
        $('.btn-current').tooltip('show');
        setTimeout(function () {
          $('.btn-current').tooltip('hide');
          e.trigger.dataset.originalTitle = 'Copy to clipboard';
          e.trigger.classList.value = 'btn btn-clipboard'
        }, 1000);
        e.clearSelection();
      });
    }


    // Applying perfect-scrollbar 
    if ($('.sidebar .sidebar-body').length) {
      const sidebarBodyScroll = new PerfectScrollbar('.sidebar-body');
    }
    if ($('.content-nav-wrapper').length) {
      const contentNavWrapper = new PerfectScrollbar('.content-nav-wrapper');
    }

    // Sidebar toggle to sidebar-folded
    $('.sidebar-toggler').on('click', function (e) {
      $(this).toggleClass('active');
      $(this).toggleClass('not-active');
      if (window.matchMedia('(min-width: 992px)').matches) {
        e.preventDefault();
        body.toggleClass('sidebar-folded');
      } else if (window.matchMedia('(max-width: 991px)').matches) {
        e.preventDefault();
        body.toggleClass('sidebar-open');
      }
    });


    // Settings sidebar toggle
    $('.settings-sidebar-toggler').on('click', function (e) {
      $('body').toggleClass('settings-open');
    });

    // Sidebar theme settings
    $("input:radio[name=sidebarThemeSettings]").click(function () {
      $('body').removeClass('sidebar-light sidebar-dark');
      $('body').addClass($(this).val());
    })


    // sidebar-folded on large devices
    function iconSidebar(e) {
      if (e.matches) {
        body.addClass('sidebar-folded');
      } else {
        body.removeClass('sidebar-folded');
      }
    }
    var desktopMedium = window.matchMedia('(min-width:992px) and (max-width: 1199px)');
    desktopMedium.addListener(iconSidebar);
    iconSidebar(desktopMedium);


    //Add active class to nav-link based on url dynamically
    function addActiveClass(element) {
      if (current === "") {
        //for root url
        if (element.attr('href').indexOf("index.html") !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
        }
      } else {
        //for other url
        if (element.attr('href').indexOf(current) !== -1) {
          element.parents('.nav-item').last().addClass('active');
          if (element.parents('.sub-menu').length) {
            element.closest('.collapse').addClass('show');
            element.addClass('active');
          }
          if (element.parents('.submenu-item').length) {
            element.addClass('active');
          }
        }
      }
    }

    var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
    $('.nav li a', sidebar).each(function () {
      var $this = $(this);
      addActiveClass($this);
    });

    $('.horizontal-menu .nav li a').each(function () {
      var $this = $(this);
      addActiveClass($this);
    })


    //  open sidebar-folded when hover
    $(".sidebar .sidebar-body").hover(
      function () {
        if (body.hasClass('sidebar-folded')) {
          body.addClass("open-sidebar-folded");
        }
      },
      function () {
        if (body.hasClass('sidebar-folded')) {
          body.removeClass("open-sidebar-folded");
        }
      });

    // close sidebar when click outside on mobile/table    
    $(document).on('click touchstart', function (e) {
      e.stopPropagation();

      // closing of sidebar menu when clicking outside of it
      if (!$(e.target).closest('.sidebar-toggler').length) {
        var sidebar = $(e.target).closest('.sidebar').length;
        var sidebarBody = $(e.target).closest('.sidebar-body').length;
        if (!sidebar && !sidebarBody) {
          if ($('body').hasClass('sidebar-open')) {
            $('body').removeClass('sidebar-open');
          }
        }
      }
    });

    // initializing popover
    $('[data-toggle="popover"]').popover();

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-frame"></i>');




    //Horizontal menu in mobile
    $('[data-toggle="horizontal-menu-toggle"]').on("click", function () {
      $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
    });
    // Horizontal menu navigation in mobile menu on click
    var navItemClicked = $('.horizontal-menu .page-navigation >.nav-item');
    navItemClicked.on("click", function (event) {
      if (window.matchMedia('(max-width: 991px)').matches) {
        if (!($(this).hasClass('show-submenu'))) {
          navItemClicked.removeClass('show-submenu');
        }
        $(this).toggleClass('show-submenu');
      }
    })

    $(window).scroll(function () {
      if (window.matchMedia('(min-width: 992px)').matches) {
        var header = $('.horizontal-menu');
        if ($(window).scrollTop() >= 60) {
          $(header).addClass('fixed-on-scroll');
        } else {
          $(header).removeClass('fixed-on-scroll');
        }
      }
    });
    // initializing inputmask
    $(":input").inputmask();
    function initDatePicker(idElement, subMonth = 0) {
      if ($(`#${idElement}`).length) {
        $(`#${idElement}`).datetimepicker({
          format: 'YYYY-MM-DD HH:mm',

        });
      }
    }

    if ($('#dataTableTask').length > 0) {
      initDatePicker('deadlinedate');
      initDatePicker('deadlinedateedit');

      $("#fileDropZone").dropzone({
        dictDefaultMessage: 'Bạn có thể kéo file hoặc click để chọn file',
        init: function () {
          this.on("success", function (file, response) {
            var fileresponse = { nome: file.name, link: response[0] };
            file.previewElement.classList.add("dz-success");
          });

          this.on("error", function (file, error, xhr) {
            var fileresponse = { nome: file.name, status: xhr.status, statusText: xhr.statusText, erro: error.message };
          });
        }
      })

      $("#createTaskFileDropZone").dropzone({
        dictDefaultMessage: 'Bạn có thể kéo file hoặc click để chọn file',
        init: function () {
          this.on("success", function (file, response) {
            var fileresponse = { nome: file.name, link: response[0] };
            file.previewElement.classList.add("dz-success");
          });

          this.on("error", function (file, error, xhr) {
            var fileresponse = { nome: file.name, status: xhr.status, statusText: xhr.statusText, erro: error.message };
          });
        }
      })

      function limitCharacter(str, max, suffix = '...') {
        if (str.length <= max) return str;

        let strGioiHan = '';
        let nextStr = '';
        if (typeof (max) === 'number') {
          strGioiHan = str.substr(0, max);
          nextStr = str.substr(str.length - 3 < max ? str.length : str.length - 3, 3)
        }
        else {
          strGioiHan = str.substr(0, 30);
        }
        return strGioiHan + suffix + nextStr;
      }


      var dt = [];
      function loadTaskList() {
        var currentPage = $('#dataTableTask').DataTable().page.info().page;
        dt = $('#dataTableTask').DataTable().destroy();
        // $('#dataTableTask tbody').html("Loading...");
        dt = $('#dataTableTask').DataTable({
          "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "Tất cả"]
          ],
          "iDisplayLength": 10,
          "language": {
            search: ""
          },
          "processing": true,
          "serverSide": true,
          "ajax": window.homePath + "ajax/listtask.php",
          "order": [[0, "desc"]],
          "columns": [
            { "data": "id" },
            { "data": "ten" },
            { "data": "owner" },
            { "data": "assign" },
            { "data": "time" },
            {
              "data": "status",
              render: function (data, type, row, meta) {
                var returnText = "";
                switch (row.status) {
                  case 0:
                    returnText = "Chưa nhận";
                    break;
                  case 1:
                    returnText = "Đã nhận";
                    break;
                  case 2:
                    returnText = "Đã huỷ";
                    break;
                  case 3:
                    returnText = "Đang chờ";
                    break;
                  case 4:
                    returnText = "Từ chối";
                    break;
                  case 5:
                    returnText = "Đã xong";
                    break;
                }
                return returnText;
              }
            },
            {
              "class": "function-button",
              "orderable": false,
              "data": null,
              render: function (data, type, row, meta) {
                let canAcceptTask = false;
                let canSubmitTask = false;
                let canStartTask = false;
                let actionButtontext = "";
                switch (row.status) {
                  case 0:
                    canStartTask = true;
                    actionButtontext = "Huỷ Task";
                    //Chưa nhận
                    break;
                  case 1:
                    canSubmitTask = true;
                    canAcceptTask = true;
                    //Đã nhận
                    break;
                  case 2:
                    //Đã huỷ
                    break;
                  case 3:
                    actionButtontext = "Reject Task";
                    canSubmitTask = true;
                    canAcceptTask = true;
                    //Đang chờ
                    break;
                  case 4:
                    canSubmitTask = true;
                    canAcceptTask = true;
                    //Từ chối - reject
                    break;
                  case 5:
                    canAcceptTask = false;
                    canSubmitTask = false;
                    canStartTask = false;
                    //Đã xong
                    break;
                }

                return `	<div>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewTask" data-task="">Xem Task</button>
                            ${canSubmitTask && row.assign_id == window.accountId ? `<button type="button" class="btn btn-primary btn-edit" data-toggle="modal" data-target="#editTask" data-task="">Submit</button>` : ``}
                            ${canStartTask && row.assign_id == window.accountId ? `<button type="button" class="btn btn-primary btn-start" data-task="">Start</button>` : ``}
                            ${window.accountRole != "user" && actionButtontext != "" ? `<button type="button" class="btn btn-primary btn-reject" data-task="">${actionButtontext}</button>` : ''}
                            ${window.accountRole != "user" && canAcceptTask ? `<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#acceptTask" data-task="">Accept Task</button>` : ''}
                          </div>`;
              }
            },
          ]
        });

        dt.on('draw', function () {
          // $('#dataTableTask tbody button').trigger( 'click' );
          $('#dataTableTask tbody').on('click', 'tr td.function-button', function () {
            var tr = $(this).closest('tr');
            var row = $('#dataTableTask').DataTable().row(tr);
            var rowData = row.data();
            $(this).find('button').attr('data-task', JSON.stringify(rowData));
          });

          $('.btn-start').click(function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var rowData = row.data();

            confirmModal(`Vui lòng xác nhận bắt đầu task : ${rowData.ten}`, () => startNewTask(rowData));
          });

          $('.btn-reject').click(function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var rowData = row.data();

            let actionText = "";
            switch (rowData.status) {
              case 0:
                actionText = "huỷ Task";
                //Chưa nhận
                break;
              case 3:
                actionText = "reject Task";
                //Đang chờ
                break;
            }

            confirmModal(`Vui lòng xác nhận ${actionText} : ${rowData.ten}`, () => rejectTask(rowData));
          });
        });
      }

      function startNewTask(params) {
        $.post(window.homePath + "ajax/starttask.php", params, (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
        }, "json")
          .always(function () {
            $('#dataTableTask').DataTable().ajax.reload();//reload dữ liệu
          });
      }

      function rejectTask(params) {
        $.post(window.homePath + "ajax/rejecttask.php", params, (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
        }, "json")
          .always(function () {
            $('#dataTableTask').DataTable().ajax.reload();//reload dữ liệu
          });
      }

      loadTaskList();
      getUserList();

      $('#reloadTaskData').click(function (e, t) {
        $('#dataTableTask').DataTable().ajax.reload();//reload dữ liệu
      })

      $('#editTask').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        var taskInfo = (button.data('task')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(taskInfo).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(taskInfo[item]);
            modal.find('.modal-body select[name=' + item + ']').val(taskInfo[item]);
            modal.find('.modal-body textarea[name=' + item + ']').val(taskInfo[item]);
          }
          if (item == "attachment") {
            if ($(".downloadlinks").length) {
              try {
                $(".downloadlinks").html("");
                var downloadLinks = JSON.parse(taskInfo[item]);
                downloadLinks.map(item => {
                  const anchor = document.createElement('a');
                  anchor.href = window.homePath + item;
                  let filename = item.split("/")[1] ? item.split("/")[1] : item;
                  let arr = filename.split(".");
                  anchor.innerText = limitCharacter(arr[0], 30) + "." + arr[1];
                  const li = document.createElement('li');
                  li.appendChild(anchor);
                  $(".downloadlinks").append(li);
                })

              } catch {
                console.log("cant not parse attachment data");
              }
            }
          }
        })
        modal.find('.modal-title').text('Sửa task - ' + taskInfo['ten'])
      });

      $('#acceptTask').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        var taskInfo = (button.data('task')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(taskInfo).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(taskInfo[item]);
            modal.find('.modal-body select[name=' + item + ']').val(taskInfo[item]);
            modal.find('.modal-body textarea[name=' + item + ']').val(taskInfo[item]);
          }
          if (item == "attachment") {
            if ($(".downloadlinks").length) {
              try {
                $(".downloadlinks").html("");
                var downloadLinks = JSON.parse(taskInfo[item]);
                downloadLinks.map(item => {
                  const anchor = document.createElement('a');
                  anchor.href = window.homePath + item;
                  let filename = item.split("/")[1] ? item.split("/")[1] : item;
                  let arr = filename.split(".");
                  anchor.innerText = limitCharacter(arr[0], 30) + "." + arr[1];
                  const li = document.createElement('li');
                  li.appendChild(anchor);
                  $(".downloadlinks").append(li);
                })

              } catch {
                console.log("cant not parse attachment data");
              }
            }
          }
        })
        modal.find('.modal-title').text('Accept task - ' + taskInfo['ten'])
      });

      $('#viewTask').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        var taskInfo = (button.data('task')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(taskInfo).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(taskInfo[item]);
            modal.find('.modal-body select[name=' + item + ']').val(taskInfo[item]);
            modal.find('.modal-body textarea[name=' + item + ']').val(taskInfo[item]);
          }
          if (item == "attachment") {
            if ($(".downloadlinks").length) {
              try {
                $(".downloadlinks").html("");
                var downloadLinks = JSON.parse(taskInfo[item]);
                downloadLinks.map(item => {
                  const anchor = document.createElement('a');
                  anchor.href = window.homePath + item;
                  let filename = item.split("/")[1] ? item.split("/")[1] : item;
                  let arr = filename.split(".");
                  anchor.innerText = limitCharacter(arr[0], 30) + "." + arr[1];
                  const li = document.createElement('li');
                  li.appendChild(anchor);
                  $(".downloadlinks").append(li);
                })

              } catch {
                console.log("cant not parse attachment data");
              }
            }
          }
        })
        modal.find('.modal-title').text('Xem task - ' + taskInfo['ten'])
      });

      $('#editTask').on('hidden.bs.modal', function (e) {
        $.post(window.homePath + "ajax/resetattachment.php", {}, (data) => {
          var objDZ = Dropzone.forElement("#fileDropZone");
          objDZ.removeAllFiles(true);
          var objDZ = Dropzone.forElement("#createTaskFileDropZone");
          objDZ.removeAllFiles(true);
        });
      });

      $('#createTask').on('hidden.bs.modal', function (e) {
        $('#createTaskForm')[0].reset();
      });

      $('#editTaskSaveButton').click(function () {
        $.post(window.homePath + "ajax/edittask.php", $('#editTaskForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#editTask').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableTask').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#createTaskSaveButton').click(function () {
        $.post(window.homePath + "ajax/createtask.php", $('#createTaskForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#createTask').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableTask').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#acceptTaskButton').click(function () {
        $.post(window.homePath + "ajax/accepttask.php", $('#acceptTaskForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#acceptTask').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableTask').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      function getUserList() {
        $.get(window.homePath + "ajax/userlist.php", { role: "user" }, (data) => {

          $.each(data, function (key, value) {
            $('select[name="assign_id"]')
              .append($("<option></option>")
                .attr("value", value.id)
                .text(value.name));
          });
        }, "json");
      }

      $.post(window.homePath + "ajax/resetattachment.php", {}, (data) => {
      });
    }

    if ($('#dataTablePhongBan').length > 0) {
      var dt = [];
      function listPhongBan() {
        var currentPage = $('#dataTablePhongBan').DataTable().page.info().page;
        dt = $('#dataTablePhongBan').DataTable().destroy();
        // $('#dataTablePhongBan tbody').html("Loading...");
        dt = $('#dataTablePhongBan').DataTable({
          "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "Tất cả"]
          ],
          "iDisplayLength": 10,
          "language": {
            search: ""
          },
          "processing": true,
          "serverSide": true,
          "ajax": window.homePath + "ajax/listphongban.php",
          "order": [[0, "desc"]],
          "columns": [
            { "data": "id" },
            { "data": "ten" },
            { "data": "mo_ta" },
            { "data": "so_phong" },
            {
              "class": "function-button",
              "orderable": false,
              "data": null,
              "defaultContent": `	<div>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewPhongBan" data-phongban="">Xem</button>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editPhongBan" data-phongban="">Sửa phòng ban</button>
                  </div>`
            },
          ]
        });

        dt.on('draw', function () {
          // $('#dataTablePhongBan tbody button').trigger( 'click' );
          $('#dataTablePhongBan tbody').on('click', 'tr td.function-button', function () {
            var tr = $(this).closest('tr');
            var row = $('#dataTablePhongBan').DataTable().row(tr);
            $(this).find('button').attr('data-phongban', JSON.stringify(row.data()));
          });


        });
      }

      listPhongBan();
      getUserList();

      $('#reloadPhongBan').click(function (e, t) {
        $('#dataTablePhongBan').DataTable().ajax.reload();//reload dữ liệu
      })

      $('#editPhongBan').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) // Button that triggered the modal

        var phongbanData = (button.data('phongban')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(phongbanData).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(phongbanData[item]);
            modal.find('.modal-body select[name=' + item + ']').val(phongbanData[item]);
          }
        })
        modal.find('.modal-title').text('Sửa phòng ban - ' + phongbanData['ten'])
      });

      $('#viewPhongBan').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) // Button that triggered the modal

        var phongbanData = (button.data('phongban')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(phongbanData).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(phongbanData[item]);
            modal.find('.modal-body select[name=' + item + ']').val(phongbanData[item]);
          }
        })
        modal.find('.modal-title').text('Xem phòng ban - ' + phongbanData['ten'])
      });

      $('#editPhongBanSaveButton').click(function () {
        $.post(window.homePath + "ajax/editphongban.php", $('#editPhongBanForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#editPhongBan').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTablePhongBan').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#createPhongBanSaveButton').click(function () {
        $.post(window.homePath + "ajax/createphongban.php", $('#createPhongBanForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#createPhongBan').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTablePhongBan').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#createPhongBan').on('hidden.bs.modal', function (e) {
        $('#createPhongBanForm')[0].reset();
      });

      function getUserList() {
        $.get(window.homePath + "ajax/userlist.php", {}, (data) => {

          $.each(data, function (key, value) {
            $('select[name="manager_id"]')
              .append($("<option></option>")
                .attr("value", value.id)
                .text(value.name));
          });
        }, "json");
      }
    }

    $('#loginForm').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      }

      $.post(window.homePath + "ajax/login.php", $("#loginForm").serialize(), (data) => {
        if (data[0] == 'success') {
          window.location = window.homePath;
        } else {
          Lobibox.notify("error", {
            msg: data["error"]
          });
        }
      }, "json");
      return false;
    });
    $('#firstLoginForm').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      }

      var formData = new FormData();
      var currentForm = $("#firstLoginForm").serializeArray()

      currentForm.map(item => {
        formData.append(item.name, item.value);
      })

      var attachment_data = $("#imageurl")[0].files[0];
      formData.append("imageurl", attachment_data);

      $.ajax({
        url: window.homePath + "ajax/firstlogin.php",
        type: 'POST',
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success: function (data) {
          var result = JSON.parse(data)
          if (result.success) {
            Lobibox.notify("success", {
              msg: result["success"]
            });
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          } else {
            Lobibox.notify("error", {
              msg: result["error"]
            });
          }
        }
      });

      return false;
    });

    $('#newPasswordForm').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
        return false;
      }

      $.post(window.homePath + "ajax/newpassword.php", $("#newPasswordForm").serialize(), (data) => {
        if (data[0] == 'success') {
          window.location = window.homePath + "";
        } else {
          Lobibox.notify("error", {
            msg: data["error"]
          });
        }
      }, "json");
      return false;
    });

    if ($('#dataTableAccount').length > 0) {
      var dt = [];
      function loadAccountList() {
        var currentPage = $('#dataTableAccount').DataTable().page.info().page;
        dt = $('#dataTableAccount').DataTable().destroy();
        // $('#dataTableAccount tbody').html("Loading...");
        dt = $('#dataTableAccount').DataTable({
          "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "Tất cả"]
          ],
          "iDisplayLength": 10,
          "language": {
            search: ""
          },
          "processing": true,
          "serverSide": true,
          "ajax": window.homePath + "ajax/accountlist_serverside.php",
          "order": [[0, "desc"]],
          "columns": [
            { "data": "id" },
            { "data": "username" },
            { "data": "name" },
            {
              "class": "function-button",
              "orderable": false,
              "data": null,
              "defaultContent": `	<div>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewAccount" data-account="">Xem</button>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAccount" data-account="">Sửa nhân viên</button>
                  <button type="button" class="btn btn-primary resetPassword">Reset mật khẩu</button>
                  </div>`
            },
          ]
        });

        dt.on('draw', function () {
          // $('#dataTableAccount tbody button').trigger( 'click' );
          $('#dataTableAccount tbody').on('click', 'tr td.function-button', function () {
            var tr = $(this).closest('tr');
            var row = $('#dataTableAccount').DataTable().row(tr);
            $(this).find('button').attr('data-account', JSON.stringify(row.data()));
          });

          $(".resetPassword").click(function () {

            var tr = $(this).closest('tr');
            var row = $('#dataTableAccount').DataTable().row(tr);
            var rowData = row.data();

            confirmModal(`Vui lòng xác nhận reset mật khẩu cho user: ${rowData.username}`, () => resetPassword(rowData));

          });
        });
      }

      function resetPassword(rowData) {
        $.post(window.homePath + "ajax/resetpassword.php", rowData, (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
        }, "json")
          .always(function () {
            $('#dataTableAccount').DataTable().ajax.reload();//reload dữ liệu
          });
      }

      loadAccountList();

      $('#reloadDataButton').click(function (e, t) {
        $('#dataTableAccount').DataTable().ajax.reload();//reload dữ liệu
      })

      $('#editAccount').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) // Button that triggered the modal

        var accountData = (button.data('account')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(accountData).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(accountData[item]);
            modal.find('.modal-body select[name=' + item + ']').val(accountData[item]);
          }
        })
        modal.find('.modal-title').text('Sửa tài khoản - ' + accountData['username'])
      });

      $('#viewAccount').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) // Button that triggered the modal

        var accountData = (button.data('account')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(accountData).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(accountData[item]);
            modal.find('.modal-body select[name=' + item + ']').val(accountData[item]);
          }
        })
        modal.find('.modal-title').text('Xem tài khoản - ' + accountData['username'])
      });


      $('#editAccountSaveButton').click(function () {
        $.post(window.homePath + "ajax/editaccount.php", $('#editAccountForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#editAccount').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableAccount').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#createAccountSaveButton').click(function () {
        $.post(window.homePath + "ajax/createaccount.php", $('#createAccountForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#createAccount').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableAccount').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#createAccount').on('hidden.bs.modal', function (e) {
        $('#createAccountForm')[0].reset();
      });

      $.get(window.homePath + "ajax/phongbanlist.php", {}, (data) => {

        $.each(data, function (key, value) {
          $('select[name="phongban_id"]')
            .append($("<option></option>")
              .attr("value", value.id)
              .text(value.ten));
        });
      }, "json");
    }
    
    
    if ($('#dataTableAbsent').length > 0) {
      initDatePicker('deadlinedate');
      initDatePicker('deadlinedateedit');

      $("#fileDropZone").dropzone({
        dictDefaultMessage: 'Bạn có thể kéo file hoặc click để chọn file',
        init: function () {
          this.on("success", function (file, response) {
            var fileresponse = { nome: file.name, link: response[0] };
            file.previewElement.classList.add("dz-success");
          });

          this.on("error", function (file, error, xhr) {
            var fileresponse = { nome: file.name, status: xhr.status, statusText: xhr.statusText, erro: error.message };
          });
        }
      })

      $("#createAbsentFileDropZone").dropzone({
        dictDefaultMessage: 'Bạn có thể kéo file hoặc click để chọn file',
        init: function () {
          this.on("success", function (file, response) {
            var fileresponse = { nome: file.name, link: response[0] };
            file.previewElement.classList.add("dz-success");
          });

          this.on("error", function (file, error, xhr) {
            var fileresponse = { nome: file.name, status: xhr.status, statusText: xhr.statusText, erro: error.message };
          });
        }
      })

      function limitCharacter(str, max, suffix = '...') {
        if (str.length <= max) return str;

        let strGioiHan = '';
        let nextStr = '';
        if (typeof (max) === 'number') {
          strGioiHan = str.substr(0, max);
          nextStr = str.substr(str.length - 3 < max ? str.length : str.length - 3, 3)
        }
        else {
          strGioiHan = str.substr(0, 30);
        }
        return strGioiHan + suffix + nextStr;
      }


      var dt = [];
      function loadAbsentList() {
        var currentPage = $('#dataTableAbsent').DataTable().page.info().page;
        dt = $('#dataTableAbsent').DataTable().destroy();
        // $('#dataTableAbsent tbody').html("Loading...");
        dt = $('#dataTableAbsent').DataTable({
          "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "Tất cả"]
          ],
          "iDisplayLength": 10,
          "language": {
            search: ""
          },
          "processing": true,
          "serverSide": true,
          "ajax": window.homePath + "ajax/listabsent.php",
          "order": [[0, "desc"]],
          "columns": [
            { "data": "id" },
            { "data": "register_name" },
            { "data": "time" },
            { "data": "countdate" },
            {
              "data": "status",
              render: function (data, type, row, meta) {
                var returnText = "";
                switch (row.status) {
                  case 0:
                    returnText = "Đang chờ";
                    break;
                  case 1:
                    returnText = "Đồng ý";
                    break;
                  case 2:
                    returnText = "Từ chối";
                    break;
                }
                return returnText;
              }
            },
            {
              "class": "function-button",
              "orderable": false,
              "data": null,
              render: function (data, type, row, meta) {
                let canAcceptAbsent = false;
                let canRejectAbsent = false;
                switch (row.status) {
                  case 0:
                    canRejectAbsent = true;
                    canAcceptAbsent = true;
                    //Chưa nhận
                    break;
                  default:
                    //Đã chấp thuận
                    canAcceptAbsent = false;
                    canRejectAbsent = false;
                    break;
                }

                return `	<div>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewAbsent" data-task="">Xem thông tin</button>
                            ${row.register_id != window.accountId && canRejectAbsent ? `<button type="button" class="btn btn-primary btn-reject" data-task="">Từ chối</button>` : ''}
                            ${row.register_id != window.accountId && canAcceptAbsent ? `<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#acceptAbsent" data-task="">Đồng ý</button>` : ''}
                          </div>`;
              }
            },
          ]
        });

        dt.on('draw', function () {
          if(dt.ajax.json()) {
            var dataJson = dt.ajax.json();
            if(dataJson.absentMax){
              $("#absent-remain").html(dataJson.absentRemain);
              $("#absent-max").html(dataJson.absentMax);
              $("#absent-total").html(dataJson.absentTotal);
            }
          }
          $('#dataTableAbsent tbody').on('click', 'tr td.function-button', function () {
            var tr = $(this).closest('tr');
            var row = $('#dataTableAbsent').DataTable().row(tr);
            var rowData = row.data();
            $(this).find('button').attr('data-task', JSON.stringify(rowData));
          });

          $('.btn-reject').click(function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var rowData = row.data();

            confirmModal(`Vui lòng xác nhận từ chối đơn xin nghỉ phép của nhân viên: ${rowData.register_name}`, () => rejectAbsent(rowData));
          });
        });
      }

      function rejectAbsent(params) {
        $.post(window.homePath + "ajax/rejectabsent.php", params, (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
        }, "json")
          .always(function () {
            $('#dataTableAbsent').DataTable().ajax.reload();//reload dữ liệu
          });
      }

      loadAbsentList();
      getUserList();

      $('#reloadAbsentData').click(function (e, t) {
        $('#dataTableAbsent').DataTable().ajax.reload();//reload dữ liệu
      });

      $('#acceptAbsent').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        var absentInfo = (button.data('task')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(absentInfo).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(absentInfo[item]);
            modal.find('.modal-body select[name=' + item + ']').val(absentInfo[item]);
            modal.find('.modal-body textarea[name=' + item + ']').val(absentInfo[item]);
          }
          if (item == "attachment") {
            if ($(".downloadlinks").length) {
              try {
                $(".downloadlinks").html("");
                var downloadLinks = JSON.parse(absentInfo[item]);
                downloadLinks.map(item => {
                  const anchor = document.createElement('a');
                  anchor.href = window.homePath + item;
                  let filename = item.split("/")[1] ? item.split("/")[1] : item;
                  let arr = filename.split(".");
                  anchor.innerText = limitCharacter(arr[0], 30) + "." + arr[1];
                  const li = document.createElement('li');
                  li.appendChild(anchor);
                  $(".downloadlinks").append(li);
                })

              } catch {
                console.log("cant not parse attachment data");
              }
            }
          }
        })
        modal.find('.modal-title').text('Đồng ý đơn xin phép nghỉ - ' + absentInfo['register_name'])
      });

      $('#viewAbsent').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        var absentInfo = (button.data('task')) // Extract info from data-* attributes
        var modal = $(this);
        Object.keys(absentInfo).map(item => {
          if (item !== 'password') {
            modal.find('.modal-body input[name=' + item + ']').val(absentInfo[item]);
            modal.find('.modal-body select[name=' + item + ']').val(absentInfo[item]);
            modal.find('.modal-body textarea[name=' + item + ']').val(absentInfo[item]);
          }
          if (item == "attachment") {
            if ($(".downloadlinks").length) {
              try {
                $(".downloadlinks").html("");
                var downloadLinks = JSON.parse(absentInfo[item]);
                downloadLinks.map(item => {
                  const anchor = document.createElement('a');
                  anchor.href = window.homePath + item;
                  let filename = item.split("/")[1] ? item.split("/")[1] : item;
                  let arr = filename.split(".");
                  anchor.innerText = limitCharacter(arr[0], 30) + "." + arr[1];
                  const li = document.createElement('li');
                  li.appendChild(anchor);
                  $(".downloadlinks").append(li);
                })

              } catch {
                console.log("cant not parse attachment data");
              }
            }
          }
        })
        modal.find('.modal-title').text('Xem thông tin nghỉ phép - ' + absentInfo['register_name'])
      });

      $('#editAbsent').on('hidden.bs.modal', function (e) {
        $.post(window.homePath + "ajax/resetabsentattachment.php", {}, (data) => {
          var objDZ = Dropzone.forElement("#fileDropZone");
          objDZ.removeAllFiles(true);
          var objDZ = Dropzone.forElement("#createAbsentFileDropZone");
          objDZ.removeAllFiles(true);
        });
      });

      $('#createAbsent').on('hidden.bs.modal', function (e) {
        $('#createAbsentForm')[0].reset();
      });

      $('#editAbsentSaveButton').click(function () {
        $.post(window.homePath + "ajax/edittask.php", $('#editAbsentForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#editAbsent').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableAbsent').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#createAbsentSaveButton').click(function () {
        $.post(window.homePath + "ajax/createabsent.php", $('#createAbsentForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#createAbsent').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableAbsent').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      $('#acceptAbsentButton').click(function () {
        $.post(window.homePath + "ajax/acceptabsent.php", $('#acceptAbsentForm').serialize(), (data) => {
          if (data.success) {
            Lobibox.notify("success", {
              msg: data.success
            });
          } else {
            Lobibox.notify("error", {
              msg: data.error
            });
          }
          $('#acceptAbsent').modal('hide');
        }, "json")
          .always(function () {
            $('#dataTableAbsent').DataTable().ajax.reload();//reload dữ liệu
          });
        return false;
      });

      function getUserList() {
        $.get(window.homePath + "ajax/userlist.php", { role: "user" }, (data) => {

          $.each(data, function (key, value) {
            $('select[name="assign_id"]')
              .append($("<option></option>")
                .attr("value", value.id)
                .text(value.name));
          });
        }, "json");
      }

      $.post(window.homePath + "ajax/resetabsentattachment.php", {}, (data) => {
      });
    }

    function confirmModal(content, nextaction) {
      $('#confirmModal').find('.modal-body span').html(content);
      $('#confirmModal').find('.modal-title').html(content);
      $('#confirmModal').modal();

      $('#confirmModal .modal-footer button.btn-primary').bind("click", function () {
        $('#confirmModal .modal-footer button.btn-primary').unbind("click");
        nextaction();
        $('#confirmModal').modal('hide');
        $('#confirmModal .modal-footer button.btn-primary').off();
        return false;
      });
    }

    $('#confirmModal').on('hidden.bs.modal', function () {
      $('#confirmModal .modal-footer button.btn-primary').off();
      $('#confirmModal .modal-footer button.btn-primary').unbind("click");
    });
  });
})(jQuery);