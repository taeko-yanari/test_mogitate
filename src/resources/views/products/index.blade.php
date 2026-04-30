@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="product-index">
    <section class="product-index__section">
        <div class="product-index__wrapper">
            <header class="product-index__header">
                {{-- 商品検索 --}}
                <h1 class="page-title">商品一覧</h1>
                <form action="{{ route('products.search') }}" method="get" class="product-search__form">
                    <input type="text" name="keyword" id="keyword" placeholder="商品名で検索" class="product-search__input" value="{{ request('keyword') }}">
                    <button type="submit" class="product-search__submit">検索</button>

                    {{-- 価格順 --}}
                    <div class="product-sort">
                        <label for="sort" class="product-sort__label">価格順で表示</label>
                        <div class="product-sort__select-wrap">
                            <select name="sort" id="sort" class="product-sort__select" onchange="this.form.submit()">
                                <option value="">価格順で並び替え</option>
                                <option value="price-asc" {{ request('sort') === 'price-asc' ? 'selected' : '' }}>価格が安い順</option>
                                <option value="price-desc" {{ request('sort') === 'price-desc' ? 'selected' : '' }}>価格が高い順</option>
                            </select>
                        </div>

                        {{-- 価格順設定のモーダル --}}
                        <div class="sort-modal">
                            <div class="sort-modal__overlay"></div>
                            <div class="sort-modal__content">
                                <ul class="sort-modal__list">
                                    @if(request('sort') === 'price-desc')
                                    <li class="sort-modal__item">
                                        <span class="sort-modal__label">高い順に表示</span>
                                        <a href="{{ route('products.index', ['keyword' => request('keyword')]) }}" class="sort-modal__close">×</a>
                                    </li>
                                    @endif

                                    @if(request('sort') === 'price-asc')
                                    <li class="sort-modal__item">
                                        <span class="sort-modal__label">低い順に表示</span>
                                        <a href="{{ route('products.index', ['keyword' => request('keyword')]) }}" class="sort-modal__close">×</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </header>

            {{-- 商品一覧 --}}
            <div class="product-list">
                <div class="product-list__add">
                    <a href="{{ route('products.register') }}" class="product-list__add-button">商品を追加</a>
                </div>
                <div class="product-list__wrapper">
                    @foreach ($products as $product)
                    <article class="product-card">
                        <a href="{{ route('products.detail', ['id' => $product->id]) }}" class="product-card__link">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-card__image">
                            <div class="product-card__info">
                                <h2 class="product-card__name">{{ $product->name }}</h2>
                                <p class="product-card__price">&yen;{{ $product->price }}</p>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>

                {{-- ページネーション --}}
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script src="{{ asset('js/sort-modal.js') }}"></script>
@endsection