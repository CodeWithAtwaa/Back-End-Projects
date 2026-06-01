<?php
use Http\Models\DashboardModel;

$dashboard = new DashboardModel();

return view('Dashboard/dashboard', $dashboard->overviewForCurrentUser(true));
