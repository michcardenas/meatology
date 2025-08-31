<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use Illuminate\Http\Request;

class SeoController extends Controller
{


    public function index(Request $request)
    {
        $q = trim((string)$request->get('q',''));

        $paginas = Pagina::query()
            ->when($q, fn($query) =>
                $query->where('pagina','like',"%{$q}%")
                      ->orWhere('slug','like',"%{$q}%")
            )
            ->orderBy('pagina')
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.seo.pages', compact('paginas','q'));
    }

    public function edit(Pagina $pagina)
    {
        // Vista de SEO para esta página (placeholder por ahora)
        return view('dashboard.seo.edit', compact('pagina'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Pagina $pagina)
{
    $data = $request->validate([
        'meta_title'         => ['nullable','string','max:70'],
        'meta_description'   => ['nullable','string','max:160'],
        'meta_keywords'      => ['nullable','string'],
        'canonical_url'      => ['nullable','url'],
        'robots'             => ['nullable','in:index,follow,noindex,follow,index,nofollow,noindex,nofollow'],
        'og_title'           => ['nullable','string','max:95'],
        'og_description'     => ['nullable','string'],
        'og_image'           => ['nullable','string'],
        'og_type'            => ['nullable','in:website,article,product'],
        'og_locale'          => ['nullable','string','max:10'],
        'twitter_card'       => ['nullable','in:summary_large_image,summary,app,player'],
        'twitter_title'      => ['nullable','string','max:70'],
        'twitter_description'=> ['nullable','string','max:200'],
        'twitter_image'      => ['nullable','string'],
        'json_ld'            => ['nullable','string'],
    ]);

    // Parsear JSON-LD si viene
    if (!empty($data['json_ld'])) {
        try {
            $json = json_decode($data['json_ld'], true, 512, JSON_THROW_ON_ERROR);
            $data['json_ld'] = $json;
        } catch (\Throwable $e) {
            return back()->withErrors(['json_ld' => 'JSON inválido'])->withInput();
        }
    }

    $seo = $pagina->seo()->updateOrCreate(
        ['pagina_id' => $pagina->id],
        array_merge($data, []) // $data ya contiene las claves correctas
    );

    return back()->with('status', 'SEO actualizado correctamente.');
}
}