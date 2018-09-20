var studentUrl = "class/students.fn.php";
var student =
{
    listStudents: function()
    {
        /**
         *action
         * 0 = list
         **/
        var parametros =
        {
            "action": 0
        };
        $.ajax(
        {
            data: parametros,
            url: studentUrl,
            type: "post",
            success: function(response)
            {
                $("#tblStudent > tbody").empty();
                $("#tblStudent > tbody").append(response);
            },
            error: function(xhr, tStatus, err)
            {
                swal("", tStatus + " --- " + xhr.responseText, "error");
            }
        });
        $("#btnEdit").hide();
        $("#btnDelete").hide();
    },
    add: function()
    {
        if (($("#InputName").val().length == 0) || ($("#InputAge").val().length == 0))
        {
            return false;
        }
        var parametros =
        {
            "action": 1,
            "name": $("#InputName").val(),
            "age": $("#InputAge").val()
        };
        $.ajax(
        {
            data: parametros,
            url: studentUrl,
            type: "post",
            dataType: "json",
            success: function(response)
            {
                if (response.error == 'true')
                {
                    swal("Success!", "Student Added", "success");
                }
                else
                {
                    swal("Error!", 'Something wrong happen...', "error");
                }
            },
            error: function(xhr, tStatus, err)
            {
                swal("", tStatus + " --- " + xhr.responseText, "error");
            }
        });
        this.listStudents();
        this.clearForm();
    },
    edit: function()
    {
        var msg = this.setMessage(2);
        var parametros =
        {
            "action": 2,
            "id": $("#InputId").val(),
            "name": $("#InputName").val(),
            "age": $("#InputAge").val()
        };
        $.ajax(
        {
            data: parametros,
            url: studentUrl,
            type: "post",
            dataType: "json",
            success: function(response)
            {
                if (response.error == 'false')
                {
                    swal("Success!", msg, "success");
                }
                else
                {
                    swal("Error!", 'Something wrong happen...', "error");
                }
            },
            error: function(xhr, tStatus, err)
            {
                swal("", tStatus + " --- " + xhr.responseText, "error");
            }
        });
        $("#btnEdit").hide();
        $("#btnDelete").hide();
        $("#btnAdd").show();
        this.clearForm();
        this.listStudents();
    },
    delete: function()
    {
        swal(
        {
            title: "Sure you want to DELETE Student " + $("#InputName").val() + " from database?",
            //text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "No, Cancel this action!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm)
        {
            if (isConfirm)
            {
                var msg = student.setMessage(3);
                var parametros =
                {
                    "action": 3,
                    "id": $("#InputId").val()
                };
                $.ajax(
                {
                    data: parametros,
                    url: studentUrl,
                    type: "post",
                    dataType: "json",
                    success: function(response)
                    {
                        if (response.error == 'false')
                        {
                            swal("Success!", msg, "success");
                        }
                        else
                        {
                            swal("Error!", 'Something wrong happen...' + response.errDesc, "error");
                        }
                        student.clearForm();
                        student.listStudents();
                    },
                    error: function(xhr, tStatus, err)
                    {
                        swal("", tStatus + " --- " + xhr.responseText, "error");
                    }
                });
            }
            else
            {
                swal("Canceled", "No student affected", "error");
                this.clearForm();
            }
        });
        $("#btnEdit").hide();
        $("#btnDelete").hide();
        $("#btnAdd").show();
    },
    loadToEdit: function(id)
    {
        /**
         *action
         * 4 = listOne
         **/
        var parametros =
        {
            "action": 4,
            "id": id
        };
        $.ajax(
        {
            data: parametros,
            url: studentUrl,
            type: "post",
            dataType: "json",
            before: function()
            {
                this.clearForm();
            },
            success: function(response)
            {
                if (response.error != undefined)
                {
                    alert(response.qry);
                }
                else
                {
                    $.each(response, function(index, st)
                    {
                        $("#InputId").val(st.id_student);
                        $("#InputName").val(st.student_name);
                        $("#InputAge").val(st.student_age);
                    });
                    $("#btnEdit").show();
                    $("#btnDelete").show();
                    $("#btnAdd").hide();
                }
            },
            error: function(xhr, tStatus, err)
            {
                swal("", tStatus + " --- " + xhr.responseText, "error");
            }
        });
    },
    setMessage: function(action)
    {
        var msg = "";
        switch (action)
        {
        case 2:
            msg = "Student Edited";
            break;
        case 3:
            msg = "Student Deleted";
            break;
        default:
            msg = "Student";
            break;
        };
        return msg;
    },
    clearForm: function()
    {
        $("#InputId").val("");
        $("#InputName").val("");
        $("#InputAge").val("");
    }
}