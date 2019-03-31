<?php
/**
 * Created by PhpStorm.
 * User: arne
 * Date: 31.03.19
 * Time: 15:51
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 *
 * Class LanderController
 *
 * @Controller
 * @Middleware({"web"})
 * @package App\Http\Controllers
 */
class LanderController extends Controller
{

    /**
     *
     * @Get("/", as="lander.index");
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        return view('lander.index');
    }

}