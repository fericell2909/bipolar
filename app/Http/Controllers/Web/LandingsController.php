<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SendContactMessage;
use App\Models\HomePost;
use App\Models\Settings;
use App\Models\Banner;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use App\Models\Historic;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class LandingsController extends Controller
{
    use SEOTools;

    public function __construct()
    {
        $imageUrl = asset('storage/bipolar-images/assets/jeringas-rosado.jpg');
        $this->seo()->opengraph()->addImage($imageUrl);
        $this->seo()->twitter()->addImage($imageUrl);
    }

    public function home()
    {
        $homePosts = HomePost::whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->with(['photos' => function ($withPhotos) {
                $withPhotos->orderBy('order');
            }, 'post_type'])
            ->orderBy('order')
            ->get();
        $posts = Post::orderByDesc('id')->with(['photos' => function ($withPhotos) {
            $withPhotos->orderBy('order');
        }])
            ->take(2)
            ->get();

        $settings = Settings::first();
        $banners = Banner::orderBy('order')
            ->where('state_id', config('constants.STATE_ACTIVE_ID'))
            ->where('begin_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('welcome', compact('banners', 'homePosts', 'settings', 'posts'));
    }

    public function changeCurrency(Request $request)
    {
        $this->validate($request, ['currency' => 'required|in:PEN,USD']);

        \Session::put('BIPOLAR_CURRENCY', $request->input('currency'));

        return redirect()->back();
    }

    public function bipolar()
    {
        return view('web.landings.bipolar');
    }

    public function shipping()
    {
        return view('web.landings.shipping');
    }

    public function showroom()
    {
        return view('web.landings.showroom');
    }

    public function historico()
    {
        $historics = Historic::orderByDesc('order')->get();

        $inverse = false;

        return view('web.landings.historico', compact('historics', 'inverse'));
    }

    public function contact()
    {
        return view('web.landings.contact');
    }

    public function blog()
    {
        $posts = Post::orderByDesc('created_at')->with([
            'categories',
            'photos' => function ($withPhotos) {
                return $withPhotos->orderBy('order');
            }
        ])
            ->where('state_id', config('constants.STATE_ACTIVE_ID'))
            ->paginate(10);
        $categories = Category::orderBy('name')->get();
        $lastPosts = Post::orderByDesc('created_at')->take(5)->get();
        $tags = Tag::orderBy('name')->get();

        return view('web.blog.index', compact('posts', 'categories', 'lastPosts', 'tags'));
    }

    public function seeBlogPost($postSlug)
    {
        /** @var Post $post */
        $post = Post::findBySlugOrFail($postSlug);

        abort_if($post->state_id !== config('constants.STATE_ACTIVE_ID'), 404);

        $post->load([
            'categories',
            'photos' => function ($withPhotos) {
                return $withPhotos->orderBy('order');
            }
        ]);
        $categories = Category::orderBy('name')->get();
        $lastPosts = Post::orderByDesc('created_at')->take(5)->get();
        $tags = Tag::orderBy('name')->get();

        $seoDescription = !empty($post->content) ? $post->content : 'Zapatos de diseñador hechos a mano en Perú. Designer shoes handmade in Peru';
        $image = optional($post->photos->first())->url;
        \SEO::metatags()->setTitle("{$post->title}")->setDescription($seoDescription);
        \SEO::twitter()
            ->setTitle("{$post->title} - Bipolar")
            ->setDescription($seoDescription)
            ->addImage($image);
        \SEO::opengraph()
            ->setType('article')
            ->setTitle("{$post->title} - Bipolar")
            ->setDescription($seoDescription)
            ->addImage($image, ['width'  => 1024, 'height' => 680]);

        return view('web.blog.post', compact('post', 'categories', 'lastPosts', 'tags'));
    }

    public function contactProcess(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required|between:1,255',
            'email'   => 'required|email|between:1,255',
            'message' => 'required',
        ]);

        $request->session()->flash('sent_message', true);

        \Mail::to('shop@bipolar.com.pe')->send(
            new SendContactMessage(
                $request->input('name'),
                $request->input('email'),
                $request->input('message')
            )
        );

        return redirect()->back();
    }
}
