$( document ).ready(function() {
    console.log('Jquery listo!');

    //Validacion de formularios
    var forms = document.querySelectorAll('.needs-validation')

    //Bucle sobre los campos para evitar el envio
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        });

    //Datatable
    $('#listEmpl').dataTable({
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "bProcessing": true,
        "sAjaxSource": "ajax/listEmpl.php",
        "aoColumns": [
            { mData: 'nombre' },
            { mData: 'email' },
            {
                "targets": 0,
                "data": 'sexo',
                "render": function ( data, type, row, meta ) {
                    var sexo;
                    if(data==0){
                        sexo = "Masculino";
                    }else{
                        sexo = "Femenino";
                    }
                    return sexo;
                }
            },
            { mData: 'nombre_area' },
            {
                "targets": 0,
                "data": 'boletin',
                "render": function ( data, type, row, meta ) {
                    var boletin;
                    if(data==0){
                        boletin = "No";
                    }else{
                        boletin = "Si";
                    }
                    return boletin;
                }
            },
            {
                "targets": 0,
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return'<div class="text-center">' +
                        '<a href="?acc=e&id='+data+'" ><i class="fas fa-pencil-alt"></i></a>' +
                        '</div>';
                }
            },
            {
                "targets": 0,
                "data": "id",
                "render": function ( data, type, row, meta ) {
                    return'<div class="text-center">' +
                        '<a href="?acc=d&id='+data+'"><i class="fas fa-trash-alt"></i></a>' +
                        '</div>';
                }
            }
        ]
    });
});