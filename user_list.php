<?php
    /* Connect to an ODBC database using driver invocation */
    $dsn = 'mysql:dbname=backend;host=127.0.0.1';
    $user = 'root';
    $password = '';

    try {
        $dbh = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
    // 获取当前页码
    $page_number = isset($_GET['p']) ? intval($_GET['p']) : 1;

    // 获取用户数量
    $count_statement = $dbh->query('SELECT COUNT(*) AS `count` FROM `user`');
    $user_count = $count_statement->fetch(PDO::FETCH_ASSOC)['count'];

    // 获取页数
    $page_count = ceil($user_count / 3);

    // 是否有上一页
    $has_prev = false;
    if ($page_number > 1) {
        $has_prev = true;
    }

    // 是否有下一页
    $has_next = false;
    if ($page_number < $page_count) {
        $has_next = true;
    }

    // 当前页用户列表
    $count_statement = $dbh->query('SELECT `id`, `user`, `email`, `role` FROM `user` LIMIT ' . (($page_number - 1) * 3) . ', 3');
    $user_list = $count_statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="renderer" content="webkit"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>后台管理</title>
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script type="text/javascript" src="dist/js/html5shiv.min.js"></script>
        <script type="text/javascript" src="dist/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini" onresize="update()">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="javascript:void(0);" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>后</b>管</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>后台</b>管理</span>
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/user2-160x160.jpg" class="user-image">
                                    <span class="hidden-xs">xxx</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle">

                                        <p>
                                            用户名：<br>
                                            <small>
                                                权限：
                                            </small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="" class="btn btn-default btn-flat">退出</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header><!-- Left side column. contains the logo and sidebar -->

            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle">
                        </div>
                        <div class="pull-left info">
                            <p>xxx</p>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li id="overview" class="active">
                            <a href="demo.html">
                                <i class="fa fa-circle"></i><span>概览</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="javascript:void(0);">
                                <i class="fa fa-circle"></i><span>xxx</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="">
                                        <i class="fa fa-circle-o"></i><span>yyy</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <div class="content-wrapper">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>邮箱</th>
                        <th>权限</th>
                    </thead>
                    <tbody>
                        <?php foreach ($user_list as $v): ?>
                        <tr>
                            <td><?= $v['id'] ?></td>
                            <td><?= $v['user'] ?></td>
                            <td><?= $v['email'] ?></td>
                            <td><?= $v['role'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($has_prev): ?>
                                <li>
                                    <a href="user_list.php?p=<?= $page_number - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php for ($page_index = 1; $page_index <= $page_count; ++ $page_index): ?>
                                <?php if ($page_index === $page_number): ?>
                                    <li class="active"><a href="user_list.php?p=<?= $page_index ?>"><?= $page_index ?></a></li>
                                <?php else: ?>
                                    <li><a href="user_list.php?p=<?= $page_index ?>"><?= $page_index ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($has_next): ?>
                                <li>
                                    <a href="user_list.php?p=<?= $page_number + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                update();
            });

            function update() {
                $('.content-wrapper').css('min-height', $(window).height() - 50);
            }
        </script>
    </body>
</html>
