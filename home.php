<!-- home.php -->
<style>
    .custom-menu {
        z-index: 1000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #0000001c;
        border-radius: 5px;
        padding: 8px;
        min-width: 13vw;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    a.custom-menu-list {
        width: 100%;
        display: flex;
        color: #4c4b4b;
        font-weight: 600;
        font-size: 1em;
        padding: 1px 11px;
        align-items: center;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }

    a.custom-menu-list:hover,
    .file-item:hover,
    .file-item.active {
        background: #80808024;
    }

    a.custom-menu-list span.icon {
        width: 1em;
        margin-right: 5px;
    }

    .card {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-icon {
        position: absolute;
        font-size: 3em;
        bottom: .2em;
        right: .5em;
        color: #ffffff80;
    }

    table th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f2f2f2;
    }

    .file-item {
        cursor: pointer;
    }

    .file-item:hover {
        background-color: #f9f9f9;
    }
    .reviewed {
        color: green;
    }
</style>

<div class="container-fluid">
    <?php include('db_connect.php');
    $files = $conn->query("SELECT f.*, u.name as uname, u.area FROM files f INNER JOIN users u ON u.id = f.user_id WHERE f.is_public = 1 ORDER BY date(f.date_updated) DESC");
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card col-md-4 offset-md-1 bg-info text-white mb-4 float-left">
                <div class="card-body">
                    <h4><b>Usuarios</b></h4>
                    <hr>
                    <span class="card-icon"><i class="fa fa-users"></i></span>
                    <h3 class="text-right"><b><?php echo $conn->query('SELECT * FROM users')->num_rows ?></b></h3>
                </div>
            </div>
            <div class="card col-md-4 offset-md-2 bg-primary text-white mb-4 float-left">
                <div class="card-body">
                    <h4><b>Archivos</b></h4>
                    <hr>
                    <span class="card-icon"><i class="fa fa-file"></i></span>
                    <h3 class="text-right"><b><?php echo $conn->query('SELECT * FROM files')->num_rows ?></b></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3 ml-3 mr-3">
        <div class="card col-md-12">
            <div class="card-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Subido por</th>
                            <th width="15%">Área</th>
                            <th width="25%">Nombre del archivo</th>
                            <th width="15%">Fecha</th>
                            <th width="20%">Descripción</th>
                            <th width="10%">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $files->fetch_assoc()):
                            $name = explode(' ||', $row['name']);
                            $name = isset($name[1]) ? $name[0] . " (" . $name[1] . ")." . $row['file_type'] : $name[0] . "." . $row['file_type'];
                            $img_arr = array('png','jpg','jpeg','gif','psd','tif');
                            $doc_arr = array('doc','docx');
                            $pdf_arr = array('pdf','ps','eps','prn');
                            $icon = 'fa-file';
                            if (in_array(strtolower($row['file_type']), $img_arr)) $icon = 'fa-image';
                            if (in_array(strtolower($row['file_type']), $doc_arr)) $icon = 'fa-file-word';
                            if (in_array(strtolower($row['file_type']), $pdf_arr)) $icon = 'fa-file-pdf';
                            if (in_array(strtolower($row['file_type']), ['xlsx','xls','xlsm','xlsb','xltm','xlt','xla','xlr'])) $icon = 'fa-file-excel';
                            if (in_array(strtolower($row['file_type']), ['zip','rar','tar'])) $icon = 'fa-file-archive';
                            $reviewed = ($row['reviewed'] && $row['commented']) ? 'reviewed' : '';
                        ?>
                        <tr class="file-item" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $name ?>">
                            <td><i><?php echo ucwords($row['uname']) ?></i></td>
                            <td><i><?php echo ucwords($row['area']) ?></i></td> <!-- Mostrar el área del usuario -->
                            <td>
                                <large><span><i class="fa <?php echo $icon ?>"></i></span><b> <?php echo $name ?></b></large>
                                <input type="text" class="rename_file" value="<?php echo $row['name'] ?>" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['file_type'] ?>" style="display: none">
                            </td>
                            <td><i><?php echo date('Y/m/d h:i A', strtotime($row['date_updated'])) ?></i></td>
                            <td><i><?php echo $row['description'] ?></i></td>
                            <td class="text-center"><i class="fa fa-check-circle <?php echo $reviewed ?>"></i></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="menu-file-clone" style="display: none;">
    <a href="javascript:void(0)" class="custom-menu-list file-option download"><span><i class="fa fa-download"></i> </span>Descargar</a>
    <a href="javascript:void(0)" class="custom-menu-list file-option review"><span><i class="fa fa-check-circle"></i> </span>Marcar como revisado y comentado</a>
</div>
<script>
    // Menú contextual
    $('.file-item').bind("contextmenu", function(event) {
        event.preventDefault();

        $('.file-item').removeClass('active');
        $(this).addClass('active');
        $("div.custom-menu").hide();
        var custom = $("<div class='custom-menu file'></div>");
        custom.append($('#menu-file-clone').html());
        custom.find('.download').attr('data-id', $(this).attr('data-id'));
        custom.find('.review').attr('data-id', $(this).attr('data-id'));
        custom.appendTo("body");
        custom.css({ top: event.pageY + "px", left: event.pageX + "px" });

        $("div.file.custom-menu .download").click(function(e) {
            e.preventDefault();
            window.open('download.php?id=' + $(this).attr('data-id'));
        });

        $("div.file.custom-menu .review").click(function(e) {
            e.preventDefault();
            start_load();
            $.ajax({
                url: 'ajax.php?action=review_and_comment_file',
                method: 'POST',
                data: {id: $(this).attr('data-id')},
                success: function(resp){
                    if (resp == 1){
                        alert_toast("Archivo marcado como revisado y comentado.", 'success');
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }
                }
            });
        });
    });

    $(document).bind("click", function(event) {
        $("div.custom-menu").hide();
        $('.file-item').removeClass('active');
    });

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            $("div.custom-menu").hide();
            $('.file-item').removeClass('active');
        }
    });
</script>
