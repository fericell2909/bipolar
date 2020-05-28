<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\SendContactMessage;
use App\Models\HomePost;
use App\Models\Image;
use App\Models\Settings;
use App\Models\Banner;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use App\Models\Historic;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Jenssegers\Date\Date;

class LandingsController extends Controller
{
    use SEOTools;

    private function addSeoDefault()
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
            ->whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->take(2)
            ->get();

        $settings = Settings::first();
        $imageBackground = Image::whereActive(true)->first();
        $banners = Banner::orderBy('order')
            ->whereNull('background_color')
            ->where('state_id', config('constants.STATE_ACTIVE_ID'))
            ->where('begin_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        if ($banners->count()) {
            $image = $banners->first()->url;
            $this->seo()->opengraph()->setType('article')->addImage($image, ['width' => 1024, 'height' => 680]);
            $this->seo()->twitter()->addImage($image);
        } else {
            $this->addSeoDefault();
        }

        return view('welcome', compact('banners', 'homePosts', 'settings', 'posts', 'imageBackground'));
    }

    public function changeCurrency(Request $request)
    {
        $this->validate($request, ['currency' => 'required|in:PEN,USD']);

        \Session::put('BIPOLAR_CURRENCY', $request->input('currency'));

        return redirect()->back();
    }

    public function historico()
    {
        $this->addSeoDefault();

        $historics = Historic::orderByDesc('order')->get();

        $inverse = false;

        return view('web.landings.historico', compact('historics', 'inverse'));
    }

    public function contact()
    {
        $this->addSeoDefault();

        return view('web.landings.contact');
    }

    public function newsletter()
    {
        $imageBackground = Image::whereActive(true)->first();
        $showBackground = !empty($imageBackground);

        return view('web.landings.newsletter_landing', compact('imageBackground', 'showBackground'));
    }

    public function blog(Request $request)
    {
        $this->addSeoDefault();

        $posts = Post::orderByDesc('created_at')->with([
            'categories',
            'photos' => function ($withPhotos) {
                return $withPhotos->orderBy('order');
            },
        ])
            ->where('state_id', config('constants.STATE_ACTIVE_ID'))
            ->when($request->filled('category'), function ($wherePosts) use ($request) {
                return $wherePosts->whereHas('categories', function ($whereCategory) use ($request) {
                    return $whereCategory->where('slug', $request->input('category'));
                });
            })
            ->when($request->filled('tags'), function ($wherePosts) use ($request) {
                return $wherePosts->whereHas('tags', function ($whereTag) use ($request) {
                    return $whereTag->where('slug', $request->input('tags'));
                });
            })
            ->when($request->filled('archive'), function ($wherePosts) use ($request) {
                $date = explode('-', $request->input('archive'));
                $year = array_first($date);
                $month = array_last($date);

                return $wherePosts->whereYear('created_at', $year)->whereMonth('created_at', $month);
            })
            ->paginate(10);

        $categories = Category::orderBy('name')->get();
        $lastPosts = Post::orderByDesc('created_at')->take(5)->get();
        $tags = Tag::orderBy('name')->get();
        $yearMonthSelect = $this->getDateAndMonthFromPosts();

        return view('web.blog.index', compact('posts', 'categories', 'lastPosts', 'tags', 'yearMonthSelect'));
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
            },
        ]);
        $categories = Category::orderBy('name')->get();
        $lastPosts = Post::orderByDesc('created_at')->take(5)->get();
        $tags = Tag::orderBy('name')->get();
        $yearMonthSelect = $this->getDateAndMonthFromPosts();

        $seoDescription = !empty($post->content) ? str_limit(strip_tags($post->content), 200) : 'Zapatos de diseñador hechos a mano en Perú. Designer shoes handmade in Peru';
        $image = optional($post->photos->first())->url;
        $this->seo()->metatags()->setTitle("{$post->title}")->setDescription($seoDescription);
        $this->seo()->twitter()
            ->setTitle("{$post->title} - Bipolar")
            ->setDescription($seoDescription)
            ->addImage($image);
        $this->seo()->opengraph()
            ->setType('article')
            ->setTitle("{$post->title} - Bipolar")
            ->setDescription($seoDescription)
            ->addImage($image, ['width' => 1024, 'height' => 680]);

        return view('web.blog.post', compact('post', 'categories', 'lastPosts', 'tags', 'yearMonthSelect'));
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

    private function getDateAndMonthFromPosts()
    {
        $yearMonths = \DB::table('posts')
            ->selectRaw("YEAR(created_at) AS year_post, MONTH(created_at) AS month_post")
            ->groupBy('year_post', 'month_post')
            ->orderBy('year_post')
            ->get();
        Date::setLocale(\LaravelLocalization::getCurrentLocale());
        $yearMonthSelect = $yearMonths->mapWithKeys(function ($element) {
            $dateMonth = Date::createFromFormat('Y-m', "{$element->year_post}-{$element->month_post}");

            return ["{$element->year_post}-{$element->month_post}" => mb_strtoupper($dateMonth->format('F Y'))];
        })->prepend(__('bipolar.blog.select_month'), '');

        return $yearMonthSelect;
    }
}
