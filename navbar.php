<style>
    #sidebar {
        width: 250px;
        position: fixed;
        height: 100%;
        background-color: #343a40;
        padding-top: 20px;
    }

    .sidebar-list {
        padding-left: 0;
    }

    .sidebar-list .nav-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        font-size: 16px;
        color: #c2c7d0;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }

    .sidebar-list .nav-item:hover {
        background-color: #495057;
        color: #ffffff;
    }

    .sidebar-list .nav-item.active {
        background-color: #007bff;
        color: #ffffff;
    }

    .sidebar-list .nav-item .icon-field {
        margin-right: 10px;
    }

    .sidebar-list .nav-item .icon-field i {
        font-size: 20px;
    }
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark'>
    <div class="sidebar-list">
        <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
        <a href="index.php?page=files" class="nav-item nav-files"><span class='icon-field'><i class="fa fa-file"></i></span> Files</a>
        <?php if($_SESSION['login_type'] == 1): ?>
        <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
        <?php endif; ?>
    </div>
</nav>

<script>
    document.querySelector('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').classList.add('active');
</script>
