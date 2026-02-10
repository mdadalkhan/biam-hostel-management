<?php
/**
 * @author: MD. ADAL KAHN <mdadalkhan@gmail.com>
 * @created_at 02/02/2026
 * @updated_at 10/02/2026
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