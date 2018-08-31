//Cuando no ha iniciaso nunca.
function NuevoLogin()
{
    if ($("#usuario").val() != "" && $("#pass").val() != "")
    {
        var fd = new FormData(document.getElementById("login"));
        fd.append('usuario',$("#usuario").val());
        fd.append('password',$("#pass").val());

        $.ajax({
            url:   'nuevo_login.php',
            type:  'post',
            dataType: "html",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function ()
            {
                $(".loader").show();
            },
            success:  function (response)
            {
                if (response==1)
                {
                    window.location="menu_admin.php";
                }
                else
                {
                    alert('usuario o contraseña incorrecta');
                    $(".loader").fadeOut("slow");
                }
            }
        });
    }
    else
    {
        alert('Porfavor llene ambos campos');
    }
    
}

//Cuando ahi session.
function ActualLogin()
{
    var fd = new FormData(document.getElementById("actual"));
    fd.append('usuario',$("#iconousuario").val());
    fd.append('password',$("#iconopass").val());

    $.ajax({
        url:   'actual_login.php',
        type:  'post',
        dataType: "html",
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function ()
        {
            $(".loader").show();
        },
        success:  function (response)
        {
            if (response==1)
            {
                window.location="menu_admin.php";
            }
        }
    });
}