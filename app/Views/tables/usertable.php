<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.7/b-3.0.2/sl-2.0.2/datatables.min.css" />
    <link rel="stylesheet" href="Editor-PHP-2.3.2/css/editor.dataTables.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <!-- Thêm thư viện jQuery -->
    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-2.0.7/b-3.0.2/sl-2.0.2/datatables.min.js"></script>
    <script src="Editor-PHP-2.3.2/js/dataTables.editor.js"></script>
</head>

<body>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function() {
            var editor = new $.fn.dataTable.Editor({
                ajax: {
                    create: {
                        type: 'POST',
                        url: '<?= base_url('api/users') ?>'
                    },
                    edit: {
                        type: 'PUT',
                        url: '<?= base_url('api/users') ?>'
                    },
                    remove: {
                        type: 'DELETE',
                        url: '<?= base_url('api/users?id={id}') ?>'
                    }
                },
                table: "#example",
                idSrc: "id",
                fields: [{
                        label: 'Id',
                        name: 'id'
                    },
                    {
                        label: 'Name',
                        name: 'name'
                    },
                    {
                        label: 'Email',
                        name: 'email'
                    },
                    {
                        label: 'Created At',
                        name: 'created_at'
                    },
                    {
                        label: 'Updated At',
                        name: 'updated_at'
                    },
                ]
            });

            $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "<?= base_url('api/users') ?>",
                    type: "GET"
                },
                "columns": [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'created_at',
                        type: 'datetime'
                    },
                    {
                        data: 'updated_at',
                        type: 'datetime'
                    }
                ],
                "layout": {
                    topStart: {
                        buttons: [{
                                extend: 'create',
                                editor: editor
                            },
                            {
                                extend: 'edit',
                                editor: editor
                            },
                            {
                                extend: 'remove',
                                editor: editor
                            }
                        ]
                    }
                },
                "select": true
            });

            $('#example').on('click', 'tbody td:not(:first-child, :last-child)', function(e) {
                editor.inline(this);
            });
        });
    </script>
</body>

</html>