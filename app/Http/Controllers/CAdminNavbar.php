<?php
/**
 * @author: MD. ADAL KAHN 
 * <mdadalkhan@gmail.com>
 * */

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CAdminNavbar extends Controller {
    public function hostel():   View { return view('admin.nav_hostel');  }
    public function report():   View { return view('admin.nav_report');  }
    public function checkout(): View { return view('admin.nav_checkout');}
}