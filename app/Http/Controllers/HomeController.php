<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Media;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  // public function __construct()
  // {
  //   $this->middleware(['auth', 'verified']);
  // }

  /**
   * Show the application landing page.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index(Request $request)
  {
    if (isset($request->path) && $request->path == 'dashboard') {
      return $this->showDashboard();
    } else {
      return view('landing.index')
        ->with("categories", $this->getLandingResource()['categories'])
        ->with("tags", $this->getLandingResource()['tags'])
        ->with("photos", $this->getLandingResource(isset($request->search) ? $request->search : '')['photos']);
    }
  }

  public function showAboutPage()
  {
    return view('landing.about');
  }

  public function showContactPage()
  {
    return view('landing.contact');
  }


  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function showDashboard()
  {
    if (Auth::check()) {
      if (!Auth::user()->hasRole('admin')) {
        $dashboard_info = $this->getUserDashboardInfo();
        return view('pages.index')->with('dashboard', $dashboard_info);
      } else if (!Auth::user()->hasRole('user')) {
        $dashboard_info = $this->getUserDashboardInfo();
        return view('pages.index')->with('dashboard', $dashboard_info);
      } else {
        toast('error', 'Unauthorized access! please contact the admin if challenge persist');
        return redirect()->route("home"); // $this->index(new Request(['route' => 'landing']));
      }
    } else {
      toast('error', 'Please login to continue!');
      $this->index(new Request(['route' => 'landing']));
    }
  }

  public function getLandingResource($search = "")
  {
    $categories = Category::all();
    $tags = Tag::all();
    $media = Media::public()->published()->orderBy("updated_at", "desc")->paginate(16);
    if ($search !== "") {
      $media = Media::public()
        ->published()
        ->where('name', 'LIKE', '%' . $search . '%')
        ->orWhere('description', 'LIKE', '%' . $search . '%')
        ->orderBy("updated_at", "desc")
        ->paginate(16);
    }

    return [
      "categories" => $categories,
      "tags" => $tags,
      "photos" => $media,
    ];
  }

  public function getUserDashboardInfo()
  {
    $photos = Media::with(['user', 'category', 'tags'])
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
    return ['photos' => $photos];
  }

  public function getAdminDashboardInfo()
  {
    $photos = Media::with(['user', 'category', 'tags'])
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
    return ['photos' => $photos];
  }
}
