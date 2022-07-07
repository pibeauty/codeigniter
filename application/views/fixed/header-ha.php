<link rel="stylesheet" type="text/css"
      href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/menu/menu-types/horizontal-menu.css">
</head>
<body class="horizontal-layout horizontal-menu 2-columns menu-expanded" data-open="hover" data-menu="horizontal-menu"
      data-col="2-columns">
<span id="hdata"
      data-df="<?php echo $this->config->item('dformat2'); ?>"
      data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                <li style="display:none !important;" class="nav-item"><a class="navbar-brand" href="<?= base_url() ?>dashboard/"><img
                                class="brand-logo" alt="logo"
                                src="<?php echo base_url(); ?>userfiles/theme/logo-header.png">
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                  data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                                              href="#"><i class="ft-menu"></i></a></li>


                    <li class="dropdown  nav-item"><a class="nav-link nav-link-label" href="#"
                                                      data-toggle="dropdown"><i
                                    class="ficon ft-map-pin success"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><i
                                                class="ficon ft-map-pin success"></i><?php echo $this->lang->line('Business') . ' ' . $this->lang->line('Location') ?></span>
                                </h6>
                            </li>

                            <li class="dropdown-menu-footer"><span class="dropdown-item text-muted text-center blue"
                                > <?php $loc = location($this->aauth->get_user()->loc);
                                    echo $loc['cname']; ?></span>
                            </li>
                        </ul>
                    </li>
                    <li style="display:none !important;" class="nav-item d-none d-md-block nav-link" ><a href="<?= base_url() ?>pos_invoices/create" class="btn btn-info btn-md t_tooltip" title="Access POS">
                        <i class="icon-handbag"></i><?php echo $this->lang->line('POS') ?> </a>
                    </li>
                    <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#" aria-haspopup="true"
                                                       aria-expanded="false" id="search-input"><i
                                    class="ficon ft-search"></i></a>
                        <div class="search-input">
                            <input class="input" type="text"
                                   placeholder="<?php echo $this->lang->line('Search Customer') ?>"
                                   id="head-customerbox">
                        </div>
                        <div id="head-customerbox-result" class="dropdown-menu ml-5"
                             aria-labelledby="search-input"></div>
                    </li>
                </ul>

                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-bell"></i><span
                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span><span
                                            class="notification-tag badge badge-default badge-danger float-right m-0">New</span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list" id="tasklist"></li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('manager/todo') ?>"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-mail"></i><span
                                    class="badge badge-pill badge-default badge-info badge-default badge-up"><?php echo $this->aauth->count_unread_pms() ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span><span
                                            class="notification-tag badge badge-default badge-warning float-right m-0"><?php echo $this->aauth->count_unread_pms() ?><?php echo $this->lang->line('new') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list">
                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {

                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm  rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time class="media-meta text-muted" datetime="' . $row->{'date_sent'} . '">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                } ?>    </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('messages') ?>"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->aauth->auto_attend()) { ?>
                        <li class="dropdown dropdown-d nav-item">


                            <?php if ($this->aauth->clock()) {

                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon spinner icon-clock"></i><span class="badge badge-pill badge-default badge-success badge-default badge-up">' . $this->lang->line('On') . '</span></a>';

                            } else {
                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon icon-clock"></i><span class="badge badge-pill badge-default badge-warning badge-default badge-up">' . $this->lang->line('Off') . '</span></a>';
                            }
                            ?>

                            <ul class="dropdown-menu dropdown-menu-right border-primary border-lighten-3 text-xs-center">
                                <br><br>
                                <?php echo '<span class="p-1 text-bold-300">' . $this->lang->line('Attendance') . ':</span>';
                                if (!$this->aauth->clock()) {
                                    echo '<a href="' . base_url() . '/dashboard/clock_in" class="btn btn-outline-success  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-on" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('In') . ' <i
                                    class="ficon icon-clock spinner"></i></a>';
                                } else {
                                    echo '<a href="' . base_url() . '/dashboard/clock_out" class="btn btn-outline-danger  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-off" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('Out') . ' </a>';
                                }
                                ?>

                                <br><br>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                        alt="avatar"><i></i></span><span
                                    class="user-name"><?php echo $this->lang->line('Account') ?></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="<?php echo base_url(); ?>user/profile"><i
                                        class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>
                            <a href="<?php echo base_url(); ?>user/attendance"
                               class="dropdown-item"><i
                                        class="fa fa-list-ol"></i><?php echo $this->lang->line('Attendance') ?></a>
                            <a href="<?php echo base_url(); ?>employee/holidays"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Holidays') ?></a>
                            <!-- <a href="<?php echo base_url(); ?>user/holidays"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Holidays') ?></a> -->

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i
                                        class="ft-power"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- Horizontal navigation-->
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border"
     role="navigation" data-menu="menu-wrapper">
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">

        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>dashboard/"><i
                            class="icon-speedometer"></i><span><?= $this->lang->line('Dashboard') ?></span></a>

            </li>
            <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>appoint/?id=0&cusUser=0"><i
                            class="icon-speedometer"></i><span>Customer Appointment</span></a>

            </li>
            <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>appoint/indexCC/?id=0&cusUser=0"><i
                            class="icon-speedometer"></i><span>Appointment</span></a>

            </li>
            <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>services/"><i
                            class="icon-speedometer"></i><span>Services</span></a>

            </li>
            <?php
            if ($this->aauth->premission(1)) { ?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-basket-loaded"></i><span><?php echo $this->lang->line('sales') ?></span></a>
                    <ul class="dropdown-menu">
                        <li style="display:none !important;" class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-paper-plane"></i><?php echo $this->lang->line('pos sales') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>pos_invoices/create"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('New Invoice'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>pos_invoices/create?v2=true"
                                                    data-toggle="dropdown"><?= $this->lang->line('New Invoice'); ?>
                                        V2 - Mobile</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>pos_invoices"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-basket"></i><?php echo $this->lang->line('sales') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>invoices/create"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('New Invoice'); ?></a>
                                </li>

                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>invoices"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                            </ul>
                        </li>


                        <li style="display:none !important;" class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="ft-radio"></i><?php echo $this->lang->line('Subscriptions') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>subscriptions/create"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('New Subscription'); ?></a>
                                </li>

                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>subscriptions"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Subscriptions'); ?></a>
                            </ul>
                        </li>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(3)) {
                ?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-diamond"></i><span><?php echo $this->lang->line('CRM') ?></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="ft-users"></i><?php echo $this->lang->line('Clients') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>customers/create"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('New Client') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>customers"
                                                    data-toggle="dropdown"><?= $this->lang->line('Manage Clients'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>clientgroup"><i
                                        class="icon-grid"></i><?php echo $this->lang->line('Client Groups'); ?></a>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="fa fa-ticket"></i><?php echo $this->lang->line('Support Tickets') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>tickets/?filter=unsolved"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('UnSolved') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>tickets"
                                                    data-toggle="dropdown"><?= $this->lang->line('Manage Tickets'); ?></a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(4)) {
                ?>
                <li style="display:none !important;" class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-briefcase"></i><span><?= $this->lang->line('Project') ?></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-calendar"></i><?php echo $this->lang->line('Project Management') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>projects/addproject"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('New Project') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>projects"
                                                    data-toggle="dropdown"><?= $this->lang->line('Manage Projects'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>tools/todo"><i
                                        class="icon-list"></i><?php echo $this->lang->line('To Do List'); ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            if (!$this->aauth->premission(4) && $this->aauth->premission(7)) {
                ?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-briefcase"></i><span><?php echo $this->lang->line('Project') ?></span></a>
                    <ul class="dropdown-menu">
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>manager/projects"><i
                                        class="icon-calendar"></i><?php echo $this->lang->line('Manage Projects'); ?>
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>manager/todo"><i
                                        class="icon-list"></i><?php echo $this->lang->line('To Do List'); ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(5)) {
                ?>
                <li style="display:none !important;" class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-calculator"></i><span><?= $this->lang->line('Accounts') ?></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-book-open"></i><?php echo $this->lang->line('Accounts') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>accounts"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Manage Accounts') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>accounts/balancesheet"
                                                    data-toggle="dropdown"><?= $this->lang->line('BalanceSheet'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/accountstatement"
                                                    data-toggle="dropdown"><?= $this->lang->line('Account Statements'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-wallet"></i><?php echo $this->lang->line('Transactions') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>transactions"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('View Transactions') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>transactions/add"
                                                    data-toggle="dropdown"><?= $this->lang->line('New Transaction'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>transactions/transfer"
                                                    data-toggle="dropdown"><?= $this->lang->line('New Transfer'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>transactions/income"
                                                    data-toggle="dropdown"><?= $this->lang->line('Income'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>transactions/expense"
                                                    data-toggle="dropdown"><?= $this->lang->line('Expense'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>customers"
                                                    data-toggle="dropdown"><?= $this->lang->line('Clients Transactions'); ?></a>
                                </li>
                            </ul>
                        </li>
 <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>transactions/income"
                                                    data-toggle="dropdown"><i class="fa fa-money"></i><?= $this->lang->line('Income'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>transactions/expense"
                                                    data-toggle="dropdown"><i class="ft-external-link"></i><?= $this->lang->line('Expense'); ?></a>
                                </li>
                    </ul>
                </li>


            <?php }
            if ($this->aauth->premission(10)) {
                ?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-pie-chart"></i><span><?php echo $this->lang->line('Data & Reports') ?></span></a>
                    <ul class="dropdown-menu">
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>register"><i
                                        class="icon-eyeglasses"></i><?php echo $this->lang->line('Business Registers'); ?>
                            </a>
                        </li>

                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-doc"></i><?php echo $this->lang->line('Statements') ?></a>
                            <ul class="dropdown-menu">

                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/accountstatement"
                                                    data-toggle="dropdown"><?= $this->lang->line('Account Statements'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/customerstatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Customer') . ' ' . $this->lang->line('Account Statements') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/supplierstatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Supplier') . ' ' . $this->lang->line('Account Statements') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/taxstatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('TAX') . ' ' . $this->lang->line('Statements'); ?></a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-bar-chart"></i><?php echo $this->lang->line('Graphical Reports') ?>
                            </a>
                            <ul class="dropdown-menu">

                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>chart/product_cat"
                                                    data-toggle="dropdown"><?= $this->lang->line('Product Categories'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>chart/trending_products"
                                                    data-toggle="dropdown"><?= $this->lang->line('Trending Products'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/profit"
                                                    data-toggle="dropdown"><?= $this->lang->line('Profit'); ?></a>
                                </li>

                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>chart/topcustomers"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Top') . ' ' . $this->lang->line('Customers') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/incvsexp"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Income') . ' vs ' . $this->lang->line('Expenses') ?></a>
                                </li>

                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/income"
                                                    data-toggle="dropdown"><?= $this->lang->line('Income'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>chart/expenses"
                                                    data-toggle="dropdown"><?= $this->lang->line('Expenses'); ?></a>


                            </ul>
                        </li>
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="icon-bulb"></i><?php echo $this->lang->line('Summary') . ' & ' . $this->lang->line('Report') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/statistics"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Statistics') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/profitstatement"
                                                    data-toggle="dropdown"><?= $this->lang->line('Profit'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/incomestatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Calculate Income'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/expensestatement"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Calculate Expenses') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>reports/sales"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Sales') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/products"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Products') ?></a>
                                </li>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>reports/commission"
                                                    data-toggle="dropdown"><?= $this->lang->line('Employee'); ?> <?= $this->lang->line('Commission'); ?></a>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(6)) {
                ?>
                <li style="display:none !important;" class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="icon-note"></i><span><?php echo $this->lang->line('Miscellaneous') ?></span></a>
                    <ul class="dropdown-menu">
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>tools/notes"><i
                                        class="icon-note"></i><?php echo $this->lang->line('Notes'); ?></a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>events"><i
                                        class="icon-calendar"></i><?php echo $this->lang->line('Calendar'); ?></a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>tools/documents"><i
                                        class="icon-doc"></i><?php echo $this->lang->line('Documents'); ?></a>
                        </li>


                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(9)) {
                ?>
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                                                      data-toggle="dropdown"><i
                                class="ft-file-text"></i><span><?php echo $this->lang->line('HRM') ?></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="ft-users"></i><?php echo $this->lang->line('Employees') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>employee"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('Employees') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>employee/roles"
                                                    data-toggle="dropdown">providing services</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/permissions"
                                                    data-toggle="dropdown"><?= $this->lang->line('Permissions'); ?></a>
                                </li>
                                <li style="display:none !important;" data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/salaries"
                                                    data-toggle="dropdown"><?= $this->lang->line('Salaries'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/attendances"
                                                    data-toggle="dropdown"><?= $this->lang->line('Attendance'); ?></a>
                                </li>
                                <li style="display:none !important;" data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/holidays"
                                                    data-toggle="dropdown"><?= $this->lang->line('Holidays'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li style="display:none !important;" data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/departments"><i
                                        class="icon-folder"></i><?php echo $this->lang->line('Departments'); ?></a>
                        </li>
                        <li style="display:none !important;" data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/payroll"><i
                                        class="icon-notebook"></i><?php echo $this->lang->line('Payroll'); ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            ?>

        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>
<!-- Horizontal navigation-->
<div id="c_body"></div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">