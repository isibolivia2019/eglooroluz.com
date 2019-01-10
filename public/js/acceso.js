function verificarAcceso(privilegio){
    var parametros = {
        "action" : "verificarPrivilegio",
        "privilegio" : privilegio
    };
    $.ajax({
      type:'POST',
      data: parametros,
      url:'app/controladores/Usuarios.php',
      success:function(data){
        datos = JSON.parse(data);
        if(datos.privilegio == -1){
            $.alert({
                title: 'USUARIO NO IDENTIFICADO',
                content: 'Al parecer no se encuentra ningun usuario identificado en este dispositivo, Inicie Sesion porfavor.',
                buttons: {
                    deAcuerdo: {
                        text: 'De Acuerdo',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            location.href = "login.php";
                        }
                    }
                }
            });
        }
        if(datos.privilegio == 0){
            $.alert({
                title: 'MODULO DEL SISTEMA BLOQUEADO',
                content: 'Usted no cuenta con permisos suficientes para ingresar a este modulo del sistema, vuelva a Iniciar Sesion o Contactese con el Administrador.',
                buttons: {
                    deAcuerdo: {
                        text: 'De Acuerdo',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            location.href = "login.php";
                        }
                    }
                }
            });
        }
        if(datos.privilegio == 1){
            $.alert({
                title: 'SE AGOTO EL TIEMPO POR INACTIVIDAD',
                content: 'Por motivos de seguridad cuenta con un tiempo determinado administracion de su sesion. Vuelva a Iniciar Sesion',
                buttons: {
                    deAcuerdo: {
                        text: 'De Acuerdo',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            location.href = "login.php";
                        }
                    }
                }
            });
        }
        if(datos.privilegio == 2){

        }
      }
    })
}