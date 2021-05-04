<?php

namespace App\Http\Controllers\FORUM;

use Auth;
use App\ForumModels\Models;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller as Controller;

class ChatterController extends Controller
{
    public function index($slug = '',Request $request)
    {
        $pagination_results = config('chatter.paginate.num_of_results');

            
        $category=null;

        if (!empty($slug)) {
            $category = Models::category()->where('slug', '=', $slug)->first();
            if (isset($category->id)) {
                $discussions = Models::discussion()
                ->where('title','like','%'.$request->q.'%')
                ->with('user')->with('post')->with('postsCount')->with('category')->where('chatter_category_id', '=', $category->id)->orderBy('created_at', 'DESC')->paginate($pagination_results);
            }


        }else{

            $discussions = Models::discussion()
            ->where('title','like','%'.$request->q.'%')
            ->with('user')
            ->with('post')
            ->with('postsCount')
            ->with('category')
            ->orderBy('created_at', 'DESC')->paginate($pagination_results);


        }

        $categories = Models::category()->all();
        $chatter_editor = config('chatter.editor');

        // Dynamically register markdown service provider
        \App::register('GrahamCampbell\Markdown\MarkdownServiceProvider');


        return view('chatter::home', compact('discussions', 'categories', 'chatter_editor','category'));
    }

    public function login()
    {
        if (!Auth::check()) {
            return \Redirect::to('/'.config('chatter.routes.login').'?redirect='.config('chatter.routes.home'))->with('flash_message', 'Please create an account before posting.');
        }
    }

    public function register()
    {
        if (!Auth::check()) {
            return \Redirect::to('/'.config('chatter.routes.register').'?redirect='.config('chatter.routes.home'))->with('flash_message', 'Please register for an account.');
        }
    }
}
