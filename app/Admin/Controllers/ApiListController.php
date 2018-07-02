<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2018/7/2
 * Time: 10:27
 */

namespace App\Admin\Controllers;


use App\FactoryCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiListController extends Controller
{

    public function factoryCodes(Request $request)
    {
        $q = $request->get('q');

        return FactoryCode::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

}