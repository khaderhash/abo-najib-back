<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiResponseTrait;
use function Pest\Laravel\get;

class GoalController extends Controller

{

    use ApiResponseTrait;
    public function index(){
    $goal=Goal::get();
    return $this->ApiResponseTrait($goal,'ok',200);
}
}
