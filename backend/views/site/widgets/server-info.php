<div class="box box-warning direct-chat direct-chat-warning">
    <div class="box-header with-border">
        <i class="fa fa-server"></i>
        <h3 class="box-title">Информация о сервере</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

                <ul class="server_info">
                    <li>
                        IP адрес сервера
                        <span class="pull-right text-green"><?=$serverInfo['server_ip']?></span>
                    </li>
                    <li>
                        ОС
                        <span class="pull-right text-green"><?=$serverInfo['os_version']?></span>
                    </li>
                    <li>
                        Свободно на диске
                        <span class="pull-right text-green"><?=$serverInfo['disc_free_space']?></span>
                    </li>
                    <li>
                        Версия PHP
                        <span class="pull-right text-green"><?=$serverInfo['php_version']?></span>
                    </li>
                    <li>
                        PHP Memory Limit
                        <span class="pull-right text-green"><?=$serverInfo['max_memory']?></span>
                    </li>
                    <li>
                        PHP Safe Mode
                        <span class="pull-right text-green"><?=$serverInfo['safe_mode']?></span>
                    </li>
                    <li>
                        Mod Rewrite
                        <span class="pull-right text-green"><?=$serverInfo['mod_rewrite']?></span>
                    </li>
                    <li>
                        Библиотека GD
                        <span class="pull-right text-green"><?=$serverInfo['gd_version']?></span>
                    </li>
                    <li>
                        Upload Size
                        <span class="pull-right text-green"><?=$serverInfo['max_upload']?></span>
                    </li>
                    <li>
                        Версия MySQL
                        <span class="pull-right text-green"><?=$serverInfo['mysql_version']?></span>
                    </li>
                    <li>
                        База данных
                        <span class="pull-right text-green"><?=$serverInfo['mysql_db']?></span>
                    </li>
                    <li>
                        Размер БД
                        <span class="pull-right text-green"><?=$serverInfo['mysql_size']?></span>
                    </li>
                </ul>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        &nbsp;
    </div>
    <!-- /.box-footer-->
</div>